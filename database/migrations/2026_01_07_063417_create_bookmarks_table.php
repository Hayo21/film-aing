<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('media_type'); // 'movie' atau 'anime'
            $table->string('media_id'); // ID dari TMDB atau MAL
            $table->string('title');
            $table->text('poster_url')->nullable();
            $table->text('overview')->nullable();
            $table->string('release_date')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->timestamps();

            // Pastikan user tidak bisa bookmark item yang sama 2x
            $table->unique(['user_id', 'media_type', 'media_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
