<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LostPet;
use App\Models\FoundPet;
use App\Models\AdoptablePet;

class PetSeeder extends Seeder
{
    public function run()
    {
        // 10 lost pets
        for ($i = 1; $i <= 10; $i++) {
            LostPet::create([
                'user_id' => 1,
                'pet_name' => 'Pet ' . $i,
                'breed' => 'Mixed Breed',
                'color' => 'Brown',
                'last_seen_location' => 'Manila',
                'lost_date' => now()->subDays(rand(1,30)),
                'description' => 'Friendly and loves treats',
                'image' => 'https://images.unsplash.com/photo-' . rand(1500000000,1600000000) . '?w=600',
            ]);
        }

        // 10 found pets
        for ($i = 1; $i <= 10; $i++) {
            FoundPet::create([
                'user_id' => 1,
                'pet_name' => null,
                'breed' => 'Unknown',
                'color' => 'Black/White',
                'found_location' => 'Quezon City',
                'found_date' => now()->subDays(rand(1,15)),
                'description' => 'Found wandering near park',
                'image' => 'https://images.unsplash.com/photo-' . rand(1500000000,1600000000) . '?w=600',
            ]);
        }

        // 15 adoptable pets
        for ($i = 1; $i <= 15; $i++) {
            AdoptablePet::create([
                'name' => 'AdoptMe ' . $i,
                'breed' => 'Mixed',
                'age_months' => rand(6,60),
                'gender' => rand(0,1) ? 'male' : 'female',
                'description' => 'Sweet and playful, ready for a forever home',
                'image_main' => 'https://images.unsplash.com/photo-' . rand(1500000000,1600000000) . '?w=600',
                'location' => 'Metro Manila',
            ]);
        }
    }
}