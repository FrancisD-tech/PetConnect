<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pets • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .pet-card { background: white; color: #1f2937; border-radius: 32px; overflow: hidden; box-shadow: 0 16px 50px rgba(0,0,0,0.3); transition: all 0.4s; }
        .pet-card:hover { transform: translateY(-12px); }
        .status { padding: 0.75rem 1.5rem; border-radius: 9999px; font-weight: bold; }
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
            <nav class="space-y-2 mt-8">
                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
                <a href="{{ route('pets.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">
                    <i class="fas fa-dog"></i> My Pets
                </a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-500 text-white text-center font-bold text-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="text-center mb-12">
                <h1 class="text-6xl md:text-8xl font-bold mb-4 flex items-center justify-center gap-6">
                    <i class="fas fa-paw text-pink-400"></i> My Pets
                </h1>
                <p class="text-2xl opacity-90">{{ $pets->count() }} beloved family member{{ $pets->count() != 1 ? 's' : '' }}</p>
            </div>

            <div class="flex justify-end mb-8">
                <a href="{{ route('pets.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-bold text-xl hover:shadow-2xl transition flex items-center gap-3">
                    <i class="fas fa-plus"></i> Add New Pet
                </a>
            </div>

            @if($pets->count() > 0)
                <div class="grid md:grid-cols-3 gap-12">
                    @foreach($pets as $pet)
                    <div class="pet-card">
                        @if($pet->image)
                            <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-80 object-cover">
                        @else
                            <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-6xl"></i>
                            </div>
                        @endif
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-4xl font-bold">{{ $pet->name }}</h3>
                                <span class="status bg-green-100 text-green-700">Safe at Home</span>
                            </div>
                            <p class="text-2xl text-gray-600 mb-6">
                                {{ $pet->breed }} • {{ ucfirst($pet->gender) }} • 
                                {{ floor($pet->age_months / 12) }} yr{{ floor($pet->age_months / 12) != 1 ? 's' : '' }} 
                                {{ $pet->age_months % 12 }} mo
                            </p>
                            <div class="space-y-3 text-lg text-gray-700">
                                @if($pet->microchip)
                                    <p>Microchip: {{ $pet->microchip }}</p>
                                @endif
                                <p>Vaccinated • {{ $pet->neutered ? 'Neutered' : 'Not Neutered' }}</p>
                            </div>
                            <div class="flex gap-4 mt-8">
                                <a href="{{ route('pets.edit', $pet) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-xl text-center font-bold hover:bg-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete {{ $pet->name }}?')" 
                                            class="w-full bg-red-600 text-white py-3 rounded-xl font-bold hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <i class="fas fa-heart-broken text-8xl opacity-50 mb-8"></i>
                    <p class="text-3xl opacity-80">No pets registered yet.</p>
                    <a href="{{ route('pets.create') }}" class="mt-8 inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-10 py-5 rounded-2xl text-2xl font-bold hover:shadow-2xl transition">
                        Add Your First Pet
                    </a>
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