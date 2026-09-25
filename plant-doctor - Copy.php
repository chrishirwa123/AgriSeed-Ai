<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Doctor </title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="topnav">
        <div class="container">
            <a href="index.php" class="brand"><span class="leaf">🌱</span> AgriSeed AI</a>
            <button class="nav-toggle" aria-label="Toggle navigation">☰</button>
            <ul class="nav-links">
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="assistant.php">🤖 AI Assistant</a></li>
                <li><a href="crop-advisor.php">🌾 Crop Advisor</a></li>
                <li><a href="plant-doctor.php" class="active">🦠 Plant Doctor</a></li>
                <li><a href="irrigation.php">💧 Irrigation</a></li>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding: 1.5rem 1.25rem 3rem; max-width: 780px;">
        <h2>🦠 Plant Doctor</h2>
        <p class="card-muted">Upload a photo of a plant or leaf for an AI health check. This is an agricultural aid, not
            a lab diagnosis.</p>

        <form id="plantDoctorForm" class="card">
            <div class="upload-drop" id="uploadDrop">
                <p><strong>Click to upload</strong> or drag a photo here</p>
                <p class="card-muted" style="margin:0;">JPG, PNG, or WEBP · up to 6MB</p>
            </div>
            <input type="file" id="plantImageInput" accept="image/jpeg,image/png,image/webp" capture="environment"
                class="visually-hidden">
            <img id="imagePreview" class="image-preview" style="display:none; margin-top:1rem;"
                alt="Selected plant photo preview">

            <div class="field" style="margin-top:1rem;">
                <label for="plantDescription">Optional description</label>
                <textarea id="plantDescription" rows="2"
                    placeholder="e.g. Tomato leaves turning yellow from the bottom up, past week"></textarea>
            </div>

            <button class="btn btn-primary" type="submit" id="plantSubmitBtn">Analyze Photo</button>
        </form>

        <div id="plantResult" style="margin-top:1.25rem;"></div>
    </main>

    <script src="js/app.js"></script>
    <script src="js/plant-doctor.js"></script>
</body>

</html>