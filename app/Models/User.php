<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'birth_date',
        'phone_number',
        'address',
        'id_type',
        'government_id',
        'verification_status',
        'verified_at',
        'rejection_reason',
        'is_admin',
        'profile_photo_path',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function conversations()
    {
        $sent = $this->sentMessages()->pluck('receiver_id');
        $received = $this->receivedMessages()->pluck('sender_id');

        $userIds = $sent->merge($received)->unique()->values();

        return User::whereIn('id', $userIds)
            ->with(['sentMessages' => fn($q) => $q->where('receiver_id', $this->id),
                    'receivedMessages' => fn($q) => $q->where('sender_id', $this->id)])
            ->get()
            ->map(function ($user) {
                $latest = $user->sentMessages->concat($user->receivedMessages)
                    ->sortByDesc('created_at')
                    ->first();

                return (object)[
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_message' => $latest?->message,
                    'last_time' => $latest?->created_at,
                ];
            });
}

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function lostPets()
    {
        return $this->hasMany(LostPet::class);
    }

    public function foundPets()
    {
        return $this->hasMany(FoundPet::class);
    }

    public function adoptionPets()
    {
        return $this->hasMany(AdoptionPet::class);
    }

    public function index()
    {
        $userId = auth()->id();

        // Get unique user IDs this user has messaged with
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select('sender_id', 'receiver_id', 'message', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($msg) use ($userId) {
                return $msg->sender_id == $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(function ($group, $otherUserId) {
                $latest = $group->first();
                $user = User::find($otherUserId);
                return (object)[
                    'id' => $otherUserId,
                    'name' => $user?->name ?? 'Unknown',
                    'last_message' => $latest->message,
                    'last_time' => $latest->created_at,
                ];
            })
            ->values();

        return view('messages', compact('conversations'));
    }
}
