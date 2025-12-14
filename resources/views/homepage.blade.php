<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect - Lost, Found, Adopted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); min-height: 100vh; color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .action-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(16px); border-radius: 24px; padding: 2rem; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .action-card:hover { transform: translateY(-8px); box-shadow: 0 16px 48px rgba(0,0,0,0.2); }
        .pet-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .pet-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.2); }
        .pet-image { height: 200px; object-fit: cover; width: 100%; }
        .lost-badge { position: absolute; top: 1rem; left: 1rem; background: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold; animation: pulse 2s infinite; }
        .found-badge { position: absolute; top: 1rem; left: 1rem; background: #059669; color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold; }
        .match-badge { background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold; }
        .match-progress { background: #f3f4f6; height: 4px; border-radius: 2px; overflow: hidden; margin-top: 0.25rem; }
        .match-progress-fill { height: 100%; background: linear-gradient(90deg, #8b5cf6, #ec4899); transition: width 0.5s ease; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .alert-banner { background: linear-gradient(135deg, #dc2626, #b91c1c); padding: 1rem; border-radius: 12px; text-align: center; margin-bottom: 1rem; animation: slideDown 0.5s ease; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .filter-tabs { display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .filter-tab { padding: 0.5rem 1rem; background: rgba(255,255,255,0.1); border-radius: 9999px; cursor: pointer; transition: all 0.3s ease; }
        .filter-tab.active { background: white; color: #7026e6; }
        #quickSheet { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: white; border-radius: 20px 20px 0 0; padding: 2rem; z-index: 1001; box-shadow: 0 -4px 20px rgba(0,0,0,0.1); }
        #quickSheet.active { display: block; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }

        /* Sidebar (unchanged from your original for fidelity) */
        .sidebar { position: fixed; top: 0; left: 0; width: 370px; height: 100vh; background: white; color: #1E293B; z-index: 1000; transform: translateX(-100%); transition: transform 0.35s ease; box-shadow: 8px 0 30px rgba(0,0,0,0.4); overflow-y: auto; }
        .sidebar.open { transform: translateX(0); width: 350px;}
        #hamburger { position: fixed; top: 16px; left: 16px; z-index: 1002; width: 48px; height: 48px; background: rgba(255,255,255,0.25); backdrop-filter: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .sidebar.open ~ #hamburger { display: none; }
        .mobile-search { position: fixed; top: 16px; left: 80px; right: 16px; z-index: 999; }
        @media (min-width: 769px) { .sidebar { transform: translateX(0) !important; width: 16rem; box-shadow: 2px 0 10px rgba(0,0,0,0.1); } #hamburger, .mobile-search { display: none; } .main-content { margin-left: 16rem; } }

        /* Profile Dropdown (your original styles kept intact) */
        .profile-dropdown { position: relative; margin-top: 2rem; display: inline-block; }
        .profile-trigger { cursor: pointer; transition: all 0.3s ease; }
        .profile-trigger:hover { transform: scale(1.05); }
        .dropdown-menu { position: absolute; top: calc(100% + 12px); margin-right: 10px; background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); min-width: 320px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 1000; overflow: hidden; }
        .dropdown-menu.active { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu::before { content: ''; position: absolute; top: -8px; right: 20px; width: 16px; height: 16px; background: white; transform: rotate(45deg); }
        .menu-header { background: linear-gradient(135deg, #7026e6 0%, #9d50bb 100%); padding: 24px; color: white; }
        .menu-item { padding: 14px 20px; display: flex; align-items: center; gap: 14px; color: #374151; transition: all 0.2s ease; cursor: pointer; border-left: 3px solid transparent; }
        .menu-item:hover { background: #f3f4f6; border-left-color: #7026e6; padding-left: 24px; }
        .menu-item i { width: 20px; text-align: center; font-size: 18px; color: #7026e6; }
        .menu-divider { height: 1px; background: #e5e7eb; margin: 8px 0; }
        .badge { background: #ef4444; color: white; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600; }
        .status-indicator { width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 2px solid white; position: absolute; bottom: 2px; right: 2px; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
        .dropdown-menu.active .menu-item { animation: slideIn 0.3s ease forwards; }
        .dropdown-menu.active .menu-item:nth-child(1) { animation-delay: 0.05s; }
        .dropdown-menu.active .menu-item:nth-child(2) { animation-delay: 0.1s; }
        .dropdown-menu.active .menu-item:nth-child(3) { animation-delay: 0.15s; }
        .dropdown-menu.active .menu-item:nth-child(4) { animation-delay: 0.2s; }
        .dropdown-menu.active .menu-item:nth-child(5) { animation-delay: 0.25s; }
        .dropdown-menu.active .menu-item:nth-child(6) { animation-delay: 0.3s; }
    </style>
</head>
<body class="relative">

    <!-- Hamburger -->
    <button id="hamburger" class="md:hidden" aria-label="Open menu">
        <i class="fas fa-bars text-white text-xl"></i>
    </button>

    <!-- Quick Action Sheet (Mobile) -->
    <div id="quickSheet">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
            <button id="closeSheet" aria-label="Close"><i class="fas fa-times text-gray-500"></i></button>
        </div>
        <div class="space-y-4">
            <a href="/report-lost.php" class="block p-4 bg-red-50 rounded-xl text-red-700 font-medium">Report Lost Pet</a>
            <a href="/report-found.php" class="block p-4 bg-green-50 rounded-xl text-green-700 font-medium">Report Found Pet</a>
            <a href="/adoption.php" class="block p-4 bg-purple-50 rounded-xl text-purple-700 font-medium">Browse Adoption</a>
        </div>
    </div>

    <!-- Sidebar (Your exact original structure) -->
    <aside class="sidebar">
        <div class="p-6">
            <div class="profile-dropdown ml-auto">
                <div class="profile-trigger flex items-center gap-3 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full">
                    <div class="relative">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profile" class="w-10 h-10 rounded-full border-2 border-white">
                        <div class="status-indicator"></div>
                    </div>
                    <div class="hidden md:block">
                        <div class="font-semibold text-sm">Jericoro</div>
                        <div class="text-xs text-white/70">Premium Member</div>
                    </div>
                    <i class="fas fa-chevron-down text-sm"></i>
                </div>
                
                <div class="dropdown-menu">
                    <div class="menu-header">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profile" class="w-14 h-14 rounded-full border-3 border-white/50">
                            <div>
                                <h3 class="font-bold text-lg">Jericoro</h3>
                                <p class="text-sm text-white/80">jericoro@petconnect.com</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-crown text-yellow-300 mr-1"></i> Premium
                            </div>
                            <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-paw mr-1"></i> 3 Pets
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-2">
                        <div class="menu-item">
                            <i class="fas fa-user"></i>
                            <span class="flex-1 font-medium">My Profile</span>
                        </div>
                        <div class="menu-item">
                            <i class="fas fa-heart"></i>
                            <span class="flex-1 font-medium">My Favorites</span>
                            <span class="badge">5</span>
                        </div>
                        <div class="menu-item">
                            <i class="fas fa-dog"></i>
                            <span class="flex-1 font-medium">My Pets</span>
                        </div>
                        <div class="menu-item">
                            <i class="fas fa-message"></i>
                            <span class="flex-1 font-medium">Messages</span>
                            <span class="badge">12</span>
                        </div>
                        
                        <div class="menu-divider"></div>
                        
                        <div class="menu-item">
                            <i class="fas fa-cog"></i>
                            <span class="flex-1 font-medium">Settings</span>
                        </div>
                        <div class="menu-item">
                            <i class="fas fa-question-circle"></i>
                            <span class="flex-1 font-medium">Help & Support</span>
                        </div>
                        
                        <div class="menu-divider"></div>
                        
                        <div class="menu-item" style="color: #dc2626;">
                            <i class="fas fa-sign-out-alt" style="color: #dc2626;"></i>
                            <span class="flex-1 font-medium">Sign Out</span>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="space-y-4 mt-8">
                <a href="homepage" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-paw w-5"></i>
                    <span>Adoption</span>
                </a>
                <a href="/resources/views/nav/report_lost.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-search w-5"></i>
                    <span>Lost Pet</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-cog w-5"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-bell w-5"></i>
                    <span>Notifications</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-message w-5"></i>
                    <span>Chats</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content p-6">

        <!-- Mobile Search -->
        <div class="mobile-search md:hidden">
            <div class="relative">
                <input type="text" placeholder="Search for pets..." class="w-full py-3 px-5 pr-12 rounded-full bg-white/25 backdrop-blur-md text-white placeholder-white/70 outline-none shadow-lg text-lg">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-white/70 text-xl"></i>
            </div>
        </div>

        <!-- Desktop Search -->
        <div class="hidden md:flex justify-center mb-8">
            <div class="relative w-full max-w-xl">
                <input type="text" placeholder="Search for pets..." class="w-full py-3 px-5 pr-12 rounded-full bg-white/20 backdrop-blur-md text-white placeholder-white/70 outline-none shadow-lg text-lg">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-white/70 text-xl"></i>
            </div>
        </div>

        <!-- Urgent Alert Banner -->
        <div class="alert-banner mb-8">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Urgent Alert:</strong> 5 lost pets reported in your area today (Dec 11, 2025). Enable location for real-time alerts?
            <button class="ml-4 bg-white text-red-600 px-4 py-1 rounded-full text-sm font-bold">Enable Now</button>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a href="{{ url('report_lost') }}" class="action-card text-white">
                <i class="fas fa-heart-broken text-5xl mb-4"></i>
                <h3 class="text-2xl font-bold">Report Lost Pet</h3>
                <p class="opacity-90">My pet is missing</p>
            </a>
            <a href="{{ url('report_found') }}" class="action-card text-white">
                <i class="fas fa-search-location text-5xl mb-4"></i>
                <h3 class="text-2xl font-bold">Report Found Pet</h3>
                <p class="opacity-90">I found a stray</p>
            </a>
            <a href="/adoption.php" class="action-card text-white">
                <i class="fas fa-home text-5xl mb-4"></i>
                <h3 class="text-2xl font-bold">Adopt a Pet</h3>
                <p class="opacity-90">Give a pet a forever home</p>
            </a>
        </div>

        <!-- Possible Matches -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold mb-6">Possible Matches for Your Lost Pet</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="pet-card relative">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=400" alt="Golden Retriever match" class="pet-image">
                    <span class="match-badge">96% Match</span>
                    <div class="p-4">
                        <p class="font-bold text-lg">Buddy</p>
                        <p class="text-sm text-gray-600">Golden Retriever • Found Dec 10</p>
                        <div class="match-progress"><div class="match-progress-fill" style="width: 96%;"></div></div>
                        <button class="mt-2 w-full bg-purple-600 text-white py-2 rounded-lg font-semibold">Contact Finder</button>
                    </div>
                </div>
                <div class="pet-card relative">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400" alt="Shih Tzu match" class="pet-image">
                    <span class="match-badge">82% Match</span>
                    <div class="p-4">
                        <p class="font-bold text-lg">Max</p>
                        <p class="text-sm text-gray-600">Shih Tzu • Found Dec 9</p>
                        <div class="match-progress"><div class="match-progress-fill" style="width: 82%;"></div></div>
                        <button class="mt-2 w-full bg-purple-600 text-white py-2 rounded-lg font-semibold">Contact Finder</button>
                    </div>
                </div>
                <div class="pet-card relative">
                    <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=400" alt="Persian Cat match" class="pet-image">
                    <span class="match-badge">91% Match</span>
                    <div class="p-4">
                        <p class="font-bold text-lg">Luna</p>
                        <p class="text-sm text-gray-600">Persian Cat • Found Dec 11</p>
                        <div class="match-progress"><div class="match-progress-fill" style="width: 91%;"></div></div>
                        <button class="mt-2 w-full bg-purple-600 text-white py-2 rounded-lg font-semibold">Contact Finder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pets Near You with Filters -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Pets Near You</h2>
                <a href="#" class="bg-white/20 backdrop-blur px-6 py-3 rounded-full font-medium hover:bg-white/30 transition">View All <i class="fas fa-arrow-right ml-2"></i></a>
            </div>
            <div class="filter-tabs">
                <div class="filter-tab active" data-filter="all">All</div>
                <div class="filter-tab" data-filter="lost">Lost</div>
                <div class="filter-tab" data-filter="found">Found</div>
                <div class="filter-tab" data-filter="adopt">Adopt</div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="petGrid">
                <div class="pet-card" data-type="lost">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=400" alt="Buddy" class="pet-image">
                        <span class="lost-badge">LOST</span>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-xl">Buddy</h3>
                        <p class="text-gray-600">Golden Retriever • Dec 10</p>
                        <button class="mt-3 w-full bg-red-600 text-white py-2 rounded-lg font-semibold">I've Seen This Pet</button>
                    </div>
                </div>
                <div class="pet-card" data-type="found">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=400" alt="Luna" class="pet-image">
                        <span class="found-badge">FOUND</span>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-xl">Luna</h3>
                        <p class="text-gray-600">Persian Cat • Dec 11</p>
                        <button class="mt-3 w-full bg-green-600 text-white py-2 rounded-lg font-semibold">Contact Owner</button>
                    </div>
                </div>
                <div class="pet-card" data-type="adopt">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400" alt="Coco" class="pet-image">
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-xl">Coco</h3>
                        <p class="text-gray-600">French Bulldog</p>
                        <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 rounded-lg font-semibold">Adopt Me</a>
                    </div>
                </div>
                <div class="pet-card" data-type="adopt">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400" alt="Bella" class="pet-image">
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-xl">Bella</h3>
                        <p class="text-gray-600">Beagle Mix</p>
                        <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 rounded-lg font-semibold">Adopt Me</a>
                    </div>
                </div>
                <!-- Add more dynamically via JS if needed -->
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur text-center py-8 mt-10">
        <p class="text-white/80">&copy; 2025 PetConnect. Made with Heart for pets everywhere.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        document.getElementById('hamburger').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('open'));
        document.querySelectorAll('.sidebar a').forEach(link => link.addEventListener('click', () => document.querySelector('.sidebar').classList.remove('open')));

        // Profile Dropdown (your original)
        document.querySelectorAll('.profile-dropdown').forEach(dropdown => {
            const trigger = dropdown.querySelector('.profile-trigger');
            const menu = dropdown.querySelector('.dropdown-menu');
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.dropdown-menu').forEach(m => m !== menu && m.classList.remove('active'));
                menu.classList.toggle('active');
            });
        });
        document.addEventListener('click', () => document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove('active')));
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.addEventListener('click', e => e.stopPropagation()));

        // Floating Button (now opens sheet)
        const floatBtn = document.createElement('button');
        floatBtn.id = 'floatBtn';
        floatBtn.innerHTML = '<i class="fas fa-plus"></i>';
        floatBtn.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:998;width:64px;height:64px;background:#FF6B35;color:white;border-radius:50%;box-shadow:0 10px 30px rgba(255,107,53,0.5);font-size:30px;border:none;cursor:pointer;md\\:display:none;';
        document.body.appendChild(floatBtn);
        floatBtn.addEventListener('click', () => document.getElementById('quickSheet').classList.add('active'));
        document.getElementById('closeSheet').addEventListener('click', () => document.getElementById('quickSheet').classList.remove('active'));

        // Filter Tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const filter = tab.dataset.filter;
                document.querySelectorAll('.pet-card').forEach(card => {
                    card.style.display = filter === 'all' || card.dataset.type === filter ? 'block' : 'none';
                });
            });
        });

        // Geolocation Prompt (on alert click)
        document.querySelector('.alert-banner button').addEventListener('click', () => {
            if (navigator.geolocation) navigator.geolocation.getCurrentPosition(() => alert('Location enabled! Alerts updated.'));
        });
    </script>
</body>
</html>