<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #64439aff;
            --secondary: #9d50bb;
            --dark: #2d1b4e;
            --light: #f8f4ff;
            --gray: #dad6d6ff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #0f0a1a; color: #565454ff; line-height: 1.6; }

        nav {
            background: rgba(45, 27, 78, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        .logo { font-size: 1.8rem; font-weight: 700; color: #fff; text-decoration: none; }
        .logo i { color: var(--secondary); }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
        }
        .nav-links a:hover { color: var(--secondary); }
        .nav-links a::after {
            content: ''; position: absolute; width: 0; height: 2px; bottom: -5px; left: 0;
            background: var(--secondary); transition: width 0.3s;
        }
        .nav-links a:hover::after { width: 100%; }
        .icon { display: none; font-size: 1.8rem; cursor: pointer; color: #fff; }

        .hero {
            height: 100vh;
            background: linear-gradient(135deg, #2d1b4e 0%, #0f0a1a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .wave-bottom {
            position: absolute;
            bottom: 0;
            width: 200%;
            height: 300px;
            background: white;
            clip-path: ellipse(100% 55% at 50% 100%);
        }
        .hero-content { z-index: 2; max-width: 900px; padding: 0 20px; }
        .hero h1 { font-size: 4.5rem; margin-bottom: 20px; font-weight: 700; color: var(--gray); }
        .hero p { font-size: 1.3rem; margin-bottom: 40px; color: var(--gray); }
        .btn {
            padding: 15px 40px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #5a3a8d;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(110, 72, 170, 0.4);
        }
        section { padding: 100px 5%; background: white; color: #333; }
        .section-title { text-align: center; font-size: 2.8rem; margin-bottom: 60px; color: var(--primary); }
        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .pet-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: 0.4s;
        }
        .pet-card:hover { transform: translateY(-15px); }
        .pet-card img { width: 100%; height: 250px; object-fit: cover; }
        .pet-info { padding: 25px; text-align: center; }
        .pet-info h3 { font-size: 1.5rem; margin-bottom: 10px; color: var(--primary); }
        footer { background: var(--dark); color: #ccc; text-align: center; padding: 50px 20px; font-size: 0.9rem; }

        @media (max-width: 768px) {
            .nav-links { display: none; flex-direction: column; position: absolute; top: 70px; left: 0; width: 100%; background: rgba(45,27,78,0.95); padding: 20px 0; }
            .nav-links.active { display: flex; }
            .nav-links a { margin: 15px 0; text-align: center; }
            .icon { display: block; }
            .hero h1 { font-size: 3.2rem; }
        }

        /* Login Modal */
        #loginModal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            
        }
        #loginModal.active { display: flex; }
    </style>
</head>
<body>

<!-- Navigation -->
<nav>
    <a href="{{ url('/') }}" class="logo"><i class="fas fa-paw"></i> PetConnect</a>
    <div class="nav-links" id="navLinks">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/findpet') }}">Adopt</a>
        <a href="{{ url('/report') }}">Report Lost</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="homepage" onclick="document.getElementById('loginModal').classList.add('active'); event.preventDefault();" 
            style="background:var(--primary); padding:10px 25px; border-radius:50px; cursor:pointer;">Sign In</a>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()"><i class="fa fa-bars"></i></a>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-content">
        <h1>Every Pet Deserves a Home</h1>
        <p>Connect with lost and found pets in your community. Report, adopt, and reunite with love.</p>
        <a href="{{ url('/login') }}" class="btn">Adopt a Pet Today</a>
    </div>
    <div class="wave-bottom"></div>
</section>

<!-- Featured Pets -->
<section>
    <h2 class="section-title">Pets Looking for Forever Homes</h2>
    <div class="pets-grid">
        <div class="pet-card">
            <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=500" alt="Dog">
            <div class="pet-info">
                <h3>Max</h3>
                <p>2 years old • Golden Retriever • Male</p>
                <a href="{{ url('/login') }}" class="btn" style="font-size:0.9rem; padding:10px 25px; margin-top:15px;">Adopt Me</a>
            </div>
        </div>
        <div class="pet-card">
            <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=500" alt="Cat">
            <div class="pet-info">
                <h3>Luna</h3>
                <p>1 year old • Domestic Shorthair • Female</p>
                <a href="{{ url('/login') }}" class="btn" style="font-size:0.9rem; padding:10px 25px; margin-top:15px;">Adopt Me</a>
            </div>
        </div>
        <div class="pet-card">
            <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=500" alt="Rabbit">
            <div class="pet-info">
                <h3>Coco</h3>
                <p>8 months old • Rabbit • Male</p>
                <a href="{{ url('/login') }}" class="btn" style="font-size:0.9rem; padding:10px 25px; margin-top:15px;">Adopt Me</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <p>© 2021-2025 PetConnect. Made with love for pets everywhere.</p>
</footer>

<!-- SAME TAILWIND LOGIN POPUP AS ALL PAGES -->
<div id="loginModal">
    <div class="relative w-full max-w-4xl mx-auto bg-transparent rounded-3xl shadow-xl">
        <button onclick="document.getElementById('loginModal').classList.remove('active')" 
                class="absolute top-4 right-4 text-white text-4xl z-50 hover:opacity-80">&times;</button>

        <div class="flex justify-center items-center p-6 lg:p-0">
            <div class="p-8 lg:p-12 bg-white rounded-3xl w-full max-w-md shadow-2xl">
                <div class="mb-7 text-center lg:text-left">
                    <h3 class="font-semibold text-2xl text-gray-800">Sign In</h3>
                    <p class="text-gray-400 text-sm mt-2">Don't have an account? <a href="signup" class="text-purple-700 hover:text-purple-800 font-medium">Sign Up</a></p>
                </div>

                <div class="space-y-6">
                    <input class="w-full px-4 py-3 bg-gray-200 focus:bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 transition" type="email" placeholder="Email">

                <div class="relative">
                    <input id="passwordField" type="password" placeholder="Password" class="w-full px-4 py-3 bg-gray-200 focus:bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 transition">
                    <div class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePassword()">
                        <!-- Eye Open Icon (visible by default) -->
                        <svg id="eyeOpen" class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/>
                        </svg>
                        <!-- Eye Closed Icon (hidden by default) -->
                        <svg id="eyeClosed" class="h-5 w-5 text-purple-700 hidden" fill="none" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39c-8.4 1.67-17.12 2.61-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"/>
                        </svg>  
                    </div>
                </div>

                    <a href="forgotpassword" class="block text-right text-sm text-purple-700 hover:text-purple-800">Forgot your password?</a>

                    <button onclick="location.href='homepage'" class="w-full bg-purple-800 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition duration-300">
                        Sign In
                    </button>

                    <div class="flex items-center justify-center my-6">
                        <span class="px-4 bg-white text-gray-400 text-sm">or</span>
                        <div class="absolute left-0 right-0 h-px bg-gray-300 -z-10"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-center gap-3 border border-gray-300 hover:bg-gray-50 py-3 rounded-lg transition">
                            <svg class="w-5" viewBox="0 0 24 24"><path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/><path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/><path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/><path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/></svg>
                            Google
                        </button>
                        <button class="flex items-center justify-center gap-3 border border-gray-300 hover:bg-gray-50 py-3 rounded-lg transition">
                            <svg class="w-5" viewBox="0 0 24 24"><path fill="#1877F2" d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0z"/><path fill="#FFF" d="M13.5 19.5h-3v-9h-3l.45-3h2.55v-1.95c0-2.25 1.35-3.45 3.3-3.45.9 0 1.65.15 1.65.15v2.7h-1.2c-.75 0-1.05.3-1.05 1.05v1.5h2.25l-.3 3h-1.95v9z"/></svg>
                            Facebook
                        </button>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-gray-400">
                    Copyright © 2025-2026 PetConnect. Made with love for pets everywhere.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const field = document.getElementById("passwordField");
        const eyeOpen = document.getElementById("eyeOpen");
        const eyeClosed = document.getElementById("eyeClosed");

        if (field.type == "password") {
            field.type = "text";
            eyeOpen.classList.add("hidden");
            eyeClosed.classList.remove("hidden");
        } else {
            field.type = "password";
            eyeOpen.classList.remove("hidden");
            eyeClosed.classList.add("hidden");
        }
    }

    function toggleMenu() {
        document.getElementById("navLinks").classList.toggle("active");
    }

    window.addEventListener('click', function(e) {
            if(e.target.id === 'loginModal') {
            document.getElementById('loginModal').classList.remove('active');
        }
    });
</script>
</body>
</html>