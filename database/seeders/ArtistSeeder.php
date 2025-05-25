<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data/artists.json'));
        $artists = json_decode($json, true);

        foreach ($artists as $artist) {
            Artist::updateOrCreate(
                ['name' => $artist['name']],
                [
                    'bio' => $artist['bio'],
                    'image' => $artist['image'],
                    'country' => $artist['country'],
                    'debut' => $artist['debut'],
                ]
            );
        }
    }
}
