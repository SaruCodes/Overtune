<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportAlbums extends Command
{
    protected $signature = 'app:import-albums';
    protected $description = 'Importar álbumes desde un archivo JSON';

    // app/Console/Commands/ImportAlbums.php
    public function handle()
    {
        $path = storage_path('app/data/albums.json');
        if (! file_exists($path)) {
            $this->error("❌ No existe: {$path}");
            return;
        }

        $albums = json_decode(file_get_contents($path), true);
        if (! is_array($albums)) {
            $this->error('❌ JSON mal formado.');
            return;
        }

        foreach ($albums as $item) {
            $artist = \App\Models\Artist::firstOrCreate(['name' => $item['artist_name']]);
            $album = \App\Models\Album::firstOrCreate(
                ['title' => $item['title']],
                [
                    'release_date' => $item['release_date'],
                    'type'         => $item['type'],
                    'cover_image'  => $item['cover_image']  ?? null,
                    'description'  => $item['description']  ?? null,
                ]
            );
            $album->artists()->syncWithoutDetaching($artist->id);
        }

        $this->info('✅ Álbumes importados.');
    }


}
