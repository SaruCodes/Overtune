<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Artist;

class ImportArtists extends Command
{
    protected $signature = 'app:import-artists';
    protected $description = 'Importar artistas desde JSON';

    // app/Console/Commands/ImportArtists.php
    public function handle()
    {
        $path = storage_path('app/data/artists.json');
        if (! file_exists($path)) {
            $this->error("❌ No existe: {$path}");
            return;
        }

        $artistas = json_decode(file_get_contents($path), true);
        if (! is_array($artistas)) {
            $this->error('❌ JSON mal formado.');
            return;
        }

        foreach ($artistas as $artista) {
            \App\Models\Artist::firstOrCreate(
                ['name' => $artista['name']],
                [
                    'bio'     => $artista['bio']     ?? null,
                    'country' => $artista['country'] ?? null,
                    'debut'   => $artista['debut']   ?? null,
                    'image'   => $artista['image']   ?? null,
                ]
            );
        }

        $this->info('✅ Artistas importados.');
    }


}
