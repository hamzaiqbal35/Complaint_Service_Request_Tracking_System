<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - CSRTS</title>
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
            <h1 class="text-4xl font-bold text-white mb-8">Privacy Policy</h1>
            
            <div class="prose prose-invert prose-teal max-w-none">
                <p class="text-lg text-slate-400 mb-8">Last updated: {{ date('F j, Y') }}</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">1. Introduction</h2>
                <p class="mb-4">Welcome to the Complaint & Service Request Tracking System (CSRTS). We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you as to how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">2. The data we collect about you</h2>
                <p class="mb-4">We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li><strong>Identity Data</strong> includes first name, last name, username or similar identifier.</li>
                    <li><strong>Contact Data</strong> includes email address and telephone numbers.</li>
                    <li><strong>Technical Data</strong> includes internet protocol (IP) address, your login data, browser type and version.</li>
                    <li><strong>Usage Data</strong> includes information about how you use our website, products and services.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">3. How we use your personal data</h2>
                <p class="mb-4">We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Where we need to perform the contract we are about to enter into or have entered into with you.</li>
                    <li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
                    <li>Where we need to comply with a legal obligation.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">4. Data security</h2>
                <p class="mb-4">We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorised way, altered or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors and other third parties who have a business need to know.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">5. Contact details</h2>
                <p class="mb-4">If you have any questions about this privacy policy or our privacy practices, please contact us at:</p>
                <p class="text-teal-400">privacy@csrts.example.com</p>
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
