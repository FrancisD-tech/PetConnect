<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .stat { @apply glass rounded-3xl p-10 text-center transition hover:scale-105; }
        .btn-big { @apply inline-block px-16 py-8 rounded-full text-3xl font-bold shadow-2xl transition transform hover:scale-110; }
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
                <a href="dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Dashboard</a>
                <a href="index" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Adoption</a>
                <a href="" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-red-100 text-red-700 font-bold">Lost & Found</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-6xl md:text-8xl font-bold mb-6">Lost & Found Pets</h1>
            <p class="text-2xl mb-12 opacity-90">Help bring them home. Every second counts.</p>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="stat"><div class="text-6xl mb-4">47</div><p class="text-3xl font-bold">47</p><p>Lost Today</p></div>
                <div class="stat"><div class="text-6xl mb-4">892</div><p class="text-3xl font-bold text-green-400">892</p><p>Reunited This Year</p></div>
                <div class="stat"><div class="text-6xl mb-4">98%</div><p class="text-3xl font-bold">98%</p><p>Success Rate</p></div>
            </div>

            <div class="grid md:grid-cols-2 gap-10 max-w-4xl mx-auto">
                <a href="report_lost" class="btn-big bg-gradient-to-r from-red-600 to-pink-600">
                    Report Lost Pet
                </a>
                <a href="report_found" class="btn-big bg-gradient-to-r from-green-500 to-emerald-600">
                    Report Found Pet
                </a>
            </div>

            <a href="indexL" class="inline-block mt-16 px-16 py-8 bg-white/20 rounded-full text-2xl font-bold hover:bg-white/30 transition">
                View All Reports
            </a>
        </div>
    </main>
</body>
</html>