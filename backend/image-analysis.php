<?php
/**
 * POST /backend/image-analysis.php
 * multipart/form-data:
 *   image       - the uploaded file (required)
 *   description - optional free-text description from the farmer
 *   language    - "en" | "rw" | "auto"
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/gemini-client.php';

agriseed_json_headers();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    agriseed_send_error(405, 'Method not allowed.');
}

agriseed_check_rate_limit('image');

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $code = $_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) {
        agriseed_send_error(400, 'That image is too large. Please use a photo under 6MB.');
    }
    agriseed_send_error(400, 'Please attach a plant or leaf photo.');
}

$file = $_FILES['image'];

if ($file['size'] > MAX_UPLOAD_BYTES) {
    agriseed_send_error(400, 'That image is too large. Please use a photo under 6MB.');
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, ALLOWED_IMAGE_TYPES, true)) {
    agriseed_send_error(400, 'Unsupported image format. Please upload a JPG, PNG, or WEBP photo.');
}

// Basic sanity check that it's actually a readable image
$imageInfo = @getimagesize($file['tmp_name']);
if ($imageInfo === false) {
    agriseed_send_error(400, 'That file does not look like a valid image.');
}

$base64 = base64_encode(file_get_contents($file['tmp_name']));
$description = trim((string) ($_POST['description'] ?? ''));
$language = $_POST['language'] ?? 'auto';

function pd_language_instruction(string $language): string {
    switch ($language) {
        case 'rw':
            return "Write your entire analysis in clear, natural Kinyarwanda.";
        case 'en':
            return "Write your entire analysis in clear English.";
        default:
            return "If the farmer's optional description is in Kinyarwanda, reply in Kinyarwanda; otherwise reply in English.";
    }
}

$system = "You are AgriSeed AI's Plant Doctor, an agricultural image-analysis assistant. "
    . "You look at a photo of a plant or leaf and provide a careful, honest assessment — never a certain diagnosis from a single photo. "
    . "Always use cautious wording such as 'possible issue', 'likely', or 'based on the visible symptoms' rather than stating certainty. "
    . "If the image quality, angle, or lighting genuinely limits what you can tell, say so. "
    . pd_language_instruction($language) . "\n\n"
    . "Respond using EXACTLY this structure, with these section labels, one per line, followed by your content:\n"
    . "PLANT:\n<likely crop/plant, or 'Unclear' if not identifiable>\n\n"
    . "POSSIBLE ISSUE:\n<likely disease/health problem, or 'No clear issue visible' if the plant looks healthy>\n\n"
    . "VISIBLE SYMPTOMS:\n<what you actually see in the image>\n\n"
    . "POSSIBLE CAUSES:\n<likely causes — fungal, bacterial, pest, nutrient, environmental, etc.>\n\n"
    . "RECOMMENDED ACTIONS:\n<practical next steps a farmer can take>\n\n"
    . "PREVENTION:\n<how to reduce recurrence>\n\n"
    . "CONFIDENCE:\n<Low, Medium, or High — and one short sentence why>";

$userText = "Please analyze this plant/leaf photo.";
if ($description !== '') {
    $userText .= "\nFarmer's description: " . $description;
}

$messages = [[
    'role' => 'user',
    'content' => [
        gemini_image_block($base64, $mimeType),
        ['text' => $userText],
    ],
]];

try {
    $reply = gemini_chat($system, $messages, 900);

    // Parse the structured sections into a JSON object for the frontend,
    // while also returning the raw text as a fallback.
    $sections = ['plant', 'possible_issue', 'visible_symptoms', 'possible_causes', 'recommended_actions', 'prevention', 'confidence'];
    $labels = [
        'PLANT' => 'plant',
        'POSSIBLE ISSUE' => 'possible_issue',
        'VISIBLE SYMPTOMS' => 'visible_symptoms',
        'POSSIBLE CAUSES' => 'possible_causes',
        'RECOMMENDED ACTIONS' => 'recommended_actions',
        'PREVENTION' => 'prevention',
        'CONFIDENCE' => 'confidence',
    ];
    $parsed = array_fill_keys($sections, '');
    $pattern = '/(' . implode('|', array_map('preg_quote', array_keys($labels))) . '):\s*(.*?)(?=(' . implode('|', array_map('preg_quote', array_keys($labels))) . '):|\z)/s';
    if (preg_match_all($pattern, $reply, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $key = $labels[$m[1]] ?? null;
            if ($key) {
                $parsed[$key] = trim($m[2]);
            }
        }
    }

    echo json_encode([
        'success' => true,
        'raw' => $reply,
        'analysis' => $parsed,
        'disclaimer' => 'AgriSeed AI image analysis is an agricultural aid, not a laboratory diagnosis. For high-value crops or persistent problems, consult a local agronomist or extension officer.',
    ]);
} catch (AiClientException $e) {
    $msg = $e->getMessage();
    if (strpos($msg, 'missing_api_key') === 0) {
        agriseed_send_error(503, 'Plant Doctor is not fully configured yet (missing AI API key). See README for setup.', $msg);
    }
    agriseed_send_error(502, 'Plant Doctor is temporarily unavailable. Please try again.', $msg);
} catch (Throwable $e) {
    agriseed_send_error(500, 'Something went wrong analyzing that photo. Please try again.', $e->getMessage());
}
