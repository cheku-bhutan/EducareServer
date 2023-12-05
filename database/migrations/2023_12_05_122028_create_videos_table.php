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
        Schema::create('videos', function (Blueprint $table) {
            $table->string('title');
            $table->date('release_date');
            $table->string('cover_photo');
            $table->string('thumbnail');
            $table->string('video_url');
            $table->string('subtitle');
            $table->string('description');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('video_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
