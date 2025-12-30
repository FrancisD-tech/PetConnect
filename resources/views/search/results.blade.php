<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results • PetConnect</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto p-6">
        <a href="/homepage" class="inline-block mb-6 text-purple-600">&larr; Back to Home</a>
        
        <h1 class="text-4xl font-bold mb-2">Search Results for "{{ $query }}"</h1>
        <p class="text-gray-600 mb-8">Found {{ $lostPets->total() + $foundPets->total() + $adoptionPets->total() }} results</p>
        
        @if($lostPets->count() > 0)
            <h2 class="text-2xl font-bold mb-4">Lost Pets</h2>
            <div class="grid md:grid-cols-4 gap-6 mb-12">
                @foreach($lostPets as $pet)
                    <a href="{{ route('lost.show', $pet) }}" class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition">
                        @if($pet->image)
                            <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">LOST</span>
                            <h3 class="font-bold text-lg mt-2">{{ $pet->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $pet->breed }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        
        <!-- Similar for Found and Adoption -->
    </div>
</body>
</html>