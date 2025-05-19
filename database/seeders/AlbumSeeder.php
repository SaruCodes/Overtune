<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Artist;

class AlbumSeeder extends Seeder
{
    public function run()
    {
        $json = file_get_contents(storage_path('app/data/albums.json'));
        $albums = json_decode($json, true);

        foreach ($albums as $albumData) {
            $artist = Artist::firstOrCreate(
                ['name' => $albumData['artist_name']],
                ['bio' => '', 'country' => null, 'debut' => null, 'image' => null]
            );

            Album::create([
                'title' => $albumData['title'],
                'artist_id' => $artist->id,
                'release_date' => $albumData['release_date'],
                'cover_image' => $albumData['cover_image'],
                'description' => $albumData['description'] ?? null,
                'type' => $albumData['type'],
            ]);
        }
    }
}
