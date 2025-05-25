<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json = file_get_contents(storage_path('app/data/album_genre.json'));
        $relations = json_decode($json, true);

        foreach ($relations as $relation) {
            DB::table('album_genre')->updateOrInsert([
                'album_id' => $relation['album_id'],
                'genre_id' => $relation['genre_id'],
            ]);
        }
    }
}
