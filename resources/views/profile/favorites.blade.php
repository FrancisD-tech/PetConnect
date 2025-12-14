<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .pet-card { background: white; color: #1f2937; border-radius: 28px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.3); transition: all 0.4s; }
        .pet-card:hover { transform: translateY(-12px); }
        .heart { position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.9); width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #f43f5e; backdrop-filter: blur(10px); cursor: pointer; }
        .sidebar { position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; }
        .sidebar.open { transform: translateX(0); }
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-filter: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; } #hamburger { display: none; } .main-content { margin-left: 16rem; } }
    </style>
</head>
<body class="relative">

    <button id="hamburger" class="md:hidden"><i class="fas fa-bars text-white text-2xl"></i></button>

    <aside class="sidebar">
        <div class="p-6">
            <nav class="space-y-2 mt-8">
                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="{{ route('favorites.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-pink-100 text-pink-700 font-bold">My Favorites</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-500 text-white text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="text-center mb-12">
                <h1 class="text-6xl md:text-8xl font-bold mb-4 flex items-center justify-center gap-6">
                    <i class="fas fa-heart text-pink-500"></i> My Favorites
                </h1>
                <p class="text-2xl opacity-90">{{ $favorites->count() }} pets you've loved</p>
            </div>

            @if($favorites->count() > 0)
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-10">
                    @foreach($favorites as $favorite)
                    <div class="pet-card relative">
                        <img src="{{ asset('storage/' . $favorite->pet->image) }}" class="w-full h-72 object-cover">
                        <form action="{{ route('favorites.destroy', $favorite) }}" method="POST" class="heart">
                            @csrf
                            @method('DELETE')
                            <button type="submit"><i class="fas fa-heart"></i></button>
                        </form>
                        <div class="p-6 text-center">
                            <h3 class="text-3xl font-bold mb-2">{{ $favorite->pet->name }}</h3>
                            <p class="text-xl text-gray-600">{{ $favorite->pet->breed }} • {{ ucfirst($favorite->pet->gender) }} • {{ $favorite->pet->age }} yrs</p>
                            <button class="mt-6 w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-2xl text-xl font-bold">
                                View Profile
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center">
                    <p class="text-2xl">You haven't favorited any pets yet.</p>
                </div>
            @endif
        </div>
    </main>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>