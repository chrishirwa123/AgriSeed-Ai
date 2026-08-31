<?php
/**
 * POST /backend/ai.php
 * JSON body:
 * {
 *   "mode": "chat" | "crop" | "irrigation",
 *   "message": "user text (chat mode)",
 *   "history": [{"role":"user"|"assistant","content":"..."}, ...]  (chat mode, optional),
 *   "language": "en" | "rw" | "auto",
 *   "context": { ... free-form location/weather/form data ... }
 * }
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/gemini-client.php';

header('Access-Control-Allow-Origin: null'); // same-origin only, see config.php
agriseed_json_headers();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    agriseed_send_error(405, 'Method not allowed.');
}

agriseed_check_rate_limit('ai');

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
if (!is_array($input)) {
    agriseed_send_error(400, 'Invalid request.');
}

$mode = $input['mode'] ?? 'chat';
$language = $input['language'] ?? 'auto';
$context = is_array($input['context'] ?? null) ? $input['context'] : [];

function language_instruction(string $language): string {
    switch ($language) {
        case 'rw':
            return "Respond in clear, natural Kinyarwanda. Keep common agricultural terms that farmers already use rather than inventing awkward translations.";
        case 'en':
            return "Respond in clear, plain English.";
        default:
            return "Detect the language of the user's own message (English or Kinyarwanda, or a natural mix of both) and respond in that same language. If mixed, respond in whichever language dominates the message. Never force a translation of common agricultural terms into unnatural wording.";
    }
}

function base_persona(string $language): string {
    return "You are AgriSeed AI, a practical agriculture assistant for farmers, part of the AgriSeed Rover project. "
        . "You are friendly, respectful, and focused on being genuinely useful to smallholder and commercial farmers alike. "
        . "Rules you always follow:\n"
        . "- Be practical and clear. Avoid unnecessary jargon. Do not be unnecessarily verbose.\n"
        . "- Always briefly explain WHY behind a recommendation, not just WHAT to do.\n"
        . "- If you are uncertain, say so plainly rather than inventing facts.\n"
        . "- Ask a short follow-up question ONLY when missing information would materially change your answer.\n"
        . "- For pesticides, fertilizers, or chemicals: never give dangerous or unsupported dosing instructions. "
        . "Encourage following product labels and local agricultural extension guidance.\n"
        . "- Never claim to have live sensor or satellite data you were not actually given.\n"
        . "- You are an agriculture assistant, not a general-purpose chatbot — politely redirect unrelated questions back to farming topics.\n"
        . language_instruction($language);
}

try {
    if ($mode === 'chat') {
        $message = trim((string) ($input['message'] ?? ''));
        if ($message === '') {
            agriseed_send_error(400, 'Please type a question.');
        }

        $history = is_array($input['history'] ?? null) ? $input['history'] : [];
        $messages = [];
        foreach ($history as $turn) {
            if (!isset($turn['role'], $turn['content'])) continue;
            $role = $turn['role'] === 'assistant' ? 'assistant' : 'user';
            $messages[] = ['role' => $role, 'content' => (string) $turn['content']];
        }

        $locationNote = '';
        if (!empty($context['locationLabel'])) {
            $locationNote = "\n\n[Known farmer location: " . $context['locationLabel'] . "]";
        }
        if (!empty($context['weatherSummary'])) {
            $locationNote .= "\n[Known current weather: " . $context['weatherSummary'] . "]";
        }

        $messages[] = ['role' => 'user', 'content' => $message . $locationNote];

        $system = base_persona($language) . "\n\nKeep replies focused and conversational, roughly 3-8 sentences unless the question needs a longer structured answer (e.g. step-by-step instructions).";

        $reply = gemini_chat($system, $messages, 700);
        echo json_encode(['success' => true, 'reply' => $reply]);
        exit;
    }

    if ($mode === 'crop') {
        $fields = [
            'location' => $context['location'] ?? null,
            'soilType' => $context['soilType'] ?? null,
            'temperature' => $context['temperature'] ?? null,
            'rainfall' => $context['rainfall'] ?? null,
            'season' => $context['season'] ?? null,
            'waterAvailability' => $context['waterAvailability'] ?? null,
            'farmSize' => $context['farmSize'] ?? null,
            'previousCrop' => $context['previousCrop'] ?? null,
            'goal' => $context['goal'] ?? null,
        ];
        $filled = array_filter($fields, fn($v) => $v !== null && $v !== '');
        if (empty($filled)) {
            agriseed_send_error(400, 'Please provide at least location and season to get recommendations.');
        }

        $lines = [];
        foreach ($filled as $k => $v) { $lines[] = "$k: $v"; }
        $details = implode("\n", $lines);

        $system = base_persona($language) . "\n\n"
            . "TASK: Recommend 3 to 5 suitable crops based on the farmer's details below. "
            . "For EACH crop, give: crop name, suitability (High/Medium/Low), a short reason grounded in the given conditions, "
            . "basic growing requirements, water requirements, and important considerations/risks. "
            . "Base your reasoning on the actual details given — do not ignore them in favor of generic advice. "
            . "If key details are missing, briefly note what more would sharpen the recommendation, but still give your best answer with what's provided. "
            . "Format the answer with clear numbered sections per crop, plain text (no markdown tables).";

        $messages = [['role' => 'user', 'content' => "Farmer details:\n" . $details]];
        $reply = gemini_chat($system, $messages, 1000);
        echo json_encode(['success' => true, 'reply' => $reply]);
        exit;
    }

    if ($mode === 'irrigation') {
        $fields = [
            'crop' => $context['crop'] ?? null,
            'growthStage' => $context['growthStage'] ?? null,
            'soilType' => $context['soilType'] ?? null,
            'temperature' => $context['temperature'] ?? null,
            'humidity' => $context['humidity'] ?? null,
            'recentRainfall' => $context['recentRainfall'] ?? null,
            'waterAvailability' => $context['waterAvailability'] ?? null,
            'soilMoisture' => $context['soilMoisture'] ?? null,
        ];
        $filled = array_filter($fields, fn($v) => $v !== null && $v !== '');
        if (empty($filled)) {
            agriseed_send_error(400, 'Please provide at least the crop and recent rainfall/soil info.');
        }

        $lines = [];
        foreach ($filled as $k => $v) { $lines[] = "$k: $v"; }
        $details = implode("\n", $lines);

        $system = base_persona($language) . "\n\n"
            . "TASK: Give irrigation guidance based on the details below. Cover: whether irrigation currently seems needed, "
            . "suggested timing, key factors driving the recommendation, warning signs of overwatering, and warning signs of underwatering. "
            . "Explicitly state that this is general guidance, not an exact scientific measurement, and that real irrigation needs depend on "
            . "the specific crop, soil, weather and field conditions. Do not overstate precision.";

        $messages = [['role' => 'user', 'content' => "Field details:\n" . $details]];
        $reply = gemini_chat($system, $messages, 800);
        echo json_encode(['success' => true, 'reply' => $reply]);
        exit;
    }

    agriseed_send_error(400, 'Unknown mode.');

} catch (AiClientException $e) {
    $msg = $e->getMessage();
    if (strpos($msg, 'missing_api_key') === 0) {
        agriseed_send_error(503, 'AgriSeed AI is not fully configured yet (missing AI API key). See README for setup.', $msg);
    }
    agriseed_send_error(502, 'AgriSeed AI is temporarily unavailable. Please try again.', $msg);
} catch (Throwable $e) {
    agriseed_send_error(500, 'Something went wrong. Please try again.', $e->getMessage());
}
