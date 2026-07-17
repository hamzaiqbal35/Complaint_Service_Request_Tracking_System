<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Complaint & Service Request Tracking System') }}</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-slate-900 selection:bg-teal-500 selection:text-white min-h-screen relative flex">
    
    <!-- Custom Cursor -->
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>
    <!-- Fixed Global Back Button (Top Left) -->
    <a href="/" class="fixed top-6 left-6 lg:top-8 lg:left-8 flex items-center gap-2 text-slate-400 hover:text-white transition-colors group z-50">
        <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-white/10 transition-colors">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="text-sm font-medium hidden sm:block">Back to Home</span>
    </a>

    <!-- Left Side: Fixed branding & abstract illustration (Hidden on mobile) -->
    <div class="hidden lg:flex w-1/2 fixed inset-y-0 left-0 bg-slate-900 flex-col justify-center items-center overflow-hidden z-0">
        <!-- Interactive Particles Background -->
        <div id="tsparticles-guest" class="absolute inset-0 z-0 pointer-events-none"></div>

        <!-- Animated Background Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] rounded-full bg-teal-600/20 blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-emerald-600/20 blur-[100px] pointer-events-none"></div>
        <div class="absolute top-[20%] right-[20%] w-[30%] h-[30%] rounded-full bg-amber-500/10 blur-[80px] pointer-events-none"></div>

        <!-- Abstract Illustration / Branding -->
        <div class="relative z-10 w-3/4 max-w-lg text-center flex flex-col items-center">
            <div class="mb-12 animate-float">
                <!-- Professional 3D Dashboard Mockup -->
                <div id="mockup-card" class="w-full max-w-[340px] rounded-[2rem] bg-slate-800/80 border border-slate-700/50 backdrop-blur-3xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.8)] p-6 transform rotate-[-4deg] hover:rotate-[0deg] hover:scale-105 transition-all duration-500 text-left">
                    
                    <!-- Card Header -->
                    <div class="flex justify-between items-center mb-6 border-b border-slate-700/50 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                                <i class="fas fa-bolt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-base leading-tight">System Status</h3>
                                <p class="text-slate-400 text-xs">Real-time tracking</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1.5 rounded-full border border-emerald-500/20">
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                            <span class="text-emerald-400 text-[10px] font-bold tracking-wider uppercase">Online</span>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-slate-700/30 border border-slate-600/30 rounded-2xl p-4 hover:bg-slate-700/50 transition-colors">
                            <p class="text-slate-400 text-xs mb-1">Resolved</p>
                            <div class="flex items-end gap-2">
                                <span class="text-2xl font-black text-white">8,459</span>
                                <span class="text-teal-400 text-xs font-bold mb-1"><i class="fas fa-arrow-up mr-1"></i>12%</span>
                            </div>
                        </div>
                        <div class="bg-slate-700/30 border border-slate-600/30 rounded-2xl p-4 hover:bg-slate-700/50 transition-colors">
                            <p class="text-slate-400 text-xs mb-1">Avg Response</p>
                            <div class="flex items-end gap-2">
                                <span class="text-2xl font-black text-white">1.2h</span>
                                <span class="text-emerald-400 text-xs font-bold mb-1"><i class="fas fa-arrow-down mr-1"></i>5%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mock Graph -->
                    <div class="bg-slate-700/30 border border-slate-600/30 rounded-2xl p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-white text-sm font-semibold">Weekly Activity</h4>
                            <i class="fas fa-ellipsis-h text-slate-500 text-xs cursor-pointer hover:text-white transition-colors"></i>
                        </div>
                        <div class="flex items-end justify-between h-20 gap-2">
                            <!-- Bars -->
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[30%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-teal-500/30 group-hover:bg-teal-500/50 transition-colors h-full rounded-t-sm"></div>
                            </div>
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[50%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-teal-500/50 group-hover:bg-teal-500/70 transition-colors h-full rounded-t-sm"></div>
                            </div>
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[80%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-emerald-500/70 group-hover:bg-emerald-500/90 transition-colors h-full rounded-t-sm"></div>
                            </div>
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[60%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-emerald-400/60 group-hover:bg-emerald-400/80 transition-colors h-full rounded-t-sm"></div>
                            </div>
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[90%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-teal-500 to-emerald-400 group-hover:brightness-110 transition-all h-full rounded-t-sm shadow-[0_0_15px_rgba(16,185,129,0.4)]"></div>
                            </div>
                            <div class="w-full bg-slate-600/30 rounded-t-sm h-[40%] relative group">
                                <div class="absolute inset-x-0 bottom-0 bg-teal-500/40 group-hover:bg-teal-500/60 transition-colors h-full rounded-t-sm"></div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2 text-[10px] text-slate-500 font-medium px-1">
                            <span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="/" class="flex items-center gap-4 justify-center mb-6 hover:scale-105 transition-transform">
                <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-teal-500/30">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
                <span class="text-4xl font-black text-white tracking-tight">CSRTS</span>
            </a>
            <p class="text-slate-400 text-lg leading-relaxed">The all-in-one platform to submit, track, and resolve complaints effortlessly with smart analytics.</p>
        </div>

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-20px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

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
    </div>

    <!-- Right Side: Scrollable Form Area -->
    <div class="w-full lg:w-1/2 lg:ml-auto min-h-screen bg-slate-900/95 lg:bg-slate-900 flex flex-col justify-center px-4 sm:px-6 lg:px-8 py-12 overflow-y-auto relative z-10 lg:border-l border-white/5 lg:shadow-[-20px_0_50px_rgba(0,0,0,0.3)]">

        <!-- Mobile Logo (Hidden on Desktop) -->
        <div class="flex lg:hidden justify-center mb-10 mt-8">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-teal-500/30">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">CSRTS</span>
            </a>
        </div>

        <!-- The Auth Form Container -->
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 shadow-2xl overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    @stack('scripts')
    
    <!-- 3D Tilt & Interactive Background -->
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

        // Initialize Vanilla Tilt on Mockup
        if (typeof VanillaTilt !== 'undefined') {
            const mockup = document.getElementById("mockup-card");
            if (mockup) {
                VanillaTilt.init(mockup, {
                    max: 10,
                    speed: 400,
                    glare: true,
                    "max-glare": 0.2,
                });
            }
        }

        // Initialize tsParticles
        if (typeof tsParticles !== 'undefined') {
            tsParticles.load("tsparticles-guest", {
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