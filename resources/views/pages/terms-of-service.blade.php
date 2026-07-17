<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - CSRTS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Cursor */
        body { cursor: none; }
        a, button, input, textarea, select, .cursor-pointer { cursor: none; }
        
        .cursor-dot, .cursor-outline {
            position: fixed;
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: 9999;
            pointer-events: none;
        }
        .cursor-dot {
            width: 8px;
            height: 8px;
            background-color: #14b8a6; /* teal-400 */
            box-shadow: 0 0 10px #14b8a6, 0 0 20px #0d9488;
        }
        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid rgba(20, 184, 166, 0.5);
            transition: width 0.2s, height 0.2s, background-color 0.2s;
        }
        .cursor-outline.hovering {
            width: 60px;
            height: 60px;
            background-color: rgba(20, 184, 166, 0.1);
            border-color: rgba(20, 184, 166, 0.8);
        }
        @media (max-width: 1024px) {
            body, a, button, input, textarea, select, .cursor-pointer { cursor: auto; }
            .cursor-dot, .cursor-outline { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-300 font-sans antialiased min-h-screen relative">
    
    <!-- Custom Cursor -->
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>

    <!-- Interactive Background -->
    <div id="tsparticles" class="fixed inset-0 z-0 pointer-events-none opacity-30"></div>
    
    <!-- Header -->
    <div class="fixed top-0 left-0 w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800 z-50 py-4 px-6">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 text-white font-bold text-xl hover:text-teal-400 transition-colors">
                <i class="fas fa-shield-alt text-teal-500"></i> CSRTS
            </a>
            <a href="/" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Back to Home
            </a>
        </div>
    </div>

    <!-- Content -->
    <main class="max-w-4xl mx-auto px-6 pt-32 pb-20 relative z-10" style="padding-top: 8rem;">
        <div id="tilt-card" class="bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 md:p-12 border border-slate-700/50 shadow-2xl">
            <h1 class="text-4xl font-bold text-white mb-8">Terms of Service</h1>
            
            <div class="prose prose-invert prose-teal max-w-none">
                <p class="text-lg text-slate-400 mb-8">Last updated: {{ date('F j, Y') }}</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">1. Acceptance of Terms</h2>
                <p class="mb-4">By accessing or using the Complaint & Service Request Tracking System (CSRTS), you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any part of these terms, you may not use our services.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">2. Use License</h2>
                <p class="mb-4">Permission is granted to temporarily download one copy of the materials (information or software) on CSRTS's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>modify or copy the materials;</li>
                    <li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
                    <li>attempt to decompile or reverse engineer any software contained on CSRTS's website;</li>
                    <li>remove any copyright or other proprietary notations from the materials; or</li>
                    <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">3. Disclaimer</h2>
                <p class="mb-4">The materials on CSRTS's website are provided on an 'as is' basis. CSRTS makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">4. Limitations</h2>
                <p class="mb-4">In no event shall CSRTS or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on CSRTS's website, even if CSRTS or a CSRTS authorized representative has been notified orally or in writing of the possibility of such damage.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">5. Revisions and Errata</h2>
                <p class="mb-4">The materials appearing on CSRTS's website could include technical, typographical, or photographic errors. CSRTS does not warrant that any of the materials on its website are accurate, complete, or current. CSRTS may make changes to the materials contained on its website at any time without notice.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 py-8 text-center text-slate-500 text-sm relative z-10">
        &copy; {{ date('Y') }} Complaint & Service Request Tracking System. All rights reserved.
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <script>
        // Custom Cursor Logic
        const cursorDot = document.getElementById("cursor-dot");
        const cursorOutline = document.getElementById("cursor-outline");
        let cursorX = 0, cursorY = 0;
        let outlineX = 0, outlineY = 0;

        window.addEventListener("mousemove", (e) => {
            cursorX = e.clientX;
            cursorY = e.clientY;
            if (cursorDot) {
                cursorDot.style.left = cursorX + "px";
                cursorDot.style.top = cursorY + "px";
            }
        });

        function animateCursor() {
            let distX = cursorX - outlineX;
            let distY = cursorY - outlineY;
            
            outlineX = outlineX + (distX * 0.15);
            outlineY = outlineY + (distY * 0.15);
            
            if (cursorOutline) {
                cursorOutline.style.left = outlineX + "px";
                cursorOutline.style.top = outlineY + "px";
            }
            
            requestAnimationFrame(animateCursor);
        }
        animateCursor();

        document.querySelectorAll("a, button, input, textarea, select, .cursor-pointer").forEach(el => {
            el.addEventListener("mouseenter", () => {
                if (cursorOutline) cursorOutline.classList.add("hovering");
            });
            el.addEventListener("mouseleave", () => {
                if (cursorOutline) cursorOutline.classList.remove("hovering");
            });
        });

        // Initialize Vanilla Tilt
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.getElementById("tilt-card"), {
                max: 2,
                speed: 400,
                glare: true,
                "max-glare": 0.05,
            });
        }

        // Initialize tsParticles
        if (typeof tsParticles !== 'undefined') {
            tsParticles.load("tsparticles", {
                fpsLimit: 60,
                interactivity: {
                    events: {
                        onHover: { enable: true, mode: "grab" },
                        resize: true,
                    },
                    modes: {
                        grab: { distance: 200, links: { opacity: 0.5 } }
                    },
                },
                particles: {
                    color: { value: ["#14b8a6", "#10b981"] },
                    links: {
                        color: "#14b8a6",
                        distance: 150,
                        enable: true,
                        opacity: 0.2,
                        width: 1,
                    },
                    move: {
                        direction: "none",
                        enable: true,
                        outModes: { default: "bounce" },
                        random: false,
                        speed: 1,
                        straight: false,
                    },
                    number: { density: { enable: true, area: 800 }, value: 40 },
                    opacity: { value: 0.3 },
                    shape: { type: "circle" },
                    size: { value: { min: 1, max: 3 } },
                },
                detectRetina: true,
            });
        }
    </script>
</body>
</html>
