<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Pets for Adoption • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); 
            min-height: 100vh; 
            color: white; 
        }
        .glass { 
            background: rgba(255,255,255,0.15); 
            backdrop-filter: blur(16px); 
            border: 1px solid rgba(255,255,255,0.1); 
        }
        .pet-card { 
            background: white; 
            color: #1f2937; 
            border-radius: 32px; 
            overflow: hidden; 
            box-shadow: 0 12px 40px rgba(0,0,0,0.3); 
            transition: all 0.4s ease; 
        }
        .pet-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 24px 60px rgba(0,0,0,0.4); 
        }
        .pet-img { 
            height: 320px; 
            object-fit: cover; 
            width: 100%; 
        }
        .sidebar { 
            position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; 
        }
        .sidebar.open { transform: translateX(0); }
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-filter: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; } #hamburger { display: none; } .main-content { margin-left: 16rem; } }

        /* Floating Button */
        #floatAddBtn {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 10px 30px rgba(255,107,53,0.5);
            z-index: 998;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #floatAddBtn:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(255,107,53,0.6);
        }
    </style>
</head>
<body class="relative">

    <!-- Hamburger & Sidebar (same as dashboard) -->
    <button id="hamburger" class="md:hidden"><i class="fas fa-bars text-white text-2xl"></i></button>
    <!-- Your sidebar code here — same as dashboard -->

    <main class="main-content p-6 pt-20 md:pt-8 pb-32">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-bold text-center mb-12">All Pets for Adoption</h1>
            <p class="text-2xl text-center mb-16 opacity-90">{{ $pets->total() }} loving pets waiting for a home</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                @forelse($pets as $pet)
                <a href="{{ route('adoption.show', $pet) }}" class="pet-card block">
                    <img src="{{ $pet->image ?? 'https://via.placeholder.com/600x400?text=No+Image' }}" class="pet-img">
                    <div class="p-8 text-center">
                        <h3 class="text-3xl font-bold mb-3">{{ $pet->name }}</h3>
                        <p class="text-xl text-gray-600 mb-4">{{ $pet->breed }} • {{ floor($pet->age / 12) }} yrs</p>
                        <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-2xl text-xl font-bold hover:scale-105 transition">
                            View Profile
                        </button>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-3xl opacity-80 py-20">No pets available for adoption yet. Be the first to post one!</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16 text-center">
                {{ $pets->links() }}
            </div>
        </div>
    </main>

    <!-- Floating + Button -->
    <button id="floatAddBtn" onclick="window.location.href='{{ route('adoption.create') }}'">
        <i class="fas fa-plus"></i>
    </button>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('open'));
    </script>
</body>
</html>