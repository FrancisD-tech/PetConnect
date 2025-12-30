<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Center • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    

    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); min-height: 100vh; color: white; }
       .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .stat-card { @apply glass rounded-3xl p-10 text-center transition hover:scale-105; }
        .sidebar { position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; overflow-y: auto; }
        .sidebar.open { transform: translateX(0); }
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-blur: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; } #hamburger { display: none; } .main-content { margin-left: 16rem; } }
        
    </style> 
</head>
<body class="relative">

    <button id="hamburger" class="md:hidden"><i class="fas fa-bars text-white text-2xl"></i></button>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-10">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-14 h-14 rounded-full border-4 border-purple-300">
                <div><h3 class="font-bold text-lg">Jericoro</h3><p class="text-sm text-gray-500">Premium Member</p></div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('homepage') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Dashboard</a>
                <a href="{{ route('adoption.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">Adoption</a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Lost Pets</a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Found Pets</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-6xl md:text-8xl font-bold mb-6">Adoption Center</h1>
            <p class="text-2xl mb-12 opacity-90">Every pet deserves a loving home. Start your journey today.</p>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="stat-card">
                    <div class="text-6xl mb-4">{{ $available }}</div>
                    <p class="text-2xl font-bold">{{ $available }}</p>
                    <p>Pets Available</p>
                </div>
                <div class="stat-card">
                    <div class="text-6xl mb-4">{{ $adopted }}</div>
                    <p class="text-2xl font-bold">{{ $adopted }}</p>
                    <p>Happy Adoptions</p>
                </div>
                <div class="stat-card">
                    <div class="text-6xl mb-4">4.9</div>
                    <p class="text-2xl font-bold">4.9 ★</p>
                    <p>Community Rating</p>
                </div>
            </div>

            <a href="/adoption/index" class="inline-block px-16 py-8 bg-gradient-to-r from-purple-600 to-pink-600 text-3xl font-bold rounded-full shadow-2xl hover:shadow-purple-500/50 transition transform hover:scale-105">
                Browse All Pets
            </a>
        </div>
    </main>
</body>
</html>