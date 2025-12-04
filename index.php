<?php
$config = [
    'furniture_types' => [
        "Sofa", "Chair", "Coffee Table", "Dining Table", "Bed", "Bookshelf", "Desk"
    ],
    'prices' => [
        "₱5,000 - ₱15,000",
        "₱15,001 - ₱30,000",
        "₱30,001 - ₱50,000",
        "₱50,001+"
    ],
    'styles' => [
        "Modern", "Minimalist", "Scandinavian", "Industrial", "Bohemian"
    ]
];

function generate_options(array $options, string $selectedValue = ''): void {
    foreach ($options as $option) {
        $encodedOption = htmlspecialchars($option, ENT_QUOTES, 'UTF-8');
        $selected = ($selectedValue === $option) ? 'selected' : '';
        echo "<option value=\"{$encodedOption}\" {$selected}>{$encodedOption}</option>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Furniture Landing Page Generator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="card" id="main-card">
            <div class="card-body">
                <div class="form-container" id="form-container">
                    <h1 class="card-title text-center serif-title">AI Furniture Designer</h1>
                    <p class="card-subtitle text-center text-muted mb-5">Fill out the details below to generate your custom furniture page.</p>
                    <form id="furniture-form" novalidate>
                        <div class="mb-4 input-group-icon">
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"/><path d="M2 11h20"/><path d="M3 11v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6"/><path d="M4 18v-2"/><path d="M20 18v-2"/></svg>
                            </div>
                            <label for="furniture_type" class="form-label">Choose a furniture type:</label>
                            <select id="furniture_type" name="furniture_type" class="form-select" required>
                                <option value="" disabled selected>Please select a type</option>
                                <?php generate_options($config['furniture_types']); ?>
                            </select>
                        </div>
                        <div class="mb-4 input-group-icon">
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82-.71-.71z"/></svg>
                            </div>
                            <label for="price" class="form-label">What is your approximate budget?</label>
                            <select id="price" name="price" class="form-select" required>
                                <option value="" disabled selected>Please select a budget</option>
                                <?php generate_options($config['prices']); ?>
                            </select>
                        </div>
                        <div class="mb-4 input-group-icon">
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/><path d="M11.5 12.5c-1.25.8-2.5 1-4 1-1.33 0-2.67-.33-4-1V4.5c1.33.67 2.67 1 4 1s2.75-.2 4-1v8.5Z"/><path d="m19.5 12.5-4-1v-8.5c1.25.8 2.5 1 4 1V12.5Z"/></svg>
                            </div>
                            <label for="style" class="form-label">Describe the style you prefer.</label>
                            <select id="style" name="style" class="form-select" required>
                                <option value="" disabled selected>Please select a style</option>
                                <?php generate_options($config['styles']); ?>
                            </select>
                        </div>
                        <button type="submit" id="generate-btn" class="btn btn-primary btn-lg w-100 mt-4 cta-button">
                            <span class="btn-text">Generate My Landing Page</span>
                            <div class="spinner"></div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div id="loader">
            <div class="dots-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p class="typing-effect">Our AI is designing your page...</p>
        </div>

        <div id="result-container" style="display: none;">
            <button id="close-result-btn" title="Start Over">&times;</button>
            <div id="result">
                <!-- AI-generated content will be injected here -->
            </div>
        </div>
    </div>

    <script>
        // The webhook URL is injected by the server.
        // For local development, you can manually set it here like this:
        // window.N8N_WEBHOOK_URL = 'http://your-local-webhook-url.com';
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
