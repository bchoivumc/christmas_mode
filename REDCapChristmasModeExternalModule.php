<?php
namespace Vanderbilt\REDCapChristmasModeExternalModule;

use ExternalModules\AbstractExternalModule;

class REDCapChristmasModeExternalModule extends AbstractExternalModule
{
    public function redcap_every_page_top($project_id = null)
    {
        try {
            if (!$this->shouldEnableChristmasMode($project_id)) {
                return;
            }

            $this->addChristmasAssets($project_id);
        } catch (Exception $e) {
            error_log("REDCap Christmas Mode Module Error: " . $e->getMessage());
        }
    }

    private function shouldEnableChristmasMode($project_id = null)
    {
        return true;
    }

    private function addChristmasAssets($project_id = null)
    {
        $intensity = $this->getSystemSetting('christmas-theme-intensity') ?: 'moderate';
        $enableSnow = $this->getProjectSetting('enable-snow-animation', $project_id) ?? true;
        $colorScheme = $this->getProjectSetting('color-scheme', $project_id) ?: 'traditional';
        
        echo '<style>
        /* Christmas Mode Variables */
        :root {' . 
        ($colorScheme === 'accessible' ? '
            --christmas-primary: #2c3e50;
            --christmas-green: #2e7d32;
            --christmas-gold: #ffd700;
            --christmas-white: #ffffff;
            --christmas-silver: #c0c0c0;
            --christmas-dark-green: #1b5e20;
            --christmas-light-primary: #5d4e75;
            --christmas-bg: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #2c3e50 100%);
        ' : '
            --christmas-primary: #c41e3a;
            --christmas-green: #2e7d32;
            --christmas-gold: #ffd700;
            --christmas-white: #ffffff;
            --christmas-silver: #c0c0c0;
            --christmas-dark-green: #1b5e20;
            --christmas-light-primary: #ef5350;
            --christmas-bg: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #c41e3a 100%);
        ') . '
        }
        
        /* Main Christmas Theme */
        body.christmas-mode {
            background: var(--christmas-bg) !important;
            min-height: 100vh;
            position: relative;
        }
        
        body.christmas-mode::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(196, 30, 58, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        /* Header Christmas Styling */
        body.christmas-mode #container,
        body.christmas-mode #center,
        body.christmas-mode #wrapper {
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 10px;
            margin: 10px;
            box-shadow: 0 0 20px rgba(196, 30, 58, 0.3);
            border: 2px solid var(--christmas-gold);
        }
        
        /* Christmas Headers */
        body.christmas-mode h1,
        body.christmas-mode h2,
        body.christmas-mode h3 {
            color: var(--christmas-primary) !important;
            text-shadow: 1px 1px 2px rgba(255, 215, 0, 0.3);
            position: relative;
        }
        
        body.christmas-mode h1::after {
            content: "🎄";
            margin-left: 10px;
            animation: twinkle 2s infinite;
        }
        
        /* Christmas Tables */
        body.christmas-mode table {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 2px solid var(--christmas-primary) !important;
            border-radius: 8px;
            overflow: hidden;
        }
        
        body.christmas-mode table th {
            background: var(--christmas-primary) !important;
            color: var(--christmas-white) !important;
            border: 1px solid var(--christmas-gold) !important;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        }
        
        body.christmas-mode table td {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid var(--christmas-silver) !important;
        }
        
        body.christmas-mode table tbody tr:nth-child(even) td {
            background: rgba(46, 125, 50, 0.1) !important;
        }
        
        body.christmas-mode table tbody tr:hover td {
            background: rgba(255, 215, 0, 0.2) !important;
        }
        
        /* Christmas Forms */
        body.christmas-mode input,
        body.christmas-mode select,
        body.christmas-mode textarea {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 2px solid var(--christmas-green) !important;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        body.christmas-mode input:focus,
        body.christmas-mode select:focus,
        body.christmas-mode textarea:focus {
            border-color: var(--christmas-primary) !important;
            box-shadow: 0 0 10px rgba(196, 30, 58, 0.3) !important;
        }
        
        /* Christmas Buttons */
        body.christmas-mode .btn,
        body.christmas-mode button {
            background: linear-gradient(45deg, var(--christmas-primary), var(--christmas-light-primary)) !important;
            color: var(--christmas-white) !important;
            border: 2px solid var(--christmas-gold) !important;
            border-radius: 20px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        }
        
        body.christmas-mode .btn:hover,
        body.christmas-mode button:hover {
            background: linear-gradient(45deg, var(--christmas-green), var(--christmas-dark-green)) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        /* Christmas Menu */
        body.christmas-mode .menubox {
            background: rgba(46, 125, 50, 0.95) !important;
            border: 2px solid var(--christmas-gold) !important;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }
        
        body.christmas-mode .menubox a {
            color: var(--christmas-white) !important;
            transition: all 0.3s ease;
        }
        
        body.christmas-mode .menubox a:hover {
            background: rgba(196, 30, 58, 0.8) !important;
            color: var(--christmas-gold) !important;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        /* Christmas Links */
        body.christmas-mode a {
            color: var(--christmas-primary) !important;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        
        body.christmas-mode a:hover {
            color: var(--christmas-green) !important;
            text-decoration: underline;
        }
        
        /* Brighten gray descriptive text for better visibility */
        body.christmas-mode .menubox div:not(:first-child),
        body.christmas-mode .menubox div div,
        body.christmas-mode .menubox font[color="#777777"],
        body.christmas-mode .menubox font[color="#888888"],
        body.christmas-mode .menubox font[color="#999999"],
        body.christmas-mode .menubox font[color="gray"],
        body.christmas-mode .menubox .gray,
        body.christmas-mode .menubox small,
        body.christmas-mode div[style*="color:#777"],
        body.christmas-mode div[style*="color:#888"],
        body.christmas-mode div[style*="color:#999"],
        body.christmas-mode div[style*="color:gray"],
        body.christmas-mode font[style*="color:#777"],
        body.christmas-mode font[style*="color:#888"],
        body.christmas-mode font[style*="color:#999"],
        body.christmas-mode font[style*="color:gray"] {
            color: #e8f5e8 !important;
        }
        
        
        /* Animations */
        @keyframes twinkle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateX(-50%) translateY(0px); }
            50% { transform: translateX(-50%) translateY(-10px); }
        }
        
        @keyframes snowfall {
            0% { transform: translateY(-100vh) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
        
        /* Snow Animation */
        .snowflake {
            position: fixed;
            top: -10px;
            color: white;
            font-size: 1em;
            animation: snowfall linear infinite;
            pointer-events: none;
            z-index: 1000;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        }
        </style>';
        
        echo '<script>
        function toggleChristmasMode() {
            console.log("toggleChristmasMode called");
            const body = document.body;
            
            if (body.classList.contains("christmas-mode")) {
                body.classList.remove("christmas-mode");
                localStorage.setItem("redcap-christmas-mode", "false");
                updateToggleButton(false);
                restoreOriginalLogos();
                clearSnowflakes();
                console.log("Christmas mode disabled");
            } else {
                body.classList.add("christmas-mode");
                localStorage.setItem("redcap-christmas-mode", "true");
                updateToggleButton(true);
                replaceLogosWithChristmasVersion();
                ' . ($enableSnow ? 'createSnowfall();' : '') . '
                console.log("Christmas mode enabled");
            }
        }
        
        function updateToggleButton(isChristmas) {
            const button = document.getElementById("christmas-mode-toggle");
            if (button) {
                button.textContent = isChristmas ? "🌟 Normal Mode" : "🎄 Christmas Mode";
                if (isChristmas) {
                    button.classList.add("christmas-mode");
                } else {
                    button.classList.remove("christmas-mode");
                }
            }
        }
        
        function createSnowfall() {
            const snowflakes = ["❄", "❅", "❆", "⛄", "🎿"];
            const container = document.body;
            
            for (let i = 0; i < 4; i++) {
                setTimeout(() => {
                    const snowflake = document.createElement("div");
                    snowflake.className = "snowflake";
                    snowflake.innerHTML = snowflakes[Math.floor(Math.random() * snowflakes.length)];
                    snowflake.style.left = Math.random() * 100 + "vw";
                    snowflake.style.animationDuration = Math.random() * 6 + 4 + "s";
                    snowflake.style.opacity = Math.random();
                    snowflake.style.fontSize = (Math.random() * 10 + 10) + "px";
                    
                    container.appendChild(snowflake);
                    
                    setTimeout(() => {
                        if (snowflake.parentNode) {
                            snowflake.parentNode.removeChild(snowflake);
                        }
                    }, 10000);
                }, Math.random() * 2000);
            }
        }
        
        function clearSnowflakes() {
            const snowflakes = document.querySelectorAll(".snowflake");
            snowflakes.forEach(flake => {
                if (flake.parentNode) {
                    flake.parentNode.removeChild(flake);
                }
            });
        }
        
        function replaceLogosWithChristmasVersion() {
            const logos = document.querySelectorAll("img[src*=\"redcap-logo\"]");
            logos.forEach(logo => {
                if (!logo.dataset.originalSrc) {
                    logo.dataset.originalSrc = logo.src;
                }
                const moduleImageUrl = "' . $this->getUrl('snowed_redcap_logo_final.png') . '";
                logo.src = moduleImageUrl;
            });
        }
        
        function restoreOriginalLogos() {
            const logos = document.querySelectorAll("img[src*=\"snowed_redcap_logo_final\"]");
            logos.forEach(logo => {
                if (logo.dataset.originalSrc) {
                    logo.src = logo.dataset.originalSrc;
                }
            });
        }
        
        function initChristmasMode() {
            console.log("Initializing Christmas mode...");
            const saved = localStorage.getItem("redcap-christmas-mode");
            
            if (saved === "true") {
                document.body.classList.add("christmas-mode");
                updateToggleButton(true);
                replaceLogosWithChristmasVersion();
                ' . ($enableSnow ? 'createSnowfall();' : '') . '
                console.log("Applied saved Christmas mode");
            } else {
                updateToggleButton(false);
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initChristmasMode);
        } else {
            initChristmasMode();
        }
        
        // Continuous snowfall every 2-3 seconds
        ' . ($enableSnow ? 'setInterval(() => {
            if (document.body.classList.contains("christmas-mode")) {
                createSnowfall();
            }
        }, Math.random() * 1000 + 2000);' : '') . '
        </script>';
        
        $this->addToggleButton();
    }

    private function addToggleButton()
    {
        ?>
        <style>
        .christmas-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: linear-gradient(45deg, #c41e3a, #ef5350);
            color: white;
            border: 2px solid #ffd700;
            border-radius: 25px;
            padding: 10px 18px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
            transition: all 0.3s ease;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        }
        .christmas-mode-toggle:hover {
            background: linear-gradient(45deg, #2e7d32, #1b5e20);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(46, 125, 50, 0.4);
        }
        .christmas-mode-toggle.christmas-mode {
            background: linear-gradient(45deg, #2e7d32, #1b5e20);
            border-color: #ffd700;
        }
        .christmas-mode-toggle.christmas-mode:hover {
            background: linear-gradient(45deg, #c41e3a, #ef5350);
        }
        </style>
        <button id="christmas-mode-toggle" class="christmas-mode-toggle" onclick="toggleChristmasMode()">
            🎄 Christmas Mode
        </button>
        <?php
    }
}