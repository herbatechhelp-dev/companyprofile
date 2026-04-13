<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('article_category_id')->nullable()->after('slug')->constrained()->onDelete('set null');
        });

        // Migrate existing data
        $articles = DB::table('articles')->get();
        foreach ($articles as $article) {
            if ($article->category) {
                $categoryId = DB::table('article_categories')->updateOrInsert(
                    ['slug' => $article->category],
                    ['name' => ucfirst($article->category), 'created_at' => now(), 'updated_at' => now()]
                );
                
                $category = DB::table('article_categories')->where('slug', $article->category)->first();
                
                DB::table('articles')->where('id', $article->id)->update([
                    'article_category_id' => $category->id
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['article_category_id']);
            $table->dropColumn('article_category_id');
        });
    }
};
