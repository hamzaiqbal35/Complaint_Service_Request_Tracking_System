<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cookie Policy - CSRTS</title>
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
            <h1 class="text-4xl font-bold text-white mb-8">Cookie Policy</h1>
            
            <div class="prose prose-invert prose-teal max-w-none">
                <p class="text-lg text-slate-400 mb-8">Last updated: {{ date('F j, Y') }}</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">What Are Cookies</h2>
                <p class="mb-4">As is common practice with almost all professional websites, this site uses cookies, which are tiny files that are downloaded to your computer, to improve your experience. This page describes what information they gather, how we use it and why we sometimes need to store these cookies. We will also share how you can prevent these cookies from being stored however this may downgrade or 'break' certain elements of the sites functionality.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">How We Use Cookies</h2>
                <p class="mb-4">We use cookies for a variety of reasons detailed below. Unfortunately, in most cases, there are no industry standard options for disabling cookies without completely disabling the functionality and features they add to this site. It is recommended that you leave on all cookies if you are not sure whether you need them or not in case they are used to provide a service that you use.</p>
                
                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">The Cookies We Set</h2>
                <ul class="list-disc pl-6 mb-4 space-y-4">
                    <li>
                        <strong>Account related cookies:</strong>
                        If you create an account with us then we will use cookies for the management of the signup process and general administration. These cookies will usually be deleted when you log out however in some cases they may remain afterwards to remember your site preferences when logged out.
                    </li>
                    <li>
                        <strong>Login related cookies:</strong>
                        We use cookies when you are logged in so that we can remember this fact. This prevents you from having to log in every single time you visit a new page. These cookies are typically removed or cleared when you log out to ensure that you can only access restricted features and areas when logged in.
                    </li>
                    <li>
                        <strong>Forms related cookies:</strong>
                        When you submit data to through a form such as those found on contact pages or comment forms cookies may be set to remember your user details for future correspondence.
                    </li>
                </ul>

                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">Third Party Cookies</h2>
                <p class="mb-4">In some special cases we also use cookies provided by trusted third parties. The following section details which third party cookies you might encounter through this site.</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>This site uses Google Analytics which is one of the most widespread and trusted analytics solutions on the web for helping us to understand how you use the site and ways that we can improve your experience. These cookies may track things such as how long you spend on the site and the pages that you visit so we can continue to produce engaging content.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-white mt-8 mb-4">More Information</h2>
                <p class="mb-4">Hopefully that has clarified things for you and as was previously mentioned if there is something that you aren't sure whether you need or not it's usually safer to leave cookies enabled in case it does interact with one of the features you use on our site.</p>
                <p class="mb-4">For more general information on cookies, please contact us at:</p>
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
