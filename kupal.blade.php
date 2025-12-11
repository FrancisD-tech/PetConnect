<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect - Adopt, Love, Cherish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); min-height: 100vh; color: white; }
        .category-card { background: white; border-radius: 16px; padding: 16px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .category-card:hover { transform: translateY(-4px); }
        .pet-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .pet-card:hover { transform: translateY(-4px); }
        .pet-image { height: 160px; object-fit: cover; width: 100%; }
        #loginModal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(12px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem; }
        #loginModal.active { display: flex; }

        /* Sidebar — hidden on mobile, visible on desktop */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 370px;
            height: 100vh;
            background: white;
            color: #1E293B;
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 0.35s ease;
            box-shadow: 8px 0 30px rgba(0,0,0,0.4);
            overflow-y: auto;
        }
        .sidebar.open { transform: translateX(0); }

        /* Floating hamburger — disappears when sidebar opens */
        #hamburger {
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1002;
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .sidebar.open ~ #hamburger { 
            display: none; 
        }

        /* Fixed search bar on mobile */
        .mobile-search {
            position: fixed;
            top: 16px;
            left: 80px;
            right: 16px;
            z-index: 999;
        }

        /* Desktop layout */
        @media (min-width: 769px) {
            .sidebar { 
                position: fixed; 
                transform: translateX(0) !important; 
                width: 16rem; 
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            #hamburger, .mobile-search { display: none; }
            .main-content { margin-left: 16rem; }
        }

        /* Profile Dropdown Styles */
        .profile-dropdown {
            position: relative;
            margin-top: 2rem;
            display: inline-block;
        }
        
        .profile-trigger {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .profile-trigger:hover {
            transform: scale(1.05);
        }
        
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 10;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            min-width: 320px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1000;
            overflow: hidden;
        }
        
        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
        }
        
        .menu-header {
            background: linear-gradient(135deg, #7026e6 0%, #9d50bb 100%);
            padding: 24px;
            color: white;
        }
        
        .menu-item {
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #374151;
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }
        
        .menu-item:hover {
            background: #f3f4f6;
            border-left-color: #7026e6;
            padding-left: 24px;
        }
        
        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 18px;
            color: #7026e6;
        }
        
        .menu-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 8px 0;
        }
        
        .badge {
            background: #ef4444;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            background: #10b981;
            border-radius: 50%;
            border: 2px solid white;
            position: absolute;
            bottom: 2px;
            right: 2px;
        }

        /* Animation for menu items */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .dropdown-menu.active .menu-item {
            animation: slideIn 0.3s ease forwards;
        }
        
        .dropdown-menu.active .menu-item:nth-child(1) { animation-delay: 0.05s; }
        .dropdown-menu.active .menu-item:nth-child(2) { animation-delay: 0.1s; }
        .dropdown-menu.active .menu-item:nth-child(3) { animation-delay: 0.15s; }
        .dropdown-menu.active .menu-item:nth-child(4) { animation-delay: 0.2s; }
        .dropdown-menu.active .menu-item:nth-child(5) { animation-delay: 0.25s; }
        .dropdown-menu.active .menu-item:nth-child(6) { animation-delay: 0.3s; }
    </style>
