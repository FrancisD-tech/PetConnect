<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lostPet->pet_name ?? 'Lost Pet' }} • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
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

            <!-- PHOTOS SECTION - MULTIPLE PHOTOS SUPPORT -->
            <div class="mb-12">
                <h3 class="text-4xl font-bold mb-6">
                    Photos 
                    @if($lostPet->images && count($lostPet->images) > 0)
                        ({{ count($lostPet->images) }})
                    @elseif($lostPet->image)
                        (1)
                    @else
                        (0)
                    @endif
                </h3>

                @if($lostPet->images && count($lostPet->images) > 0)
                    <!-- Horizontal scroll carousel for multiple photos -->
                    <div class="overflow-x-auto pb-4 scrollbar-hide">
                        <div class="flex gap-6">
                            @foreach($lostPet->images as $img)
                                <div class="flex-shrink-0">
                                    <div class="rounded-3xl overflow-hidden shadow-2xl hover:scale-105 transition duration-300">
                                        <img src="{{ asset('storage/' . $img) }}" class="w-full max-w-2xl h-96 object-cover">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if(count($lostPet->images) > 1)
                        <p class="text-center mt-4 text-white/80">← Swipe to see more photos →</p>
                    @endif

                @elseif($lostPet->image)
                    <!-- Single old photo fallback -->
                    <div class="rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('storage/' . $lostPet->image) }}" class="w-full max-w-4xl h-96 object-cover mx-auto">
                    </div>

                @else
                    <div class="rounded-3xl bg-gray-200/50 backdrop-blur border-4 border-dashed border-white/30 h-96 flex items-center justify-center">
                        <p class="text-white/70 text-3xl font-medium">No photos available</p>
                    </div>
                @endif
            </div>

            <!-- PET DETAILS -->
            <div class="grid md:grid-cols-2 gap-12">
                <div class="order-2 md:order-1 space-y-8">
                    <div>
                        <span class="inline-block px-8 py-3 bg-red-600 rounded-full text-2xl font-bold mb-4">LOST</span>
                        <h1 class="text-6xl md:text-7xl font-bold mb-4">{{ $lostPet->pet_name }}</h1>

                        <p class="text-xl opacity-80 mb-4">
                            Posted by: <strong>{{ $lostPet->user->name }}</strong>
                        </p>

                        <p class="text-3xl opacity-90">
                            {{ $lostPet->breed ?? $lostPet->species }} • 
                            {{ ucfirst($lostPet->gender) }} • 
                            {{ $lostPet->age ? $lostPet->age . ' years' : 'Age unknown' }}
                        </p>

                        <p class="text-xl mt-6">
                            Missing since {{ \Carbon\Carbon::parse($lostPet->lost_date)->format('F d, Y') }}
                        </p>

                        @if($lostPet->color)
                        <p class="text-xl mt-3">
                            <strong>Color/Markings:</strong> {{ $lostPet->color }}
                        </p>
                        @endif

                        <p class="text-xl mt-3">
                            <strong>Contact:</strong> {{ $lostPet->contact_phone }}
                        </p>
                    </div>

                    @if($lostPet->description)
                    <div class="glass p-10 rounded-3xl text-xl leading-relaxed">
                        {{ $lostPet->description }}
                    </div>
                    @endif

                    <!-- "I've Seen This Pet" Button -->
                    @if(auth()->id() !== $lostPet->user_id)
                        <a href="/messages?user={{ $lostPet->user_id }}" 
                           class="block w-full py-8 bg-gradient-to-r from-green-500 to-emerald-600 text-4xl font-bold text-center rounded-3xl shadow-2xl hover:scale-105 transition">
                            I've Seen This Pet — Message Owner
                        </a>
                    @endif

                    <!-- Owner Buttons -->
                    @if(auth()->id() === $lostPet->user_id)
                        @if(!$lostPet->is_reunited)
                            <div class="flex gap-4 mt-8">
                                <a href="{{ route('lost.edit', $lostPet) }}" 
                                   class="flex-1 py-4 bg-blue-600 text-white text-center text-xl font-bold rounded-xl hover:bg-blue-700 transition">
                                    Edit Report
                                </a>

                                <form action="{{ route('lost.reunite', $lostPet) }}" method="POST" class="flex-1"
                                      onsubmit="return confirm('Mark as reunited? This will hide the post from public view and celebrate the happy ending! ❤️')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xl font-bold rounded-xl hover:scale-105 transition shadow-lg">
                                        Mark as Reunited 🎉
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="glass p-10 rounded-3xl text-center mt-8">
                                <i class="fas fa-heart text-8xl text-pink-400 mb-6"></i>
                                <h2 class="text-4xl font-bold mb-4">Reunited! ❤️</h2>
                                <p class="text-2xl opacity-90">Your pet is safely home.</p>
                                <p class="text-xl mt-4">Thank you for using PetConnect!</p>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Map Section -->
                <div class="order-1 md:order-2">
                    <div class="glass mt-8 p-8 rounded-3xl">
                        <h3 class="text-3xl font-bold mb-4">Last Seen Location</h3>
                        <p class="text-xl mb-4">{{ $lostPet->last_seen_location }}</p>
                        <div id="map" class="h-96 rounded-2xl shadow-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Map Script -->
    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('open'));
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script>
        function initMap() {
            @if($lostPet->lat && $lostPet->lng)
                const location = { lat: {{ $lostPet->lat }}, lng: {{ $lostPet->lng }} };
            @else
                const location = { lat: 7.7822, lng: 122.5868 };
            @endif

            const map = new google.maps.Map(document.getElementById("map"), {
                center: location,
                zoom: 16,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
            });

            new google.maps.Marker({
                position: location,
                map: map,
                title: "Last seen here",
                icon: { url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png" }
            });
        }
    </script>
</body>
</html>