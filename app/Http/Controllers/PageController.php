<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CompanyInfo;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Facility;
use App\Models\SiteSetting;
use App\Models\ArticleCategory;
use App\Models\MaklonFlowStep;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $heroSection = HomeSection::where('section', 'hero')->first();
        $aboutSection = HomeSection::where('section', 'about')->first();
        $productsSection = HomeSection::where('section', 'products')->first();
        $researchSection = HomeSection::where('section', 'research')->first();
        
        try {
            $maklonSteps = MaklonFlowStep::active()->ordered()->get();
        } catch (\Exception $e) {
            $maklonSteps = collect();
        }
        
        $featuredProducts = Product::with('images')->featured()->orderBy('order')->take(6)->get();
        
        return view('home', compact(
            'heroSection',
            'aboutSection',
            'productsSection',
            'researchSection',
            'featuredProducts',
            'maklonSteps'
        ));
    }

    public function articles($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();

        $articles = Article::with('images')
            ->published()
            ->where('article_category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        // Use category hero if available, otherwise fallback to general articles hero
        $heroSection = null;
        if ($category->banner_image || $category->banner_video) {
            $heroSection = (object)[
                'title' => $category->banner_title ?: $category->name,
                'content' => $category->banner_content,
                'background_image' => $category->banner_image,
                'background_video' => $category->banner_video,
            ];
        }

        if (!$heroSection) {
            $heroSection = HomeSection::where('section', 'articles')->first();
        }
            
        $categoryTitle = strtoupper($category->name);
        
        return view('articles.index', compact('articles', 'category', 'categoryTitle', 'heroSection'));
    }

    public function articleDetail($categorySlug, $slug)
    {
        $category = ArticleCategory::where('slug', $categorySlug)->firstOrFail();

        $article = Article::with('images')
            ->published()
            ->where('article_category_id', $category->id)
            ->where('slug', $slug)
            ->firstOrFail();
            
        $relatedArticles = Article::with('images')
            ->published()
            ->where('article_category_id', $category->id)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        return view('articles.detail', compact('article', 'relatedArticles'));
    }

    public function companyPage($page)
    {
        // Validasi page
        if (!in_array($page, ['our-group', 'sustainability', 'legal', 'certification'])) {
            abort(404);
        }

        $companyInfo = CompanyInfo::where('page', $page)->first();
        
        // Jika data tidak ditemukan, redirect atau tampilkan 404
        if (!$companyInfo) {
            abort(404);
        }

        $heroSection = HomeSection::where('section', $page)->first();
        
        $pageTitle = str_replace('-', ' ', ucfirst($page));
        
        return view('company.page', compact('companyInfo', 'pageTitle', 'heroSection'));
    }

    public function industry(Request $request)
    {
        $category = $request->get('category');
        
        $products = Product::with('images')
            ->byCategory($category)
            ->orderBy('order')
            ->paginate(24);
            
        $categories = Product::select('category')->distinct()->pluck('category');

        $heroSection = HomeSection::where('section', 'products')->first();
        
        return view('industry.index', compact('products', 'categories', 'category', 'heroSection'));
    }

    public function contact()
    {
        $heroSection = HomeSection::where('section', 'contact')->first();
        return view('contact.index', compact('heroSection'));
    }

    public function productDetail($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::with('images')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->orderBy('order')
            ->take(3)
            ->get();
        
        return view('products.detail', compact('product', 'relatedProducts'));
    }

    public function facilityDetail($slug)
    {
        $facility = Facility::with('images')->where('slug', $slug)->firstOrFail();
        $relatedFacilities = Facility::with('images')
            ->active()
            ->where('id', '!=', $facility->id)
            ->orderBy('order')
            ->take(3)
            ->get();
        
        return view('facilities.detail', compact('facility', 'relatedFacilities'));
    }
}