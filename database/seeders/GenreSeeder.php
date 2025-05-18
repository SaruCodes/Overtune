<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Rock',
            'Pop',
            'Hip-Hop',
            'Jazz',
            'K-pop',
            'Hyperpop',
            'Indie',
            'Electronica',
            'Clasica',
            'Reggae',
            'Metal',
            'Folk',
            'Latina',
            'R&B',
            'Soul',
            'Trap'
        ];

        foreach ($genres as $genre) {
            Genre::create(['genre' => $genre]);
        }
    }
}
