<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CDN for your exact login design + full responsiveness -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --primary: #64439aff; --secondary: #9d50bb; --dark: #2d1b4e; --light: #f8f4ff; --gray: #dad6d6ff; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #0f0a1a; color: #565454ff; line-height: 1.6; }
        nav { background: rgba(45,27,78,0.95); backdrop-filter: blur(10px); position: fixed; width: 100%; top: 0; z-index: 1000; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 5px 20px rgba(0,0,0,0.3); }
        .logo { font-size: 1.8rem; font-weight: 700; color: #fff; text-decoration: none; }
        .logo i { color: var(--secondary); }
        .nav-links a { color: #fff; text-decoration: none; margin: 0 20px; font-weight: 500; position: relative; transition: 0.3s; }
        .nav-links a:hover { color: var(--secondary); }
        .nav-links a::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -5px; left: 0; background: var(--secondary); transition: width 0.3s; }
        .nav-links a:hover::after { width: 100%; }
        .icon { display: none; font-size: 1.8rem; cursor: pointer; color: #fff; }
        .hero { height: 100vh; background: linear-gradient(135deg, #2d1b4e 0%, #0f0a1a 100%); display: flex; align-items: center; justify-content: center; text-align: center; position: relative; overflow: hidden; }
        .wave-bottom { position: absolute; bottom: 0; width: 200%; height: 300px; background: white; clip-path: ellipse(100% 55% at 50% 100%); }
        .hero h1 { font-size: 4.5rem; font-weight: 700; color: var(--gray); margin-bottom: 20px; }
        .hero p { font-size: 1.3rem; color: var(--gray); max-width: 800px; margin: 0 auto 40px; }
        .btn { padding: 15px 40px; background: var(--primary); color: white; border: none; border-radius: 50px; font-size: 1.1rem; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn:hover { background: #5a3a8d; transform: translateY(-5px); box-shadow: 0 10px 30px rgba(110,72,170,0.4); }
        section { padding: 120px 5% 100px; background: white; color: #333; }
        .section-title { text-align: center; font-size: 2.8rem; margin-bottom: 60px; color: var(--primary); }

        @media screen and (max-width: 768px) {
            .nav-links { display: none; flex-direction: column; position: absolute; top: 70px; left: 0; width: 100%; background: rgba(45,27,78,0.95); padding: 20px 0; }
            .nav-links.active { display: flex; }
            .nav-links a { margin: 15px 0; text-align: center; }
            .icon { display: block; }
            .hero h1 { font-size: 3.2rem; }
        }

        /* Login Modal Overlay - Fully Responsive */
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

<nav>
    <a href="{{ url('/') }}" class="logo"><i class="fas fa-paw"></i> PetConnect</a>
    <div class="nav-links" id="navLinks">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/findpet') }}">Adopt</a>
        <a href="{{ url('/report') }}">Report Lost</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <!-- This opens the popup -->
        <a href="homepage" onclick="document.getElementById('loginModal').classList.add('active'); event.preventDefault();" 
           style="background:var(--primary); padding:10px 25px; border-radius:50px; cursor:pointer;">Sign In</a>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()"><i class="fa fa-bars"></i></a>
</nav>

<section class="hero">
    <div>
        <h1>About PetConnect</h1>
        <p>Reuniting pets and families</p>
    </div>
    <div class="wave-bottom"></div>
</section>

<section style="text-align:center; max-width:900px; margin:0 auto;">
    <h2 class="section-title">Our Mission</h2>
    <p style="font-size:1.2rem; margin-bottom:40px; color:#555;">
        PetConnect was born from a simple idea: To develop a digital platform that provides pet recovery, adoption, and community based animal assistance.
    </p>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:30px; margin-top:50px;">
        <div><i class="fas fa-heart" style="font-size:3rem; color:var(--primary);"></i><h3>Love</h3><p>We believe every animal deserves care and compassion.</p></div>
        <div><i class="fas fa-home" style="font-size:3rem; color:var(--primary);"></i><h3>Home</h3><p>Helping pets find safe and loving forever homes.</p></div>
        <div><i class="fas fa-users" style="font-size:3rem; color:var(--primary);"></i><h3>Community</h3><p>Stronger together — connecting people who care.</p></div>
    </div>
</section>

<footer>
    <p>© 2025-2026 PetConnect. Made with Purkiki.</p>
</footer>

<!-- YOUR EXACT TAILWIND LOGIN POPUP - FULLY RESPONSIVE -->
<div id="loginModal">
    <div class="relative w-full max-w-4xl mx-auto bg-transparent rounded-3xl shadow-xl">
        <!-- Close Button -->
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
                            <svg class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 576 512">
                                <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/>
                            </svg>
                        </div>
                    </div>

                    <a href="forgotpassword" class="block text-right text-sm text-purple-700 hover:text-purple-800">Forgot your password?</a>

                    <button class="w-full bg-purple-800 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition duration-300" onclick="location.href='homepage'">
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
                    Copyright © 2025-2026 PetConnect. Made with Purkiki.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        document.getElementById("navLinks").classList.toggle("active");
    }

    function togglePassword() {
        const field = document.getElementById("passwordField");
        field.type = field.type === "password" ? "text" : "password";
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.id === 'loginModal') {
            document.getElementById('loginModal').classList.remove('active');
        }
    });
</script>
</body>
</html>