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
        Schema::table('article_categories', function (Blueprint $table) {
            $table->string('banner_image')->nullable();
            $table->string('banner_video')->nullable();
            $table->string('banner_title')->nullable();
            $table->text('banner_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_categories', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'banner_video', 'banner_title', 'banner_content']);
        });
    }
};
