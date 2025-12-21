<?php require 'include/_login.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register - Chorolin Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="auth-container">
        <a href="index.php" class="auth-header">
            <h1><i class="fas fa-train"></i> Chorolin Tickets</h1>
            <p>Your Journey Begins Here</p>
        </a>

        <div class="auth-tabs">
            <div class="auth-tab active" onclick="switchTab('login')">Login</div>
            <div class="auth-tab" onclick="switchTab('register')">Register</div>
        </div>

        <?php if (isset($alert) && isset($alert_type)): ?>
            <div class="alert <?php echo $alert_type; ?>"><?php echo $alert; ?></div>
        <?php endif; ?>

        <form id="loginForm" action="" method="POST" class="form-section" style="display: block;">
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit" name="login" class="action-btn">Login</button>
        </form>

        <form id="registerForm" action="" method="POST" class="form-section" style="display: none;" enctype="multipart/form-data">
            <div class="form-group">
                <label for="register-name">Full Name</label>
                <input type="text" id="register-name" name="name" required placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="register-phone">Phone Number</label>
                <input type="tel" id="register-phone" name="phone" required placeholder="Enter your phone number">
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" name="password" required placeholder="Choose a password">
            </div>
            <div class="form-group">
                <label for="register-confirm-password">Confirm Password</label>
                <input type="password" id="register-confirm-password" name="confirm_password" required placeholder="Confirm your password">
            </div>
            <div class="form-group">
                <label for="register-nid-image">Upload NID Image</label>
                <input type="file" id="register-nid-image" name="nid_image" accept="image/*" required>
                <div style="margin-top:8px;">
                    <span style="font-weight:500;">Extracted NID No:</span>
                    <input type="text" id="register-nid-number" name="nid_number" style="width:140px; font-weight:bold; color:#2563eb;">
                    <span id="nid-ocr-status" style="font-size:0.95em; color:#888; margin-left:8px;"></span>
                </div>
                <small style="color:#888;">Please verify the NID number before submitting.</small>
            </div>
            <br>
            <!-- <textarea id="nid-ocr-raw" rows="5" style="width:100%;margin-top:8px;" placeholder="Full OCR result will appear here"></textarea> -->
            <img id="preprocessed-preview" style="display:block;max-width:100%;margin-top:10px;border:1px solid #ccc;" alt="Preprocessed NID Preview">
            <button type="submit" name="register" class="action-btn">Create Account</button>
        </form>
    </div>

    <script src="script/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.1/dist/tesseract.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nidImageInput = document.getElementById('register-nid-image');
            const nidNumberInput = document.getElementById('register-nid-number');
            const nidOcrStatus = document.getElementById('nid-ocr-status');
            const nidOcrRaw = document.getElementById('nid-ocr-raw');

            if (nidImageInput) {
                nidImageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    nidNumberInput.value = '';
                    nidOcrStatus.textContent = '';
                    if (nidOcrRaw) nidOcrRaw.value = '';
                    if (!file) return;
                    nidOcrStatus.textContent = 'Extracting...';
                    preprocessImage(file, function(processedDataUrl) {
                        Tesseract.recognize(
                            processedDataUrl,
                            'eng',
                            { logger: m => { /* Optionally log progress */ } }
                        ).then(({ data: { text } }) => {
                            if (nidOcrRaw) nidOcrRaw.value = text;
                            const digits = text.replace(/[^0-9]/g, '');
                            if (digits.length >= 10) {
                                nidNumberInput.value = digits.slice(-10);
                                nidOcrStatus.textContent = 'NID detected!';
                            } else {
                                nidNumberInput.value = '';
                                nidOcrStatus.textContent = 'Could not detect 10-digit NID.';
                            }
                        }).catch(() => {
                            nidNumberInput.value = '';
                            nidOcrStatus.textContent = 'OCR failed.';
                            if (nidOcrRaw) nidOcrRaw.value = '';
                        });
                    });
                });
            }
        });

        function preprocessImage(file, callback) {
            const img = new Image();
            const reader = new FileReader();
            reader.onload = function(e) {
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);

                    // Get image data
                    let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    let data = imageData.data;

                    // Grayscale and increase contrast/brightness
                    for (let i = 0; i < data.length; i += 4) {
                        // Grayscale
                        let avg = (data[i] + data[i+1] + data[i+2]) / 3;
                        // Increase contrast
                        let contrast = 1.5;
                        avg = ((avg - 128) * contrast) + 128;
                        // Increase exposure
                        let exposure = 30;
                        avg = avg + exposure;
                        avg = Math.max(0, Math.min(255, avg));
                        data[i] = data[i+1] = data[i+2] = avg;
                    }
                    ctx.putImageData(imageData, 0, 0);

                    // Show preview
                    const dataUrl = canvas.toDataURL('image/png');
                    const preview = document.getElementById('preprocessed-preview');
                    if (preview) preview.src = dataUrl;

                    // Return processed image as DataURL
                    callback(dataUrl);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>