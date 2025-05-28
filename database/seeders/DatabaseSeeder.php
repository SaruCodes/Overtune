<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $this->call(UserSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(AlbumGenreSeeder::class);
        $this->call(ListSeeder::class);
        $this->call(AlbumListSeeder::class);
    }
}
