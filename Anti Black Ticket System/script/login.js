function switchTab(tab) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const tabs = document.querySelectorAll('.auth-tab');

    tabs.forEach(t => t.classList.remove('active'));

    if (tab === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        tabs[0].classList.add('active');
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        tabs[1].classList.add('active');
    }
}

// NID OCR extraction
const nidImageInput = document.getElementById('register-nid-image');
const nidNumberInput = document.getElementById('register-nid-number');
const nidOcrStatus = document.getElementById('nid-ocr-status');

if (nidImageInput) {
    nidImageInput.addEventListener('change', function() {
        const file = this.files[0];
        nidNumberInput.value = '';
        nidOcrStatus.textContent = '';
        if (!file) return;
        nidOcrStatus.textContent = 'Extracting...';
        const reader = new FileReader();
        reader.onload = function(e) {
            Tesseract.recognize(
                e.target.result,
                'eng',
                { logger: m => { /* Optionally log progress */ } }
            ).then(({ data: { text } }) => {
                // Remove all non-digits, get last 10 digits
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
            });
        };
        reader.readAsDataURL(file);
    });
}

function preprocessImage(file, callback) {
    const img = new Image();
    const reader = new FileReader();
    reader.onload = function(e) {
        // img.onload = function () {
        //     const canvas = document.createElement('canvas');
        //     canvas.width = img.width;
        //     canvas.height = img.height;
        //     const ctx = canvas.getContext('2d');
        
        //     // Draw image
        //     ctx.drawImage(img, 0, 0);
        
        //     // Slight blur to soften background threads
        //     ctx.filter = 'blur(100px)';
        //     ctx.drawImage(canvas, 0, 0);
        //     ctx.filter = 'none';
        
        //     // Get pixel data
        //     let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        //     let data = imageData.data;
        
        //     // Grayscale + strong contrast + brightness + thresholding
        //     const contrast = 3.0;
        //     const brightness = 4.0;
        //     const threshold = 480; // pixels lighter than this will become white
        
        //     for (let i = 0; i < data.length; i += 4) {
        //         let r = data[i], g = data[i + 1], b = data[i + 2];
        
        //         // Convert to grayscale
        //         let gray = (r + g + b) / 3;
        
        //         // Apply contrast
        //         gray = ((gray - 128) * contrast) + 128;
        
        //         // Apply brightness
        //         gray *= brightness;
        
        //         // Thresholding to reduce background
        //         gray = gray > threshold ? 255 : gray;
        
        //         // Clamp
        //         gray = Math.max(0, Math.min(255, gray));
        
        //         // Set all channels
        //         data[i] = data[i + 1] = data[i + 2] = gray;
        //     }
        
        //     ctx.putImageData(imageData, 0, 0);
            
        
        
        
        img.onload = function() {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext('2d');
            ctx.filter = 'blur(2px)'; // Add blur to reduce glare
            ctx.drawImage(img, 0, 0);
            ctx.filter = 'none';

            // Get image data
            let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            let data = imageData.data;

            // Grayscale and increase contrast/brightness
            for (let i = 0; i < data.length; i += 4) {
                let avg = (data[i] + data[i+1] + data[i+2]) / 3;
                let contrast = 1.0; // Increased contrast
                avg = ((avg - 128) * contrast) + 128;
                let brightness = 3.0; // 200% brightness
                avg = avg * brightness;
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