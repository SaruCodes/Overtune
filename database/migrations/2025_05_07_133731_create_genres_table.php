<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->enum('genre', ['Rock', 'Pop', 'Hip-Hop', 'Jazz', 'K-pop', 'Hyperpop', 'Indie', 'Electronica', 'Clasica', 'Reggae', 'Metal', 'Folk', 'Latina', 'R&B', 'Soul', 'Trap']);
            $table->timestamps();  // ← Añade esto
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
