<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .gallery-img { height: 520px; object-fit: cover; border-radius: 32px; }
        .thumb { height: 120px; object-fit: cover; border-radius: 20px; cursor: pointer; border: 4px solid transparent; transition: all 0.3s; }
        .thumb:hover, .thumb.active { border-color: white; }
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
                <a href="/" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-purple-100 text-gray-700 font-medium">Dashboard</a>
                <a href="/adoption" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">Adoption</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <a href="/adoption/pets" class="inline-flex items-center gap-2 mb-8 text-white/80 hover:text-white text-lg"><i class="fas fa-arrow-left"></i> Back</a>

            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <img id="mainImg" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=1200" class="gallery-img w-full shadow-2xl">
                    <div class="grid grid-cols-4 gap-4 mt-8">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=600" class="thumb active" onclick="document.getElementById('mainImg').src=this.src">
                        <img src="https://images.unsplash.com/photo-1560807707-8cc77767d783?w=600" class="thumb" onclick="document.getElementById('mainImg').src=this.src">
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=600" class="thumb" onclick="document.getElementById('mainImg').src=this.src">
                        <img src="https://images.unsplash.com/photo-1592194996308-7b43878e84b6?w=600" class="thumb" onclick="document.getElementById('mainImg').src=this.src">
                    </div>
                </div>

                <div class="space-y-10">
                    <div>
                        <h1 class="text-7xl font-bold mb-4">Bella</h1>
                        <p class="text-3xl opacity-90">Beagle Mix • Female • 2 years old</p>
                    </div>

                    <div class="glass p-10 rounded-3xl">
                        <p class="text-xl leading-relaxed">
                            Bella is the sweetest girl who loves belly rubs, long walks, and making new friends. 
                            She’s fully vaccinated, spayed, and ready for her forever home.
                        </p>
                    </div>

                    <button onclick="document.getElementById('modal').classList.remove('hidden')" 
                            class="w-full py-8 bg-gradient-to-r from-purple-600 to-pink-600 text-4xl font-bold rounded-3xl shadow-2xl hover:scale-105 transition">
                        Apply to Adopt Bella
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-6">
        <div class="glass max-w-2xl w-full rounded-3xl p-12">
            <h2 class="text-5xl font-bold text-center mb-10">Adopt Bella</h2>
            <form class="space-y-8">
                <input type="text" placeholder="Full Name" class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none">
                <input type="email" placeholder="Email" class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none">
                <textarea rows="5" placeholder="Why do you want to adopt Bella?" class="w-full px-8 py-5 rounded-2xl bg-white/20 placeholder-white/70 text-xl outline-none"></textarea>
                <button type="submit" class="w-full py-6 bg-green-600 text-2xl font-bold rounded-2xl hover:bg-green-700 transition">Submit Application</button>
            </form>
            <button onclick="this.closest('#modal').classList.add('hidden')" class="mt-6 text-center w-full text-white/70 hover:text-white">Close</button>
        </div>
    </div>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('open'));
    </script>
</body>
</html>