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
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-blur: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .pet-card { background: white; color: #1f2937; border-radius: 32px; overflow: hidden; box-shadow: 0 16px 50px rgba(0,0,0,0.3); }
        .status { @apply px-6 py-3 rounded-full text-sm font-bold; }
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
            <!-- Your dropdown -->
            <nav class="space-y-2 mt-8">
                <a href="homepage" class="flex items-center gap-4 px-4 py-3 rounded-xl bg-purple-100 text-purple-700 font-bold">back</a>
            </nav>
        </div>
    </aside>

    <main class="main-content p-6 pt-20 md:pt-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-6xl md:text-8xl font-bold mb-4">My Pets</h1>
                <p class="text-2xl opacity-90">3 beloved family members</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="pet-card">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=800" class="w-full h-80 object-cover">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-4xl font-bold">Max</h3>
                            <span class="status bg-green-100 text-green-700">Safe at Home</span>
                        </div>
                        <p class="text-2xl text-gray-600 mb-6">Golden Retriever • Male • 3 years</p>
                        <div class="space-y-3 text-lg">
                            <p>Microchip: 981020000000123</p>
                            <p>Vaccinated • Neutered</p>
                        </div>
                    </div>
                </div>
                <!-- Repeat for other pets -->
            </div>
        </div>
    </main>
</body>
</html>