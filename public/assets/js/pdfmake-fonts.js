// public/assets/js/pdfmake-fonts.js
(function () {
    function loadFont(url, callback) {
        if (!url) {
            console.error("Font URL is undefined");
            callback(null);
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.responseType = "blob";
        xhr.onload = function () {
            if (xhr.status === 200) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var base64 = e.target.result.replace(
                        /^data:[^;]+;base64,/,
                        ""
                    );
                    callback(base64);
                };
                reader.readAsDataURL(xhr.response);
            } else {
                console.error(
                    "Failed to load font:",
                    url,
                    "Status:",
                    xhr.status
                );
                callback(null);
            }
        };
        xhr.onerror = function () {
            console.error("Error loading font:", url);
            callback(null);
        };
        xhr.send();
    }

    function initializeFonts() {
        if (typeof pdfMake === "undefined") {
            setTimeout(initializeFonts, 100);
            return;
        }

        // Check if font URLs are available
        if (!window.fontUrls || !window.fontUrls.cairoRegular) {
            console.error(
                "Font URLs not defined. Make sure window.fontUrls is set in your Blade template."
            );
            return;
        }

        // console.log("Loading fonts from:", window.fontUrls);

        // Ensure vfs and fonts objects exist
        if (!pdfMake.vfs) pdfMake.vfs = {};
        if (!pdfMake.fonts) pdfMake.fonts = {};

        // Load Cairo Regular
        loadFont(window.fontUrls.cairoRegular, function (regularBase64) {
            if (!regularBase64) {
                console.error("Failed to load Cairo Regular font");
                return;
            }

            // Load Cairo Bold
            loadFont(window.fontUrls.cairoBold, function (boldBase64) {
                if (!boldBase64) {
                    return;
                }

                // Add fonts to virtual file system
                pdfMake.vfs["Cairo-Regular.ttf"] = regularBase64;
                pdfMake.vfs["Cairo-Bold.ttf"] = boldBase64;

                // Define the Cairo font family
                pdfMake.fonts.Cairo = {
                    normal: "Cairo-Regular.ttf",
                    bold: "Cairo-Bold.ttf",
                    italics: "Cairo-Regular.ttf",
                    bolditalics: "Cairo-Bold.ttf",
                };

                // console.log("Cairo fonts loaded successfully!");
                // console.log("Available fonts:", Object.keys(pdfMake.fonts));
            });
        });
    }

    // Start initialization when DOM is ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeFonts);
    } else {
        initializeFonts();
    }
})();
