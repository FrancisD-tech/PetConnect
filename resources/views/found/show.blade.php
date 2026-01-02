<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found {{ $foundPet->species }} • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); 
            color: white; 
            min-height: 100vh;
        }
        .glass { 
            background: rgba(255,255,255,0.15); 
            backdrop-filter: blur(16px); 
            border: 1px solid rgba(255,255,255,0.1); 
        }
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
            <div class="flex items-center gap-3 mb-10">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-14 h-14 rounded-full border-4 border-purple-300">
                <div>
                    <h3 class="font-bold text-lg">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">Premium Member</p>
                </div>
            </div>
            <nav class="space-y-2">
                <a href="/homepage" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Dashboard</a>
                <a href="/dashboardL" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-red-100 text-red-700 font-bold">Lost & Found</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <a href="/homepage" class="inline-flex items-center gap-2 mb-8 text-white/80 hover:text-white text-lg">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    @if($foundPet->image)
                        <img src="{{ asset('storage/' . $foundPet->image) }}" class="w-full rounded-3xl shadow-2xl object-cover h-96">
                    @else
                        <div class="w-full rounded-3xl shadow-2xl bg-gray-300 h-96 flex items-center justify-center">
                            <p class="text-gray-600 text-2xl">No image available</p>
                        </div>
                    @endif
                </div>

                <div class="space-y-10">
                    <div>
                        <span class="inline-block px-8 py-3 bg-green-600 rounded-full text-2xl font-bold mb-4">FOUND</span>
                        <h1 class="text-7xl font-bold mb-4">Found {{ $foundPet->species }}</h1>

                      
                        <p class="text-xl opacity-80 mb-6">
                            Posted by: <strong>{{ $foundPet->user->name }}</strong>
                        </p>

                        <p class="text-3xl opacity-90">
                            {{ $foundPet->breed ?? 'Unknown breed' }} • 
                            {{ ucfirst($foundPet->gender) }}
                        </p>
                        <p class="text-xl mt-6">
                            Found on {{ \Carbon\Carbon::parse($foundPet->found_date)->format('F d, Y') }}
                        </p>
                        <p class="text-xl mt-3">
                            <strong>Location:</strong> {{ $foundPet->found_location }}
                        </p>
                        <p class="text-xl mt-3">
                            <strong>Contact:</strong> {{ $foundPet->contact_phone }}
                        </p>
                    </div>

                    @if($foundPet->description)
                    <div class="glass p-10 rounded-3xl text-xl leading-relaxed">
                        {{ $foundPet->description }}
                    </div>
                    @endif

                    <!-- UPDATED BUTTON: Opens chat with the finder -->
                    @if(auth()->id() !== $foundPet->user_id)
                        <a href="/messages?user={{ $foundPet->user_id }}" 
                           class="block w-full py-8 bg-gradient-to-r from-green-500 to-emerald-600 text-4xl font-bold text-center rounded-3xl shadow-2xl hover:scale-105 transition">
                           Message Finder
                        </a>
                    @endif

                    <!-- Optional: If the finder wants to edit or mark as claimed -->
                    @if(auth()->id() === $foundPet->user_id)
                        <div class="flex gap-4 mt-8">
                            <a href="{{ route('found.edit', $foundPet) }}" 
                               class="flex-1 py-4 bg-blue-600 text-white text-center text-xl font-bold rounded-xl hover:bg-blue-700 transition">
                                Edit Report
                            </a>
                            <!-- You can add "Mark as Claimed" button here later if needed -->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => 
            document.querySelector('.sidebar').classList.toggle('open')
        );
    </script>
</body>
</html>