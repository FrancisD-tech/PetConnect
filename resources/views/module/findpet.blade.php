<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Adoption</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CDN for your exact login design -->
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
        .pets-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .pet-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: 0.4s; }
        .pet-card:hover { transform: translateY(-15px); }
        .pet-card img { width: 100%; height: 250px; object-fit: cover; }
        .pet-info { padding: 25px; text-align: center; }
        .pet-info h3 { font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; }
        footer { background: var(--dark); color: #ccc; text-align: center; padding: 50px 20px; font-size: 0.9rem; }

        @media screen and (max-width: 768px) {
            .nav-links { display: none; flex-direction: column; position: absolute; top: 70px; left: 0; width: 100%; background: rgba(45,27,78,0.95); padding: 20px 0; }
            .nav-links.active { display: flex; }
            .nav-links a { margin: 15px 0; text-align: center; }
            .icon { display: block; }
            .hero h1 { font-size: 3.2rem; }
        }

        /* Login Modal Overlay */
        #loginModal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(10px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
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
        <!-- This triggers the popup -->
        <a href="homepage" onclick="document.getElementById('loginModal').classList.add('active'); event.preventDefault();" 
           style="background:var(--primary); padding:10px 25px; border-radius:50px; cursor:pointer;">Sign In</a>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()"><i class="fa fa-bars"></i></a>
</nav>

<section class="hero">
    <div>
        <h1>Find Your New Best Friend</h1>
        <p>Browse loving pets waiting for their forever homes in your area.</p>
        <a href="{{ url('/login') }}" class="btn">Browse Pets</a>
    </div>
    <div class="wave-bottom"></div>
</section>

<section id="pets">
    <h2 class="section-title">Available for Adoption</h2>
    <div class="pets-grid">
        <div class="pet-card">
            <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=500" alt="Dog">
            <div class="pet-info">
                <h3>Buddy</h3>
                <p>3 years • Labrador • Male</p>
                <a href="#" class="btn" style="font-size:0.9rem;padding:10px 25px;margin-top:15px;">View Details</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <p>© 2021-2025 PetConnect. Made with love for pets everywhere.</p>
</footer>

<!-- YOUR EXACT LOGIN DESIGN AS POPUP -->
<div id="loginModal">
    <div class="relative min-h-screen sm:flex sm:flex-row justify-center bg-transparent rounded-3xl shadow-xl max-w-4xl w-full mx-4">
        <!-- Close button -->
        <button onclick="document.getElementById('loginModal').classList.remove('active')" 
                class="absolute top-4 right-4 text-white text-3xl z-50">&times;</button>

        <div class="flex justify-center self-center z-10">
            <div class="p-12 bg-white mx-auto rounded-3xl w-96">
                <div class="mb-7">
                    <h3 class="font-semibold text-2xl text-gray-800">Sign In</h3>
                    <p class="text-gray-400">Don't have an account? <a href="signup" class="text-sm text-purple-700 hover:text-purple-700">Sign Up</a></p>
                </div>
                <div class="space-y-6">
                    <input class="w-full text-sm px-4 py-3 bg-gray-200 focus:bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400" type="email" placeholder="Email">

                    <div class="relative">
                        <input placeholder="Password" type="password" class="text-sm px-4 py-3 rounded-lg w-full bg-gray-200 focus:bg-gray-100 border border-gray-200 focus:outline-none focus:border-purple-400">
                        <div class="flex items-center absolute inset-y-0 right-0 mr-3 text-sm leading-5">
                            <svg onclick="this.parentElement.parentElement.querySelector('input').type='text'" class="h-4 text-purple-700 cursor-pointer" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm ml-auto">
                            <a href="forgotpassword" class="text-purple-700 hover:text-purple-600">Forgot your password?</a>
                        </div>
                    </div>

                    <button type="submit" onclick="location.href='homepage'" class="w-full flex justify-center bg-purple-800 hover:bg-purple-700 text-gray-100 p-3 rounded-lg tracking-wide font-semibold cursor-pointer transition ease-in duration-500">
                        Sign in
                    </button>

                    <div class="flex items-center justify-center space-x-2 my-5">
                        <span class="h-px w-16 bg-gray-100"></span>
                        <span class="text-gray-300 font-normal">or</span>
                        <span class="h-px w-16 bg-gray-100"></span>
                    </div>

                    <div class="flex justify-center gap-5 w-full">
                        <button type="button" class="w-full flex items-center justify-center border border-gray-300 hover:border-gray-900 hover:bg-gray-900 text-sm text-gray-500 p-3 rounded-lg tracking-wide font-medium cursor-pointer transition ease-in duration-500">
                            <svg class="w-4 mr-2" viewBox="0 0 24 24"><path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/><path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/><path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/><path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/></svg>
                            <span>Google</span>
                        </button>
                        <button type="button" class="w-full flex items-center justify-center border border-gray-300 hover:border-gray-900 hover:bg-gray-900 text-sm text-gray-500 p-3 rounded-lg tracking-wide font-medium cursor-pointer transition ease-in duration-500">
                            <svg class="w-4 mr-2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M50 2.5c-58.892 1.725-64.898 84.363-7.46 95h14.92c57.451-10.647 51.419-93.281-7.46-95z" fill="#1877f2"/><path d="M57.46 64.104h11.125l2.117-13.814H57.46v-8.965c0-3.779 1.85-7.463 7.781-7.463h6.021V22.101c-12.894-2.323-28.385-1.616-28.722 17.66V50.29H30.417v13.814H42.54V97.5h14.92V64.104z" fill="#f1f1f1"/></svg>
                            <span>Facebook</span>
                        </button>
                    </div>
                </div>
                <div class="mt-7 text-center text-gray-300 text-xs">
                    <span>Copyright © 2021-2025 PetConnect</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        document.getElementById("navLinks").classList.toggle("active");
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