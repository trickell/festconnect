<script>
    /**
     * Resizes an image file to a maximum dimension while maintaining aspect ratio.
     * @param {File} file - The original image file.
     * @param {number} maxWidth - Maximum width in pixels.
     * @param {number} maxHeight - Maximum height in pixels.
     * @param {number} quality - JPEG quality (0 to 1).
     * @returns {Promise<Blob>} - Resolves with the resized image Blob.
     */
    window.resizeImage = function (file, maxWidth = 1200, maxHeight = 1200, quality = 0.8) {
        return new Promise((resolve, reject) => {
            if (!file.type.match(/image.*/)) {
                return reject(new Error("File is not an image"));
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    const canvas = document.createElement("canvas");
                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        resolve(blob);
                    }, "image/jpeg", quality);
                };
                img.onerror = reject;
                img.src = e.target.result;
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    };
</script>