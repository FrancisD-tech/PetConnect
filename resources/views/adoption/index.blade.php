<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Pets • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .pet-card { background: white; color: #1f2937; border-radius: 28px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.3); transition: all 0.4s; }
        .pet-card:hover { transform: translateY(-16px); box-shadow: 0 24px 60px rgba(0,0,0,0.4); }
        .pet-img { height: 280px; object-fit: cover; }
        .sidebar { position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; }
        .sidebar.open { transform: translateX(0); }
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-blur: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; } #hamburger { display: none; } .main-content { margin-left: 16rem; } }
    </style>
</head>
<body class="relative">

    <button id="hamburger" class="md:hidden"><i class="fas fa-bars text-white text-2xl"></i></button>

    <aside class="sidebar">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-10">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-14 h-14 rounded-full border-4 border-purple-300">
                <div><h3 class="font-bold text-lg">Jericoro</h3><p class="text-sm text-gray-500">Premium Member</p></div>
            </div>
            <nav class="space-y-2">
                <a href="dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Back</a>
                <a href="index" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">Adoption</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-7xl font-bold mb-4">All Available Pets</h1>
                <p class="text-2xl opacity-90">28 loving pets waiting for you</p>
            </div>

            <div class="glass rounded-3xl p-8 mb-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <select class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none"><option>All Species</option><option>Dogs</option><option>Cats</option></select>
                    <select class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none"><option>Any Age</option><option>Puppy</option><option>Adult</option></select>
                    <select class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none"><option>Any Size</option><option>Small</option><option>Large</option></select>
                    <select class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none"><option>Any Gender</option><option>Male</option><option>Female</option></select>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                <!-- Repeat this block -->
                <a href="show" class="pet-card">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=600" class="pet-img w-full">
                    <div class="p-6 text-center">
                        <h3 class="text-3xl font-bold mb-2">Bella</h3>
                        <p class="text-xl text-gray-600">Beagle Mix • 2 years</p>
                        <button class="mt-6 w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-2xl text-xl font-bold">View Profile</button>
                    </div>
                </a>
                <!-- End repeat -->
            </div>
        </div>
    </main>
</body>
</html>