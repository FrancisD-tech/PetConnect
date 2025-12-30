<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-5xl font-bold text-gray-800">
                <i class="fas fa-user-check text-purple-600"></i> Verification Management
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500 text-white text-center font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pending Verifications -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold mb-6 text-yellow-600">
                <i class="fas fa-clock"></i> Pending Verifications ({{ $pendingUsers->count() }})
            </h2>

            @if($pendingUsers->count() > 0)
                <div class="space-y-6">
                    @foreach($pendingUsers as $user)
                        <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-purple-300 transition">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-2xl font-bold mb-4">{{ $user->name }}</h3>
                                    <div class="space-y-2">
                                        <p><strong>Email:</strong> {{ $user->email }}</p>
                                        <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
                                        <p><strong>Birth Date:</strong> {{ $user->birth_date }}</p>
                                        <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                                        <p><strong>Address:</strong> {{ $user->address }}</p>
                                        <p><strong>ID Type:</strong> {{ ucfirst(str_replace('_', ' ', $user->id_type)) }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-bold mb-2">Government ID:</h4>
                                    @if($user->government_id)
                                        @if(Str::endsWith($user->government_id, '.pdf'))
                                            <a href="{{ asset('storage/' . $user->government_id) }}" target="_blank" 
                                            class="inline-block bg-red-100 text-red-700 px-6 py-3 rounded-xl hover:bg-red-200 font-semibold">
                                                <i class="fas fa-file-pdf text-3xl mr-3"></i> Open PDF ID
                                            </a>
                                        @else
                                            <div class="mt-4">
                                                <img src="{{ asset('storage/' . $user->government_id) }}" 
                                                    alt="Government ID of {{ $user->name }}" 
                                                    class="max-w-full h-auto rounded-xl border-4 border-gray-300 shadow-lg cursor-pointer"
                                                    onclick="window.open(this.src, '_blank')">
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-gray-500 italic">No ID uploaded</p>
                                    @endif

                                    <div class="flex gap-3 mt-6">
                                        <form action="{{ route('admin.verifications.approve', $user) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-xl font-bold hover:bg-green-600">
                                                <i class="fas fa-check mr-2"></i> Approve
                                            </button>
                                        </form>

                                        <button onclick="showRejectModal({{ $user->id }}, '{{ $user->name }}')" 
                                                class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600">
                                            <i class="fas fa-times mr-2"></i> Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 text-xl py-8">No pending verifications</p>
            @endif
        </div>

        <!-- Verified Users -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold mb-6 text-green-600">
                <i class="fas fa-check-circle"></i> Recently Verified ({{ $verifiedUsers->count() }})
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($verifiedUsers as $user)
                    <div class="border-2 border-green-200 rounded-xl p-4 bg-green-50">
                        <p class="font-bold text-lg">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-green-600">Verified: {{ $user->verified_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Rejected Users -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold mb-6 text-red-600">
                <i class="fas fa-times-circle"></i> Recently Rejected ({{ $rejectedUsers->count() }})
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($rejectedUsers as $user)
                    <div class="border-2 border-red-200 rounded-xl p-4 bg-red-50">
                        <p class="font-bold text-lg">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-red-600">Reason: {{ $user->rejection_reason }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold mb-4">Reject Verification</h3>
            <p class="mb-4">User: <span id="rejectUserName" class="font-bold"></span></p>
            
            <form id="rejectForm" method="POST">
                @csrf
                <label class="block mb-2 font-semibold">Reason for Rejection:</label>
                <textarea name="rejection_reason" required rows="4" 
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:outline-none mb-4"></textarea>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="flex-1 bg-gray-300 py-3 rounded-xl font-bold hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(userId, userName) {
            document.getElementById('rejectUserName').textContent = userName;
            document.getElementById('rejectForm').action = `/admin/verifications/${userId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</body>
</html>