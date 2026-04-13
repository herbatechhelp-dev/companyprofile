<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index($category)
    {
        $categoryTitle = strtoupper($category);
        
        $articles = Article::where('category', $category)
                          ->published() // Pastikan ini dipanggil
                          ->orderBy('published_at', 'desc')
                          ->paginate(9);

        return view('articles.index', compact('articles', 'categoryTitle'));
    }

    public function show($category, $slug)
    {
        $article = Article::where('category', $category)
                         ->where('slug', $slug)
                         ->published() // Pastikan ini dipanggil
                         ->firstOrFail();

        return view('articles.detail', compact('article'));
    }
}