</head>
<body class="relative">

    <!-- Hamburger (mobile only) -->
    <button id="hamburger" class="md:hidden">
        <i class="fas fa-bars text-white text-xl"></i>
    </button>

    <!-- Sidebar (Left Navigation) -->
    <aside class="sidebar">
        <div class="p-6">
            <!-- Profile Section 
            <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Jericoro" class="w-12 h-12 rounded-full mr-3 border-2 border-purple-200">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Jericoro</h3>
                    <p class="text-sm text-gray-500">PetConnect Manager</p>
                </div>
            </div>
    -->
            <!-- Navigation -->
            <nav class="space-y-4">
                <!-- Profile Dropdown -->
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
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
                    <i class="fas fa-paw w-5"></i>
                    <span>Adoption</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition text-gray-700 font-medium">
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

        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content p-6">

        <!-- Top Bar with Profile Dropdown 
        <div class="flex justify-between items-center mb-8">
        -->
            <!-- Mobile search bar -->
            <div class="mobile-search md:hidden">
                <div class="relative">
                    <input type="text" placeholder="Search for pets..." class="w-full py-3 px-5 pr-12 rounded-full bg-white/25 backdrop-blur-md text-white placeholder-white/70 outline-none shadow-lg text-lg">
                    <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-white/70 text-xl"></i>
                </div>
            </div>  

            <!-- Desktop search bar -->
            <div class="hidden md:flex flex-1 max-w-xl">
                <div class="relative w-full">
                    <input type="text" placeholder="Search for pets..." class="w-full py-3 px-5 pr-12 rounded-full bg-white/20 backdrop-blur-md text-white placeholder-white/70 outline-none shadow-lg text-lg">
                    <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-white/70 text-xl"></i>
                </div>
            </div>


        <!-- Hero Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center mb-12">
            <!-- Left: Text & CTA -->
            <div class="text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-bold mb-4">Adopt, Love, Cherish <span class="text-pink-300">♥</span></h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">The Joy of Pet Adoption</p>
                <a href="#" class="inline-flex items-center gap-3 bg-yellow-400 text-purple-900 px-8 py-4 rounded-full text-xl font-bold shadow-xl hover:shadow-2xl transition">
                    <i class="fas fa-arrow-right"></i> Adopt Now!
                </a>
            </div>

            <!-- Right: Featured Pet -->
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600" alt="Happy Dog" class="w-full rounded-3xl shadow-2xl">
                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm text-purple-900 px-5 py-3 rounded-full font-medium shadow-lg">
                    Golden Retriever • 2 years
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="grid grid-cols-4 md:grid-cols-8 gap-4 mb-12">
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-dog"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Dogs</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-cat"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Cats</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-dove"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Rabbits</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-fish"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Birds</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-horse"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Horses</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-fish"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Fish</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-dragon"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Snake</p>
            </a>
            <a href="#" class="category-card">
                <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center text-2xl text-purple-600">
                    <i class="fas fa-ellipsis-h"></i>
                </div>
                <p class="text-sm font-medium text-gray-700">Other</p>
            </a>
        </div>

        <!-- Pets Near You -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Pets Near You</h2>
            <a href="#" class="bg-white/20 backdrop-blur px-6 py-3 rounded-full font-medium hover:bg-white/30 transition">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-12">
            <div class="pet-card">
                <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=400" alt="Buddy" class="w-full h-48 object-cover">
                <div class="p-4 text-center">
                    <h3 class="font-bold text-xl text-gray-800">Buddy</h3>
                    <p class="text-gray-600">Golden Retriever</p>
                    <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition">
                        Adopt Me
                    </a>
                </div>
            </div>
            <div class="pet-card">
                <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=400" alt="Luna" class="w-full h-48 object-cover">
                <div class="p-4 text-center">
                    <h3 class="font-bold text-xl text-gray-800">Luna</h3>
                    <p class="text-gray-600">Persian Cat</p>
                    <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition">
                        Adopt Me
                    </a>
                </div>
            </div>
            <div class="pet-card">
                <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400" alt="Coco" class="w-full h-48 object-cover">
                <div class="p-4 text-center">
                    <h3 class="font-bold text-xl text-gray-800">Coco</h3>
                    <p class="text-gray-600">French Bulldog</p>
                    <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition">
                        Adopt Me
                    </a>
                </div>
            </div>
            <div class="pet-card">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400" alt="Bella" class="w-full h-48 object-cover">
                <div class="p-4 text-center">
                    <h3 class="font-bold text-xl text-gray-800">Bella</h3>
                    <p class="text-gray-600">Beagle Mix</p>
                    <a href="#" class="mt-3 inline-block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition">
                        Adopt Me
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur text-center py-8 mt-10">
        <p class="text-white/80">&copy; 2025 PetConnect. Made with Heart for pets everywhere.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Hamburger toggle
        document.getElementById('hamburger').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('open');
        });
        
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.sidebar').classList.remove('open');
            });
        });

        // Profile dropdown toggle
        document.querySelectorAll('.profile-dropdown').forEach(dropdown => {
            const trigger = dropdown.querySelector('.profile-trigger');
            const menu = dropdown.querySelector('.dropdown-menu');
            
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    if (m !== menu) m.classList.remove('active');
                });
                
                menu.classList.toggle('active');
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('active');
            });
        });
        
        // Prevent dropdown from closing when clicking inside
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    </script>

    <!-- LOGIN MODAL -->
    <div id="loginModal">
        <div class="relative w-full max-w-4xl mx-auto bg-transparent rounded-3xl shadow-xl">
            <button onclick="document.getElementById('loginModal').classList.remove('active')" 
                    class="absolute top-4 right-4 text-white text-4xl z-50 hover:opacity-80">&times;</button>

            <div class="flex justify-center items-center p-6 lg:p-0">
                <div class="p-8 lg:p-12 bg-white rounded-3xl w-full max-w-md shadow-2xl">
                    <div class="mb-7 text-center lg:text-left">
                        <h3 class="font-semibold text-2xl text-gray-800">Sign In</h3>
                        <p class="text-gray-400 text-sm mt-2">Don't have an account? <a href="#" class="text-purple-700 hover:text-purple-800 font-medium">Sign Up</a></p>
                    </div>

                    <div class="space-y-6">
                        <input class="w-full px-4 py-3 bg-gray-200 focus:bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 transition" type="email" placeholder="Email">

                        <div class="relative">
                            <input id="passwordField" type="password" placeholder="Password" class="w-full px-4 py-3 bg-gray-200 focus:bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 transition">
                        </div>

                        <a href="#" class="block text-right text-sm text-purple-700 hover:text-purple-800">Forgot your password?</a>

                        <button class="w-full bg-purple-800 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition duration-300">
                            Sign In
                        </button>
                    </div>

                    <div class="mt-8 text-center text-xs text-gray-400">
                        Copyright © 2021-2025 PetConnect. Made with love for pets everywhere.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 