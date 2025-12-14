<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Pet • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; }
        .glass { background: rgba(255,255,255,0.15); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto p-6">
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
                    <p class="text-3xl opacity-90">
                        {{ $foundPet->breed ?? 'Unknown breed' }} • 
                        {{ ucfirst($foundPet->gender) }}
                    </p>
                    <p class="text-xl mt-6">Found on {{ $foundPet->found_date->format('F d, Y') }}</p>
                    <p class="text-xl mt-3"><strong>Location:</strong> {{ $foundPet->found_location }}</p>
                    <p class="text-xl mt-3"><strong>Contact:</strong> {{ $foundPet->contact_phone }}</p>
                </div>

                @if($foundPet->description)
                <div class="glass p-10 rounded-3xl text-xl leading-relaxed">
                    {{ $foundPet->description }}
                </div>
                @endif

                <button onclick="alert('Contact: {{ $foundPet->contact_phone }}')" 
                        class="w-full py-8 bg-gradient-to-r from-green-500 to-emerald-600 text-4xl font-bold rounded-3xl shadow-2xl hover:scale-105 transition">
                    This is My Pet!
                </button>
            </div>
        </div>
    </div>
</body>
</html>