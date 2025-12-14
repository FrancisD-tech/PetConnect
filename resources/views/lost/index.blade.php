<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,111 initial-scale=1.0">
    <title>Lost & Found Reports • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .report-card { background: white; color: #1f2937; border-radius: 28px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.3); transition: all 0.4s; }
        .report-card:hover { transform: translateY(-12px); }
        .badge { @apply px-5 py-2 rounded-full text-sm font-bold; }
        .lost { background: #dc2626; color: white; }
        .found { background: #059669; color: white; }
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
                <a href="dashboardL" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Dashboard</a>
                <a href="dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-red-100 text-red-700 font-bold">Lost & Found</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-bold text-center mb-12">Lost & Found Reports</h1>

            <div class="glass rounded-3xl p-6 mb-10">
                <div class="grid md:grid-cols-3 gap-6">
                    <input type="text" placeholder="Search by name, breed, location..." class="px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none">
                    <select class="px-8 py-5 rounded-2xl bg-white/20 text-xl outline-none"><option>All Status</option><option>Lost</option><option>Found</option></select>
                    <button class="px-12 py-5 bg-white/30 rounded-2xl font-bold text-xl hover:bg-white/40 transition">Search</button>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Lost Pet -->
                <a href="showL" class="report-card">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600" class="w-full h-64 object-cover">
                        <span class="badge lost absolute top-6 left-6">LOST</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-3xl font-bold mb-2">Max</h3>
                        <p class="text-xl text-gray-600">Golden Retriever • Male • 3 years</p>
                        <p class="mt-4 text-lg">Last seen: Quezon City • 2 days ago</p>
                    </div>
                </a>

                <!-- Found Pet -->
                <a href="showL" class="report-card">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=600" class="w-full h-64 object-cover">
                        <span class="badge found absolute top-6 left-6">FOUND</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-3xl font-bold mb-2">Luna</h3>
                        <p class="text-xl text-gray-600">Persian Cat • Female</p>
                        <p class="mt-4 text-lg">Found: Makati • Today</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>