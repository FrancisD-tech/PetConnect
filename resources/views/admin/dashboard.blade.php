<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f3f4f6 0%, #e0e7ff 100%); min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.9); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.3); }
        .stat-card { @apply bg-white rounded-3xl shadow-2xl p-8 text-center transition hover:shadow-3xl hover:-translate-y-4; }
    </style>
</head>
<body class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="glass rounded-3xl p-8 mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-5xl font-bold text-gray-800">
                    <i class="fas fa-tachometer-alt text-purple-600 mr-4"></i> Admin Dashboard
                </h1>
                <p class="text-xl text-gray-600 mt-2">Welcome back, <strong>{{ auth()->user()->name }}</strong>!</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.verifications.index') }}" class="bg-purple-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-purple-700 transition">
                    <i class="fas fa-user-check mr-3"></i> Verifications
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-red-700 transition">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Total Users -->
            <div class="stat-card">
                <i class="fas fa-users text-6xl text-blue-500 mb-4"></i>
                <h3 class="text-5xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                <p class="text-2xl text-gray-600 mt-2">Total Users</p>
            </div>

            <!-- Adoptable Pets -->
            <div class="stat-card">
                <i class="fas fa-heart text-6xl text-pink-500 mb-4"></i>
                <h3 class="text-5xl font-bold text-gray-800">{{ $totalAdoptable }}</h3>
                <p class="text-2xl text-gray-600 mt-2">Adoptable Pets</p>
            </div>

            <!-- Lost Reports -->
            <div class="stat-card">
                <i class="fas fa-heart-broken text-6xl text-red-500 mb-4"></i>
                <h3 class="text-5xl font-bold text-gray-800">{{ $totalLost }}</h3>
                <p class="text-2xl text-gray-600 mt-2">Lost Reports</p>
            </div>

            <!-- Found Reports -->
            <div class="stat-card">
                <i class="fas fa-search-location text-6xl text-green-500 mb-4"></i>
                <h3 class="text-5xl font-bold text-gray-800">{{ $totalFound }}</h3>
                <p class="text-2xl text-gray-600 mt-2">Found Reports</p>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="glass rounded-3xl p-10 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">Quick Actions</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ route('admin.verifications.index') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-10 py-6 rounded-2xl text-2xl font-bold hover:shadow-2xl transition">
                    <i class="fas fa-user-check mr-4"></i> Manage Verifications
                </a>
                <a href="/homepage" class="bg-gradient-to-r from-teal-500 to-cyan-600 text-white px-10 py-6 rounded-2xl text-2xl font-bold hover:shadow-2xl transition">
                    <i class="fas fa-home mr-4"></i> View Homepage
                </a>
                <a href="{{ route('admin.reunited') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 text-white px-10 py-6 rounded-2xl text-2xl font-bold hover:shadow-2xl transition">
                    Reunited Pets Archive ❤️
                </a>
            </div>
        </div>
    </div>
</body>
</html>