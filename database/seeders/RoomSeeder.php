<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'title' => 'Affordable Room in Civil Lines',
                'location' => 'Civil Lines, Gorakhpur',
                'description' => 'Clean and comfortable room near local markets and public transport.',
                'price' => 4000,
                'beds' => 1,
                'available' => true,
                'image' => 'images/rooms/civil-lines.jpg',
            ],
            [
                'title' => 'Furnished Room near Golghar',
                'location' => 'Golghar, Gorakhpur',
                'description' => 'Well-maintained room with a bed, natural light and nearby shops.',
                'price' => 5000,
                'beds' => 1,
                'available' => true,
            ],
            [
                'title' => 'Budget Room in Mohaddipur',
                'location' => 'Mohaddipur, Gorakhpur',
                'description' => 'Budget-friendly room with convenient access to local transport.',
                'price' => 3500,
                'beds' => 1,
                'available' => true,
            ],
            [
                'title' => 'Spacious Room in Taramandal',
                'location' => 'Taramandal, Gorakhpur',
                'description' => 'Spacious room in a residential area, suitable for students and working people.',
                'price' => 4500,
                'beds' => 2,
                'available' => true,
            ],
            [
                'title' => 'Student Room near Medical College',
                'location' => 'Medical College Road, Gorakhpur',
                'description' => 'Simple room for students with access to food shops and public transport.',
                'price' => 3000,
                'beds' => 1,
                'available' => true,
            ],
            [
                'title' => 'Comfortable Room in Basharatpur',
                'location' => 'Basharatpur, Gorakhpur',
                'description' => 'Comfortable room in a residential neighbourhood with nearby daily essentials.',
                'price' => 3200,
                'beds' => 1,
                'available' => true,
            ],
            [
                'title' => 'Room near Railway Station',
                'location' => 'Railway Station Road, Gorakhpur',
                'description' => 'Convenient location for people who need access to railway and local transport.',
                'price' => 5500,
                'beds' => 2,
                'available' => true,
            ],
            [
                'title' => 'Budget Stay in Betiahata',
                'location' => 'Betiahata, Gorakhpur',
                'description' => 'Simple and affordable room close to everyday shops and services.',
                'price' => 3800,
                'beds' => 1,
                'available' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(
                [
                    'title' => $room['title'],
                    'location' => $room['location'],
                ],
                $room
            );
        }
    }
}
