<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportAlbums extends Command
{
    protected $signature = 'import:albums';
    protected $description = 'Importar álbumes desde un archivo JSON';

    public function handle()
    {
        $json = Storage::get('albums.json');
        $data = json_decode($json, true);

        if (!$data) {
            $this->error('El archivo JSON está vacío o mal formado.');
            return;
        }

        foreach ($data as $item) {
            $artist = \App\Models\Artist::firstOrCreate([
                'nombre' => $item['artist_name'],
            ]);

            $album = \App\Models\Album::create([
                'titulo' => $item['title'],
                'anio' => substr($item['release_date'], 0, 4),
                'cover_image' => $item['cover_image'],
                'descripcion' => $item['description'] ?? null,
            ]);
            $album->artists()->attach($artist->id);
        }

        $this->info('Álbumes importados correctamente.');
    }

}
