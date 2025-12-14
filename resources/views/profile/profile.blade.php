<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .card { @apply bg-white text-gray-800 rounded-3xl shadow-2xl p-10; }
        .pet-thumb { @apply w-32 h-32 rounded-2xl object-cover border-4 border-purple-200; }
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
            <div class="profile-dropdown relative">
                <div class="profile-trigger flex items-center gap-4 p-4 rounded-2xl hover:bg-purple-50 cursor-pointer transition">
                    <div class="relative">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="{{ $user->name }}" class="w-14 h-14 rounded-full border-4 border-purple-300">
                        <div class="w-4 h-4 bg-green-500 rounded-full border-2 border-white absolute bottom-0 right-0"></div>
                    </div>
                    <div class="hidden md:block">
                        <div class="font-bold text-lg">{{ $user->name }}</div>
                        <div class="text-sm text-purple-600">Verified</div>
                    </div>
                    <i class="fas fa-chevron-down ml-auto text-purple-600"></i>
                </div>

                <div class="dropdown-menu hidden absolute top-full left-0 mt-2 w-80 bg-white rounded-3xl shadow-2xl overflow-hidden z-50">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white">
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-20 h-20 rounded-full border-4 border-white">
                            <div>
                                <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                                <p class="opacity-90">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <span class="bg-white/20 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                Verified <i class="fas fa-check-circle text-green-400"></i>
                            </span>
                            <span class="bg-white/20 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                {{ $pets->count() }} Pets
                            </span>
                        </div>
                    </div>

                    <div class="p-4 space-y-1">
                        <a href="{{ route('profile') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-purple-50 transition">
                            <i class="fas fa-user text-purple-600 text-xl"></i>
                            <span class="font-medium">My Profile</span>
                        </a>
                        <a href="{{ route('favorites.index') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-purple-50 transition">
                            <i class="fas fa-heart text-pink-600 text-xl"></i>
                            <span class="font-medium">My Favorites</span>
                            <span class="ml-auto bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">{{ $favoritesCount }}</span>
                        </a>
                        <a href="{{ route('pets.index') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-purple-50 transition">
                            <i class="fas fa-dog text-purple-600 text-xl"></i>
                            <span class="font-medium">My Pets</span>
                        </a>
                        <a href="{{ route('messages.index') }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-purple-50 transition">
                            <i class="fas fa-message text-purple-600 text-xl"></i>
                            <span class="font-medium">Messages</span>
                            @if($messagesCount > 0)
                            <span class="ml-auto bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">{{ $messagesCount }}</span>
                            @endif
                        </a>

                        <hr class="my-4 border-gray-200">

                        <a href="/settings" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-purple-50 transition">
                            <i class="fas fa-cog text-gray-600 text-xl"></i>
                            <span class="font-medium text-gray-700">Settings</span>
                        </a>

                        <hr class="my-4 border-gray-200">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-4 p-4 rounded-2xl hover:bg-red-50 transition text-red-600">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                                <span class="font-bold">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-6xl mx-auto">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-500 text-white text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="text-center mb-16">
                <h1 class="text-6xl md:text-8xl font-bold mb-4">My Profile</h1>
                <p class="text-2xl opacity-90">Welcome back, {{ $user->name }}</p>
            </div>

            <div class="glass rounded-3xl p-12 mb-12 text-center">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-40 h-40 rounded-full mx-auto border-8 border-white shadow-2xl mb-6">
                <h2 class="text-5xl font-bold mb-2">{{ $user->name }}</h2>
                <p class="text-2xl opacity-90 mb-6">{{ $user->email }}</p>
                <div class="flex justify-center gap-6">
                    <span class="bg-white/30 px-8 py-4 rounded-full text-xl font-bold flex items-center gap-3">
                        Verified <i class="fas fa-check-circle text-green-400"></i>
                    </span>
                    <span class="bg-white/30 px-8 py-4 rounded-full text-xl font-bold flex items-center gap-3">
                        {{ $pets->count() }} Pets Registered
                    </span>
                </div>
            </div>

            <div class="card mb-12">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-4xl font-bold flex items-center gap-4">
                        <i class="fas fa-dog text-purple-600"></i> My Pets
                    </h3>
                    <a href="{{ route('pets.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-purple-700">
                        <i class="fas fa-plus mr-2"></i> Add Pet
                    </a>
                </div>

                @if($pets->count() > 0)
                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach($pets as $pet)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pet->image) }}" class="pet-thumb mx-auto mb-4">
                            <h4 class="text-2xl font-bold">{{ $pet->name }}</h4>
                            <p class="text-gray-600">{{ $pet->breed }} • {{ ucfirst($pet->gender) }} • {{ $pet->age }} yrs</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 text-xl">No pets registered yet. Add your first pet!</p>
                @endif
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass rounded-3xl p-10 text-center">
                    <i class="fas fa-heart text-pink-400 text-6xl mb-4"></i>
                    <p class="text-5xl font-bold">{{ $favoritesCount }}</p>
                    <p class="text-xl opacity-90">Favorites</p>
                </div>
                <div class="glass rounded-3xl p-10 text-center">
                    <i class="fas fa-comment text-purple-400 text-6xl mb-4"></i>
                    <p class="text-5xl font-bold">{{ $messagesCount }}</p>
                    <p class="text-xl opacity-90">Unread Messages</p>
                </div>
                <div class="glass rounded-3xl p-10 text-center">
                    <i class="fas fa-trophy text-yellow-400 text-6xl mb-4"></i>
                    <p class="text-5xl font-bold">{{ $pets->count() }}</p>
                    <p class="text-xl opacity-90">Total Pets</p>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('open');
        });

        document.querySelector('.profile-trigger')?.addEventListener('click', () => {
            document.querySelector('.dropdown-menu').classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.profile-dropdown')) {
                document.querySelector('.dropdown-menu')?.classList.add('hidden');
            }
        });
    </script>
</body>
</html>