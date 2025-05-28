<?php

namespace Database\Seeders;

use App\Models\ListModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Part\File;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data/lists.json'));
        $lists = json_decode($json, true);

        if (!$lists || !is_array($lists)) {
            throw new \Exception("El archivo JSON es inválido o está vacío: " . storage_path('app/data/lists.json'));
        }

        foreach ($lists as $item) {
            ListModel::updateOrCreate(
                ['title' => $item['title']],
                [
                    'user_id' => $item['user_id'],
                    'description' => $item['description'] ?? null
                ]
            );
        }
    }
}
