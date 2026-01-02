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
        .form-card { max-width: 600px; margin: 2rem auto; background: rgba(255,255,255,0.95); color: #1f2937; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .progress { height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #dc2626, #ef4444); width: 33.33%; transition: width 0.4s ease; }
        .step { display: none; }
        .step.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .upload-area {
            border: 3px dashed #7026e6;
            border-radius: 16px;
            padding: 3rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-area:hover { background: #f3e8ff; border-color: #9333ea; }
        .upload-area.uploaded {
            border-style: solid;
            border-color: #10b981;
            background: #ecfdf5;
        }
    </style>
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="p-6">
    <div class="max-w-4xl mx-auto">
        <a href="/homepage" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition mb-8">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="form-card">
            <div class="bg-green-600 text-white p-8 text-center">
                <i class="fas fa-heart text-6xl mb-4"></i>
                <h1 class="text-4xl font-bold">Report Your Found Pet</h1>
                <p class="mt-2 opacity-90">We’ll help bring them home</p>
            </div>

            <div class="p-8">
                <div class="progress mb-8"><div class="progress-fill" id="progress"></div></div>

                <form id="lostForm" method="POST" action="{{ route('lost.store') }}" enctype="multipart/form-data">
                    @csrf

                     <input type="file" name="images[]" id="photos" multiple accept="image/*" class="hidden">

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Photos -->
                    <div class="step active" data-step="1">
                        <h2 class="text-2xl font-bold mb-6">Upload Photos (up to 5)</h2>
                        <label for="photos" class="upload-area block" id="uploadArea">
                            <i class="fas fa-cloud-upload-alt text-5xl text-purple-600 mb-4"></i>
                            <p class="text-lg font-medium">Click to upload or drag & drop</p>
                            <p class="text-sm text-gray-600 mt-2">Up to 5 images (JPEG, PNG, JPG)</p>
                        </label>
                        <div id="photoPreview" class="grid grid-cols-3 gap-4 mt-6"></div>
                    </div>

                    <!-- Step 2: Details -->
                    <div class="step" data-step="2">
                        <h2 class="text-2xl font-bold mb-6">Pet Details</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!--<input type="text" name="name" placeholder="Pet Name" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none" required>-->
                            <select name="species" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none" required>
                                <option value="" disabled selected>Species</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="breed" placeholder="Breed (optional)" class="p-4 rounded-xl border border-gray-300">
                            <input type="number" name="age" placeholder="Age (years)" min="0" max="30" class="p-4 rounded-xl border border-gray-300">
                            <input type="text" name="color" placeholder="Color/Markings" class="p-4 rounded-xl border border-gray-300 md:col-span-2">
                            <select name="gender" class="p-4 rounded-xl border border-gray-300 focus:border-purple-600 outline-none md:col-span-2" required>
                                <option value="" disabled selected>Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </div>
                    </div>




                    <!-- Step 3: Location & Contact -->
                    <div class="step" data-step="3">
                        <h2 class="text-2xl font-bold mb-6">Seen Location & Contact</h2>
                        
                        <!-- Search input with autocomplete -->
                        <label class="block text-lg font-medium mb-2">Search or pinpoint on map</label>
                        <input 
                            type="text" 
                            id="location-search" 
                            name="last_seen_location" 
                            placeholder="Type address/area (e.g., park name, street)" 
                            class="w-full p-4 rounded-xl border border-gray-300 mb-4" 
                            required
                        >

                        <!-- Interactive Map -->
                        <div id="map" class="h-96 rounded-xl shadow-lg mb-6"></div>

                        <!-- Hidden fields for precise coordinates -->
                        <input type="hidden" name="lat" id="lat" required>
                        <input type="hidden" name="lng" id="lng" required>

                        <!-- Other fields -->
                        <label class="block text-lg font-medium mb-2">Seen Date</label>
                        <input type="date" name="last_seen_date" class="w-full p-4 rounded-xl border border-gray-300 mb-4" required max="{{ date('Y-m-d') }}">

                        <label class="block text-lg font-medium mb-2">Your Contact Phone</label>
                        <input type="tel" name="contact_phone" placeholder="Contact Phone" class="w-full p-4 rounded-xl border border-gray-300 mb-4" required>

                        <label class="block text-lg font-medium mb-2">Additional Details (optional)</label>
                        <textarea name="description" placeholder="Behavior, collar, microchip, etc." rows="5" class="w-full p-4 rounded-xl border border-gray-300"></textarea>
                    </div>




                    <div class="flex justify-between mt-10">
                        <button type="button" id="prevBtn" class="px-8 py-3 bg-gray-300 text-gray-700 rounded-xl font-bold" style="display:none;">Previous</button>
                        <button type="button" id="nextBtn" class="px-8 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition">Next</button>
                        <button type="submit" id="submitBtn" class="hidden px-12 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">Submit Report</button>
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
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('photos');
        const photoPreview = document.getElementById('photoPreview');
        let current = 0;

        // Photo preview + upload feedback
        fileInput.addEventListener('change', function(e) {
            photoPreview.innerHTML = '';
            const files = Array.from(e.target.files).slice(0, 5);

            if (files.length > 0) {
                // Visual feedback: success state
                uploadArea.classList.add('uploaded');
                uploadArea.innerHTML = `
                    <i class="fas fa-check-circle text-5xl text-green-600 mb-4"></i>
                    <p class="text-lg font-medium text-green-700">${files.length} photo(s) selected</p>
                    <p class="text-sm text-gray-600">You can now click Next →</p>
                `;

                // Show previews
                files.forEach(file => {
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const img = document.createElement('img');
                            img.src = ev.target.result;
                            img.classList.add('w-full', 'h-40', 'object-cover', 'rounded-xl', 'shadow-md', 'border-2', 'border-green-500');
                            photoPreview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // Next button
        nextBtn.addEventListener('click', () => {
            if (current < steps.length - 1) {
                steps[current].classList.remove('active');
                current++;
                steps[current].classList.add('active');
                progress.style.width = `${(current + 1) * 33.33}%`;
                prevBtn.style.display = 'block';

                if (current === steps.length - 1) {
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                }
            }
        });

        // Previous button
        prevBtn.addEventListener('click', () => {
            if (current > 0) {
                steps[current].classList.remove('active');
                current--;
                steps[current].classList.add('active');
                progress.style.width = `${(current + 1) * 33.33}%`;

                if (current === 0) {
                    prevBtn.style.display = 'none';
                }
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }
        });

        // SweetAlert on success (from session)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#7c3aed',
                timer: 4000,
                timerProgressBar: true
            });
        @endif
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>

    <script>
    function initMap() {
        // Default to Philippines center if no location
        let position = { lat: 7.7822, lng: 122.5868 }; // Ipil Rotonda

        // Only try to use saved coordinates if $lostPet exists and has valid lat/lng
        @if(isset($lostPet) && $lostPet->lat && $lostPet->lng && $lostPet->lat != 0 && $lostPet->lng != 0)
            position = { lat: {{ $lostPet->lat }}, lng: {{ $lostPet->lng }} };
        @elseif(isset($lostPet) && $lostPet->last_seen_location)
            // Try to geocode the saved address
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: "{{ addslashes($lostPet->last_seen_location ?? '') }}" }, (results, status) => {
                if (status === "OK" && results[0]) {
                    position = results[0].geometry.location;
                }
                renderMap(position);
            });
            // renderMap will be called after geocode
            return;
        @endif

        renderMap(position);
    }

    function renderMap(position) {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: position,
        });

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            draggable: true,
        });

        // Update hidden fields when marker is dragged
        marker.addListener("dragend", function(event) {
            document.getElementById("lat").value = event.latLng.lat();
            document.getElementById("lng").value = event.latLng.lng();
        });

        // Optional: Search box
        const input = document.getElementById("location_search");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();
            if (places.length == 0) return;

            const place = places[0];
            if (!place.geometry || !place.geometry.location) return;

            marker.setPosition(place.geometry.location);
            map.setCenter(place.geometry.location);
            map.setZoom(15);

            document.getElementById("lat").value = place.geometry.location.lat();
            document.getElementById("lng").value = place.geometry.location.lng();
        });
    }
    </script>
</body>
</html>