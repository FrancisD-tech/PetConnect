<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification • PetConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2f136fff 0%, #7026e6ff 100%); color: white; min-height: 100vh; }
        .card { background: white; color: #1F2937; border-radius: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    </style>
</head>
<body class="p-6">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 mb-8 text-white/80 hover:text-white text-lg">
            <i class="fas fa-arrow-left"></i> Back to Profile
        </a>

        <div class="text-center mb-12">
            <i class="fas fa-shield-check text-8xl mb-6 text-white"></i>
            <h1 class="text-6xl font-bold mb-4">Account Verification</h1>
            <p class="text-2xl opacity-90">Verify your identity to unlock full features</p>
        </div>

        @if($user->verification_status === 'pending')
            <div class="card p-12 text-center">
                <i class="fas fa-clock text-yellow-500 text-8xl mb-6"></i>
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Verification Pending</h2>
                <p class="text-xl text-gray-600 mb-6">Your verification is currently under review. We'll notify you once it's approved!</p>
                <div class="bg-purple-50 p-6 rounded-xl text-left">
                    <h3 class="font-bold text-lg mb-3">Submitted Information:</h3>
                    <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
                    <p><strong>Birth Date:</strong> {{ $user->birth_date }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                    <p><strong>ID Type:</strong> {{ ucfirst(str_replace('_', ' ', $user->id_type)) }}</p>
                </div>
            </div>

        @elseif($user->verification_status === 'rejected')
            <div class="card p-12">
                <div class="text-center mb-8">
                    <i class="fas fa-times-circle text-red-500 text-8xl mb-6"></i>
                    <h2 class="text-4xl font-bold mb-4 text-gray-800">Verification Rejected</h2>
                    <div class="bg-red-50 border-2 border-red-200 p-6 rounded-xl mb-6">
                        <p class="text-lg text-red-700"><strong>Reason:</strong> {{ $user->rejection_reason }}</p>
                    </div>
                    <p class="text-xl text-gray-600">Please submit your verification again with correct information.</p>
                </div>

                <!-- Show form again for resubmission -->
                @include('verification.partials.form')
            </div>

        @else
            <div class="card p-12">
                <h2 class="text-4xl font-bold mb-8 text-center text-gray-800">Submit Verification</h2>
                
                @include('verification.partials.form')
            </div>
        @endif
    </div>
</body>
</html>
