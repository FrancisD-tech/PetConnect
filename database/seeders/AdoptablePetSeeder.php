<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdoptablePet;

class AdoptablePetSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=600',
            'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600',
            'https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=600',
            'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=600',
            'https://images.unsplash.com/photo-1560807707-8cc77767d783?w=600',
        ];

        for ($i = 1; $i <= 20; $i++) {
            AdoptablePet::create([
                'name' => 'Pet ' . $i,
                'breed' => ['Beagle', 'Golden Retriever', 'Persian Cat', 'Shih Tzu', 'Labrador'][array_rand([0,1,2,3,4])],
                'age_months' => rand(6, 60),
                'gender' => rand(0,1) ? 'male' : 'female',
                'description' => 'Sweet and loving pet looking for a forever home.',
                'image_main' => $images[array_rand($images)],
                'location' => 'Metro Manila',
            ]);
        }
    }
}