@extends('layouts.app')

@section('title', $categoryTitle . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Banner Section -->
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="($heroSection->title ?? $categoryTitle . ' ')"
            
            :content="$heroSection->content ?? ''"
            :backgroundImage="$heroSection->background_image"
            :backgroundVideo="$heroSection->background_video"
            height="small"
            overlay="dark"
            alignment="center"
            animation="fade"
        />
    @else
        <x-hero-banner
            :title="$categoryTitle . ' '"
            
            height="small"
            alignment="center"
            animation="fade"
        />
    @endif

    <!-- Articles Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <article class="bg-white rounded-custom shadow-custom overflow-hidden hover:shadow-xl transition duration-300 animate-fade-in">
                            @if($article->images->count() > 0)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $article->images->first()->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                </div>
                            @elseif($article->thumbnail)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                </div>
                            @else
                                <div class="h-48 bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 text-lg">{{ __('Article Image') }}</span>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-block bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ strtoupper($article->articleCategory->name ?? '') }}
                                    </span>
                                    <span class="text-gray-500 text-sm">
                                        {{ $article->published_at->format('M d, Y') }}
                                    </span>
                                </div>
                                
                                <h2 class="text-xl font-semibold text-gray-800 mb-3 line-clamp-2">
                                    {{ $article->title }}
                                </h2>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($article->content), 120) }}
                                </p>
                                
                                <a href="{{ route('articles.detail', ['category' => $article->articleCategory->slug ?? 'unknown', 'slug' => $article->slug]) }}" 
                                   class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center">
                                    {{ __('Read More') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-green-50 rounded-custom p-8 max-w-md mx-auto">
                        <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('No Articles Found') }}</h3>
                        <p class="text-gray-600">{{ __('There are no :category articles available at the moment.', ['category' => $categoryTitle]) }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush