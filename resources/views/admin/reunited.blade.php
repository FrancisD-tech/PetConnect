<!DOCTYPE html>
<html>
<head>
    <title>Reunited Pets • Admin • PetConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-center text-purple-800">Reunited Pets Archive 🐾❤️</h1>
        <p class="text-center text-gray-600 mb-10">All pets successfully reunited with their owners</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 mb-8 text-black/80 hover:text-red text-lg">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>

        @if($reunitedPets->isEmpty())
            <p class="text-center text-2xl text-gray-500">No reunited pets yet.</p>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($reunitedPets as $pet)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    @if($pet->image)
                        <img src="{{ asset('storage/' . $pet->image) }}" class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-xl">No photo</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-bold">{{ $pet->name }}</h3>
                        <p class="text-gray-600">Owner: {{ $pet->user->name }}</p>
                        <p class="text-gray-600">Breed: {{ $pet->breed ?? $pet->species }}</p>
                        <p class="mt-4 text-green-600 font-bold text-lg">
                            <i class="fas fa-heart mr-2"></i>
                            Reunited on: {{ $pet->updated_at->format('F d, Y') }}
                        </p>
                        <p class="text-sm text-green-500">
                            at {{ $pet->updated_at->format('g:i A') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>