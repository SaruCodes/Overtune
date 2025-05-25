<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data/reviews.json'));
        $reviews = json_decode($json, true);

        foreach ($reviews as $review) {
            Review::updateOrCreate(
                ['id' => $review['id']],
                [
                    'user_id' => $review['user_id'],
                    'album_id' => $review['album_id'],
                    'content' => $review['content'],
                    'rating' => $review['rating'],
                ]
            );
        }
    }
}
