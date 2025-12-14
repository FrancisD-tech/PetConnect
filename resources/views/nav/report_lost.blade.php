<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Lost Pet | PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); min-height: 100vh; color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
        .form-card { max-width: 600px; margin: 2rem auto; background: rgba(255,255,255,0.95); color: #1f2937; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .progress { height: 6px; background: #e5e7eb; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #dc2626, #ef4444); width: 33%; transition: width 0.4s ease; }
        .step { display: none; }
        .step.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .upload-area { border: 3px dashed #7026e6; border-radius: 16px; padding: 3rem; text-align: center; cursor: pointer; transition: all 0.3s; }
        .upload-area:hover { background: #f3e8ff; border-color: #9333ea; }
    </style>
</head>
<body class="p-6">
    <div class="max-w-4xl mx-auto">
        <a href="homepage" class="inline-flex items-center gap-2 text-white/80 hover<|fim_middle|><|fim_middle|>
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="form-card">
            <div class="bg-red-600 text-white p-8 text-center">
                <i class="fas fa-heart-broken text-6xl mb-4"></i>
                <h1 class="text-4xl font-bold">Report Your Lost Pet</h1>
                <p class="mt-2 opacity-90">We’ll help bring them home</p>
            </div>

            <div class="p-8">
                <div class="progress mb-8"><div class="progress-fill" id="progress"></div></div>






                <form id="lostForm" method="POST" action="{{ route('lost.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Photos -->
                    <div class="step active" data-step="1">
                        <h2 class="text-2xl font-bold mb-6">Upload Photos (up to 5)</h2>
                        <div class="upload-area" onclick="document.getElementById('photos').click()">
                            <i class="fas fa-cloud-upload-alt text-5xl text-purple-600 mb-4"></i>
                            <p class="text-lg">Click to upload or drag & drop</p>
                            <input type="file" name="images[]" id="photos" multiple accept="image/*" class="hidden">
                        </div>
                        <div id="photoPreview" class="grid grid-cols-3 gap-4 mt-6"></div>
                    </div>

                    <!-- Step 2: Details -->
                    <div class="step" data-step="2">
                        <h2 class="text-2xl font-bold mb-6">Pet Details</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <input type="text" name="name" placeholder="Pet Name" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none" required>
                            <select name="species" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none" required>
                                <option value="">Species</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="breed" placeholder="Breed" class="p-4 rounded-xl border border-gray-300">
                            <input type="number" name="age" placeholder="Age" class="p-4 rounded-xl border border-gray-300">
                            <input type="text" name="color" placeholder="Color/Markings" class="p-4 rounded-xl border border-gray-300 md:col-span-2">
                            <select name="gender" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none md:col-span-2" required>
                                <option value="">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 3: Location & Contact -->
                    <div class="step" data-step="3">
                        <h2 class="text-2xl font-bold mb-6">Last Seen Location</h2>
                        <input type="text" name="last_seen_location" placeholder="Address or Area" class="w-full p-4 rounded-xl border border-gray-300 mb-4" required>
                        <input type="date" name="last_seen_date" class="w-full p-4 rounded-xl border border-gray-300 mb-4" required>
                        <input type="tel" name="contact_phone" placeholder="Contact Phone" class="w-full p-4 rounded-xl border border-gray-300 mb-4" required>
                        <textarea name="description" placeholder="Additional details (behavior, collar, microchip?)" rows="4" class="w-full p-4 rounded-xl border border-gray-300"></textarea>
                    </div>

                    <div class="flex justify-between mt-10">
                        <button type="button" id="prevBtn" class="px-8 py-3 bg-gray-300 text-gray-700 rounded-xl font-bold" style="display:none;">Previous</button>
                        <button type="button" id="nextBtn" class="px-8 py-3 bg-purple-600 text-white rounded-xl font-bold">Next</button>
                        <button type="submit" id="submitBtn" class="hidden px-12 py-3 bg-red-600 text-white rounded-xl font-bold">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progress = document.getElementById('progress');
        let current = 0;

        nextBtn.addEventListener('click', () => {
            if (current < steps.length - 1) {
                steps[current].classList.remove('active');
                current++;
                steps[current].classList.add('active');
                progress.style.width = `${(current + 1) * 33}%`;
                prevBtn.style.display = 'block';
                if (current === steps.length - 1) {
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                }
            }
        });

        prevBtn.addEventListener('click', () => {
            if (current > 0) {
                steps[current].classList.remove('active');
                current--;
                steps[current].classList.add('active');
                progress.style.width = `${(current + 1) * 33}%`;
                if (current === 0) prevBtn.style.display = 'none';
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }
        });

        document.getElementById('lostForm').addEventListener('submit', (e) => {
            // Form will submit normally to Laravel
        });

        // Or for found form:
        document.getElementById('foundForm').addEventListener('submit', (e) => {
            // Form will submit normally to Laravel
        });
    </script>
</body>
</html>