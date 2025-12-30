<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .post-card { background: white; color: #1f2937; border-radius: 28px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.3); transition: all 0.4s; }
        .post-card:hover { transform: translateY(-12px); }
        .badge { padding: 0.5rem 1.5rem; border-radius: 9999px; font-weight: bold; font-size: 1rem; }
        .badge-lost { background: #fee2e2; color: #dc2626; }
        .badge-found { background: #d1fae5; color: #059669; }
        .badge-adopt { background: #e0e7ff; color: #6366f1; }
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
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
                <a href="{{ route('my-posts.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-pink-100 text-pink-700 font-bold">
                    <i class="fas fa-list-alt"></i> My Posts
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
                    <i class="fas fa-list-alt text-purple-400"></i> My Posts
                </h1>
                <p class="text-2xl opacity-90">All your lost, found, and adoption reports</p>
            </div>

            <!-- Lost Pet Reports -->
            <section class="mb-16">
                <h2 class="text-4xl font-bold mb-8 flex items-center gap-4">
                    <i class="fas fa-heart-broken text-red-500"></i> My Lost Pet Reports ({{ $lostPets->count() }})
                </h2>
                @if($lostPets->count() > 0)
                    <div class="grid md:grid-cols-3 gap-10">
                        @foreach($lostPets as $pet)
                        <div class="post-card">
                            <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <span class="badge badge-lost">LOST</span>
                                <h3 class="text-3xl font-bold mt-4">{{ $pet->name }}</h3>
                                <p class="text-gray-600 mt-2">{{ $pet->breed }} • {{ ucfirst($pet->gender) }}</p>
                                <p class="text-gray-600">Last seen: {{ $pet->last_seen_location }}</p>
                                <div class="flex gap-3 mt-6">
                                    <a href="{{ route('lost.show', $pet) }}" class="flex-1 bg-purple-600 text-white py-3 rounded-xl text-center font-bold hover:bg-purple-700">
                                        View
                                    </a>
                                    <a href="{{ route('lost.edit', $pet) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-xl text-center font-bold hover:bg-blue-700">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-2xl opacity-80">No lost pet reports yet.</p>
                @endif
            </section>

            <!-- Found Pet Reports -->
            <section class="mb-16">
                <h2 class="text-4xl font-bold mb-8 flex items-center gap-4">
                    <i class="fas fa-search-location text-green-500"></i> My Found Pet Reports ({{ $foundPets->count() }})
                </h2>
                @if($foundPets->count() > 0)
                    <div class="grid md:grid-cols-3 gap-10">
                        @foreach($foundPets as $pet)
                        <div class="post-card">
                            <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <span class="badge badge-found">FOUND</span>
                                <h3 class="text-3xl font-bold mt-4">Found {{ $pet->species }}</h3>
                                <p class="text-gray-600 mt-2">{{ $pet->breed ?? 'Unknown breed' }}</p>
                                <p class="text-gray-600">Found at: {{ $pet->found_location }}</p>
                                <div class="flex gap-3 mt-6">
                                    <a href="{{ route('found.show', $pet) }}" class="flex-1 bg-purple-600 text-white py-3 rounded-xl text-center font-bold hover:bg-purple-700">
                                        View
                                    </a>
                                    <a href="{{ route('found.edit', $pet) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-xl text-center font-bold hover:bg-blue-700">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-2xl opacity-80">No found pet reports yet.</p>
                @endif
            </section>

            <!-- Adoption Posts -->
            <section class="mb-16">
                <h2 class="text-4xl font-bold mb-8 flex items-center gap-4">
                    <i class="fas fa-home text-pink-500"></i> My Adoption Posts ({{ $adoptionPets->count() }})
                </h2>
                @if($adoptionPets->count() > 0)
                    <div class="grid md:grid-cols-3 gap-10">
                        @foreach($adoptionPets as $pet)
                        <div class="post-card">
                            <img src="{{ asset('storage/' . $pet->image_main) }}" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <span class="badge badge-adopt">ADOPT ME</span>
                                <h3 class="text-3xl font-bold mt-4">{{ $pet->name }}</h3>
                                <p class="text-gray-600 mt-2">{{ $pet->breed }} • {{ floor($pet->age_months / 12) }} yrs {{ $pet->age_months % 12 }} mos</p>
                                <p class="text-gray-600">Location: {{ $pet->location }}</p>
                                <div class="flex gap-3 mt-6">
                                    <a href="{{ route('adoption.show', $pet) }}" class="flex-1 bg-purple-600 text-white py-3 rounded-xl text-center font-bold hover:bg-purple-700">
                                        View
                                    </a>
                                    <a href="{{ route('adoption.edit', $pet) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-xl text-center font-bold hover:bg-blue-700">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-2xl opacity-80">No adoption posts yet.</p>
                @endif
            </section>
        </div>
    </main>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>