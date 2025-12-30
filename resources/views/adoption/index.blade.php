<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Pets • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .pet-card { background: white; color: #1f2937; border-radius: 28px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.3); transition: all 0.4s; }
        .pet-card:hover { transform: translateY(-16px); box-shadow: 0 24px 60px rgba(0,0,0,0.4); }
        .pet-img { height: 280px; object-fit: cover; }
        .sidebar { position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; }
        .sidebar.open { transform: translateX(0); }
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-blur: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; } #hamburger { display: none; } .main-content { margin-left: 16rem; } }

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
        }
        #floatAddBtn:hover {
            transform: scale(1.1);
        }
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
                <a href="{{ route('adoption.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Back</a>
                <a href="{{ route('adoption.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">Adoption</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                 <h1 class="text-5xl md:text-7xl font-bold mb-4">All Available Pets</h1>
                <p class="text-2xl opacity-90">{{ $pets->total() }} loving pets waiting for you</p>
            </div>

            <!-- Filters -->
            <form method="GET" class="glass rounded-3xl p-8 mb-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <select name="species" class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none">
                        <option value="">All Species</option>
                        <option value="dog">Dogs</option>
                        <option value="cat">Cats</option>
                    </select>
                    <select name="age" class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none">
                        <option value="">Any Age</option>
                        <option value="12">Puppies/Kittens</option>
                        <option value="36">Young</option>
                    </select>
                    <select name="gender" class="px-6 py-4 rounded-2xl bg-white/20 text-white text-lg outline-none">
                        <option value="">Any Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <button type="submit" class="px-12 py-5 bg-white/30 rounded-2xl font-bold text-xl hover:bg-white/40 transition">Filter</button>
                </div>
            </form>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                @forelse($pets as $pet)
                <a href="{{ route('adoption.show', $pet) }}" class="pet-card">
                    <img src="{{ $pet->image_main }}" class="pet-img w-full">
                    <div class="p-6 text-center">
                        <h3 class="text-3xl font-bold mb-2">{{ $pet->name }}</h3>
                        <p class="text-xl text-gray-600">{{ $pet->breed }} • {{ $pet->age_months / 12 }} years</p>
                        <button class="mt-6 w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-2xl text-xl font-bold">
                            View Profile
                        </button>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-2xl opacity-80">No pets available right now. Check back soon!</p>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $pets->links() }}
            </div>
        </div>
    </main>
    <!-- Floating + Button -->
    <button id="floatAddBtn" onclick="openPostModal()">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Post Pet Modal -->
    <div id="postModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-6 overflow-y-auto opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="glass max-w-2xl w-full rounded-3xl p-12 my-8 relative">
        <button type="button" onclick="closePostModal()" 
                class="absolute top-4 right-4 text-white/70 hover:text-white text-3xl">
            ×
        </button>
        
        <h2 class="text-5xl font-bold text-center mb-10">Post Pet for Adoption</h2>
        
        <form action="{{ route('adoption.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Pet Name -->
            <input type="text" name="name" placeholder="Pet Name" required 
                   class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none focus:ring-4 focus:ring-green-400">
            
            <!-- Breed -->
            <input type="text" name="breed" placeholder="Breed" required 
                   class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none focus:ring-4 focus:ring-green-400">
            
            <!-- Age in Months -->
            <input type="number" name="age_months" placeholder="Age in months (e.g. 6)" min="0" required 
                   class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none focus:ring-4 focus:ring-green-400">
            
            <!-- Gender -->
            <select name="gender" required 
                    class="w-full px-8 py-5 rounded-2xl bg-white/20 text-white text-xl outline-none focus:ring-4 focus:ring-green-400">
                <option value="" disabled selected>Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            
            <!-- Location (NEW - matches your table) -->
            <input type="text" name="location" placeholder="Location (city, area)" required 
                   class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none focus:ring-4 focus:ring-green-400">
            
            <!-- Description -->
            <textarea name="description" rows="5" placeholder="Tell us about the pet (personality, health, etc.)" required 
                      class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none focus:ring-4 focus:ring-green-400 resize-none"></textarea>
            
            <!-- Main Image (matches image_main column) -->
            <div class="relative">
                <label class="block text-xl mb-3 text-white/90">Main Photo (required)</label>
                <input type="file" name="image_main" accept="image/*" required 
                       class="w-full px-8 py-5 rounded-2xl bg-white/20 text-white text-xl file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:bg-green-600 file:text-white hover:file:bg-green-700 cursor-pointer">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-6 bg-green-600 text-2xl font-bold rounded-2xl hover:bg-green-700 transition shadow-lg">
                Post for Adoption
            </button>
        </form>
    </div>
</div>
    <script>
        const postModal = document.getElementById('postModal');
        const floatBtn = document.getElementById('floatAddBtn');

        function openPostModal() {
            postModal.classList.remove('opacity-0', 'pointer-events-none');
            postModal.classList.add('opacity-100', 'pointer-events-auto');
        }

        function closePostModal() {
            postModal.classList.add('opacity-0', 'pointer-events-none');
            postModal.classList.remove('opacity-100', 'pointer-events-auto');
        }

        // Open modal
        floatBtn.addEventListener('click', openPostModal);

        // Close on X button
        postModal.querySelector('button[onclick="closePostModal()"]').addEventListener('click', closePostModal);

        // Close on outside click (but NOT on form submit)
        postModal.addEventListener('click', function(e) {
            if (e.target === postModal) {
                closePostModal();
            }
        });

        // Prevent close when clicking inside the modal content
        postModal.querySelector('.glass').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
</body>
</html>