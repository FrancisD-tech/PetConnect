<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet • PetConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); min-height: 100vh; }
    </style>
</head>
<body class="flex items-center justify-center p-6">
    <div class="bg-white rounded-3xl p-12 max-w-2xl w-full shadow-2xl">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Add New Pet</h1>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pet Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Breed</label>
                <input type="text" name="breed" value="{{ old('breed') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                    <select name="gender" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Age (years)</label>
                    <input type="number" name="age" value="{{ old('age') }}" min="0" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Photo</label>
                <input type="file" name="image" accept="image/*" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Microchip Number (Optional)</label>
                <input type="text" name="microchip" value="{{ old('microchip') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:border-purple-600">
            </div>

            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="vaccinated" value="1" class="w-5 h-5">
                    <span class="text-gray-700 font-medium">Vaccinated</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="neutered" value="1" class="w-5 h-5">
                    <span class="text-gray-700 font-medium">Neutered/Spayed</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-purple-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-purple-700">
                    Add Pet
                </button>
                <a href="{{ route('pets.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-4 rounded-xl font-bold text-lg text-center hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>