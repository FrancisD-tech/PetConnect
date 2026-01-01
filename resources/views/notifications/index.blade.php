<!DOCTYPE html>
<html>
<head>
    <title>Notifications • PetConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-purple-800">Notifications</h1>
            <a href="/homepage" class="inline-flex items-center gap-2  text-black/80 hover:text-solid-black transition mb-8">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button class="text-purple-600 hover:text-purple-800 font-medium">Mark all as read</button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-20">
                <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
                <p class="text-2xl text-gray-600">No notifications yet</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notif)
                <div class="bg-white rounded-2xl shadow-md p-6 flex items-start gap-4 {{ $notif->is_read ? 'opacity-70' : 'ring-2 ring-purple-300' }}">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                        @if($notif->type == 'verification_submitted')
                            <i class="fas fa-file-upload text-blue-600 text-xl"></i>
                        @elseif($notif->type == 'verification_approved')
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        @elseif(str_contains($notif->type, 'lost'))
                            <i class="fas fa-search text-red-600 text-xl"></i>
                        @else
                            <i class="fas fa-bell text-purple-600 text-xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-lg font-medium text-gray-800">{{ $notif->message }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notif->is_read)
                        <div class="w-3 h-3 bg-purple-600 rounded-full animate-pulse"></div>
                    @endif
                </div>
                @endforeach
            </div>

            {{ $notifications->links() }}
        @endif
    </div>
</body>
</html>