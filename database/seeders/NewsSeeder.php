<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data/news.json'));
        $newsItems = json_decode($json, true);

        if (!$newsItems || !is_array($newsItems)) {
            throw new \Exception("El archivo JSON es inválido o está vacío: " . storage_path('app/data/news.json'));
        }

        foreach ($newsItems as $item) {
            News::updateOrCreate(
                ['title' => $item['title']],
                [
                    'content' => $item['content'],
                    'image' => $item['image'],
                    'user_id' => $item['user_id'],
                    'category_id' => $item['category_id'],
                ]
            );
        }
    }
}
