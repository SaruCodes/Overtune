<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listIds = DB::table('lists')->pluck('id');
        $albumIds = range(1, 35);

        foreach ($listIds as $listId) {
            $albumsForList = collect($albumIds)->shuffle()->take(rand(3, 7));

            foreach ($albumsForList as $albumId) {
                DB::table('album_list')->insert([
                    'list_id' => $listId,
                    'album_id' => $albumId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
