<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data/comments.json'));
        $comments = json_decode($json, true);

        if (!$comments || !is_array($comments)) {
            throw new \Exception("El archivo JSON es inválido o está vacío: " . storage_path('app/data/comments.json'));
        }
        foreach ($comments as $comment) {
            $createdAt = Carbon::parse($comment['created_at'])->format('Y-m-d H:i:s');

            Comment::updateOrCreate(
                [
                    'content' => $comment['content'],
                    'user_id' => $comment['user_id'],
                    'commentable_id' => $comment['commentable_id'],
                    'commentable_type' => $comment['commentable_type'],
                ],
                [
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]
            );
        }

    }
}
