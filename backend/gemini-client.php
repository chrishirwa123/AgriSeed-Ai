<?php
/**
 * Minimal client for the Google Gemini API (generateContent).
 * Docs: https://ai.google.dev/api/generate-content
 */

require_once __DIR__ . '/config.php';

class AiClientException extends Exception {}

/**
 * Builds the right "thinking" config for the configured model family.
 * Gemini 2.5 models support turning thinking fully off (thinkingBudget: 0),
 * which frees the whole token budget for the actual answer and is faster.
 * Gemini 3.x models can't fully disable thinking, but can be set to "low"
 * to minimize how much of the budget thinking eats into.
 */
function gemini_thinking_config(): ?array {
    if (strpos(GEMINI_MODEL, 'gemini-2.5') === 0 || strpos(GEMINI_MODEL, 'gemini-2.0') === 0) {
        return ['thinkingBudget' => 0];
    }
    if (strpos(GEMINI_MODEL, 'gemini-3') === 0) {
        return ['thinkingLevel' => 'low'];
    }
    return null; // Unknown/future model family — let Gemini use its default.
}

/**
 * Calls Gemini with a system prompt and a list of messages.
 *
 * @param string $system   System prompt (persona + instructions)
 * @param array  $messages [['role'=>'user'|'assistant', 'content'=> string|array of parts], ...]
 *                          A string content becomes a single text part.
 *                          An array content is used as-is as Gemini "parts"
 *                          (e.g. built with gemini_image_block() + a text part).
 * @param int    $maxTokens
 * @return string          The model's text reply
 * @throws AiClientException
 */
function gemini_chat(string $system, array $messages, int $maxTokens = 2048): string {
    if (empty(GEMINI_API_KEY)) {
        throw new AiClientException('missing_api_key');
    }

    $contents = [];
    foreach ($messages as $msg) {
        $role = ($msg['role'] ?? 'user') === 'assistant' ? 'model' : 'user';
        $content = $msg['content'] ?? '';
        $parts = is_array($content) ? $content : [['text' => (string) $content]];
        $contents[] = ['role' => $role, 'parts' => $parts];
    }

    $generationConfig = ['maxOutputTokens' => $maxTokens];
    $thinkingConfig = gemini_thinking_config();
    if ($thinkingConfig !== null) {
        $generationConfig['thinkingConfig'] = $thinkingConfig;
    }

    $payload = [
        'system_instruction' => ['parts' => [['text' => $system]]],
        'contents' => $contents,
        'generationConfig' => $generationConfig,
    ];

    $result = gemini_request($payload);

    // If the model ran out of room (thinking + answer exceeded the budget),
    // retry once with a much larger budget instead of returning a cut-off reply.
    if ($result['finishReason'] === 'MAX_TOKENS' && empty($result['text'])) {
        $payload['generationConfig']['maxOutputTokens'] = max($maxTokens * 3, 4096);
        $result = gemini_request($payload);
    }

    if ($result['text'] === '') {
        if ($result['finishReason'] === 'SAFETY') {
            throw new AiClientException('blocked_by_safety_filter');
        }
        throw new AiClientException('empty_response' . ($result['finishReason'] ? " (finishReason: {$result['finishReason']})" : ''));
    }

    return $result['text'];
}

/**
 * Low-level single request to Gemini's generateContent endpoint.
 * Returns ['text' => string, 'finishReason' => ?string].
 */
function gemini_request(array $payload): array {
    $body = json_encode($payload);
    $url = GEMINI_API_BASE . '/' . GEMINI_MODEL . ':generateContent';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-goog-api-key: ' . GEMINI_API_KEY,
        ],
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_TIMEOUT => 60,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        throw new AiClientException('network_error: ' . $curlError);
    }

    $decoded = json_decode($response, true);

    if ($httpCode !== 200) {
        $msg = $decoded['error']['message'] ?? ('http_' . $httpCode);
        throw new AiClientException('api_error: ' . $msg);
    }

    $candidate = $decoded['candidates'][0] ?? null;
    $finishReason = $candidate['finishReason'] ?? null;
    $textParts = [];
    foreach (($candidate['content']['parts'] ?? []) as $part) {
        if (isset($part['text'])) {
            $textParts[] = $part['text'];
        }
    }

    return ['text' => implode("\n", $textParts), 'finishReason' => $finishReason];
}

/**
 * Builds a Gemini inline image part from a base64 string.
 */
function gemini_image_block(string $base64Data, string $mimeType): array {
    return [
        'inlineData' => [
            'mimeType' => $mimeType,
            'data' => $base64Data,
        ],
    ];
}