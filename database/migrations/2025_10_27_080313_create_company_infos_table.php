<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('page'); // our-group, sustainability, legal
            $table->string('title');
            $table->text('description');
            $table->string('banner_image')->nullable();
            $table->json('icons')->nullable(); // untuk icon informatif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};