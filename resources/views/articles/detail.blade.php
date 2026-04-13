@extends('layouts.app')

@section('title', $article->title . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Article Hero Banner -->
    @php
        $articleImage = null;
        if ($article->images->count() > 0) {
            $articleImage = $article->images->first()->image;
        } elseif ($article->thumbnail) {
            $articleImage = $article->thumbnail;
        }
    @endphp
    
    @if($articleImage)
        <x-hero-banner
            :title="$article->title"
            :subtitle="(strtoupper($article->articleCategory->name ?? '')) . ' • ' . $article->created_at->format('F d, Y')"
            :backgroundImage="$articleImage"
            height="small"
            overlay="gradient"
            alignment="left"
            animation="slide-up"
        />
    @endif

    <!-- Article Detail Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Elegant Back Button -->
            <div class="mb-8">
                <a href="javascript:history.back()" 
                   class="group inline-flex items-center text-green-600 hover:text-green-700 font-medium transition-all duration-500 transform hover:-translate-x-1">

                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-green-200 transition-all duration-500">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-0.5 transition-transform duration-500" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold">{{ __('Back') }}</span>

                </a>
            </div>

            <article class="animate-fade-in bg-white rounded-2xl shadow-soft p-5 md:p-8 border border-green-50">
                <!-- Article Header -->
                <header class="mb-8">
                    <!-- Category and Date -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold w-fit shadow-sm">
                            {{ strtoupper($article->articleCategory->name ?? '') }}
                        </span>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Published:') }} {{ $article->published_at->format('F d, Y') }}
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight text-center md:text-left">
                        {{ $article->title }}
                    </h1>
                </header>

                <!-- Article Thumbnail or Slideshow -->
                @if($article->images->count() > 0)
                    <!-- Multiple Images Slideshow -->
                    <div class="mb-8">
                        @include('components.slideshow', [
                            'images' => $article->images,
                            'slideshowId' => 'article-slideshow-' . $article->id,
                            'containerClass' => 'rounded-xl overflow-hidden shadow-lg',
                            'showIndicators' => true,
                            'showCounter' => true,
                            'autoPlay' => true,
                            'autoPlayInterval' => 5000
                        ])
                    </div>
                @elseif($article->thumbnail)
                    <!-- Fallback to Thumbnail -->
                    <div class="mb-8 rounded-xl overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-64 md:h-96 object-cover hover:scale-105 transition duration-500">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="prose max-w-none prose-green prose-lg mb-12 text-justify leading-relaxed">
                    {!! $article->content !!}
                </div>

                <!-- Share Buttons -->
                <div class="border-t border-gray-200 pt-8 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">{{ __('Share this article') }}</h3>
                    <div class="flex flex-wrap justify-center gap-4">
                        <button onclick="shareOnFacebook()" 
                                class="group flex items-center space-x-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="font-medium">{{ __('Share on Facebook') }}</span>
                        </button>
                        
                        <button onclick="shareOnTwitter()" 
                                class="group flex items-center space-x-3 bg-blue-400 hover:bg-blue-500 text-white px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            <span class="font-medium">{{ __('Share on Twitter') }}</span>
                        </button>

                        <button onclick="shareOnLinkedIn()" 
                                class="group flex items-center space-x-3 bg-blue-800 hover:bg-blue-900 text-white px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <span class="font-medium">{{ __('Share on LinkedIn') }}</span>
                        </button>
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                <section class="mt-16 border-t border-gray-200 pt-12">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('Related Articles') }}</h2>
                        
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $relatedArticle)
                            <article class="group bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                                    {{ strtoupper($relatedArticle->articleCategory->name ?? '') }}
                                </span>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 line-clamp-2 leading-tight text-justify group-hover:text-green-700 transition-colors duration-300">
                                    {{ $relatedArticle->title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed text-justify">
                                    {{ Str::limit(strip_tags($relatedArticle->content), 100) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 text-xs">
                                        {{ $relatedArticle->published_at->format('M d, Y') }}
                                    </span>
                                    <a href="{{ route('articles.detail', ['category' => $relatedArticle->articleCategory->slug ?? 'unknown', 'slug' => $relatedArticle->slug]) }}" 
                                       class="text-green-600 hover:text-green-700 font-semibold text-sm inline-flex items-center transition duration-300 group">
                                        {{ __('Read More') }}
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition duration-300" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Bottom Back Button -->
            <div class="flex justify-center mt-12">
                <a href="javascript:history.back()" 
                   class="group bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center">

                    <svg class="w-5 h-5 mr-3 transform group-hover:-translate-x-1 transition duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back') }}

                </a>
            </div>
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
    
    .animate-fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .shadow-soft {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }
    
    /* Enhanced prose styles for justified text */
    .prose {
        line-height: 1.8;
    }
    
    .prose p {
        margin-bottom: 1.5em;
    }
    @media (min-width: 768px) {
        .prose p {
            text-align: justify;
        }
    }
    
    .prose img {
        border-radius: 12px;
        margin: 2em auto;
        display: block;
        max-width: 100%;
        height: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .prose h2 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
        text-align: left;
        position: relative;
        padding-left: 1.5rem;
    }
    
    .prose h2::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5em;
        width: 4px;
        height: 1.2em;
        background: linear-gradient(to bottom, #10b981, #059669);
        border-radius: 2px;
    }
    
    .prose h3 {
        color: #374151;
        font-weight: 600;
        margin-top: 1.5em;
        margin-bottom: 0.8em;
        text-align: left;
    }
    
    .prose h4 {
        color: #4b5563;
        font-weight: 600;
        margin-top: 1.2em;
        margin-bottom: 0.6em;
        text-align: left;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.5em;
        text-align: left;
    }
    
    .prose li {
        margin-bottom: 0.5em;
        text-align: left;
        position: relative;
        padding-left: 1.5rem;
    }
    
    .prose li::before {
        content: '•';
        color: #10b981;
        font-weight: bold;
        position: absolute;
        left: 0;
    }
    
    .prose blockquote {
        border-left: 4px solid #10b981;
        padding-left: 1.5em;
        margin: 2em 0;
        font-style: italic;
        color: #6b7280;
        text-align: left;
        background: #f9fafb;
        padding: 1.5em;
        border-radius: 8px;
    }
    
    .prose table {
        width: 100%;
        margin: 2em 0;
        border-collapse: collapse;
        text-align: left;
        border-radius: 8px;
        overflow-x: auto;
        display: block;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .prose th, .prose td {
        padding: 0.75em;
        border: 1px solid #e5e7eb;
        text-align: left;
    }
    
    .prose th {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-weight: 600;
    }
    
    .prose tr:nth-child(even) {
        background-color: #f9fafb;
    }
    
    /* Ensure headings and specific elements remain left-aligned */
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        text-align: left;
    }
    
    .prose ul, .prose ol {
        text-align: left;
    }
    
    .prose table {
        text-align: left;
    }
</style>
@endpush

@push('scripts')
<script>
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }

    function shareOnTwitter() {
        const text = encodeURIComponent("{{ $article->title }}");
        const url = encodeURIComponent(window.location.href);
        window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
    }

    function shareOnLinkedIn() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent("{{ $article->title }}");
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
    }

    // Add smooth scrolling behavior
    document.addEventListener('DOMContentLoaded', function() {
        // Add text-justify class to all paragraphs in article content
        const articleContent = document.querySelector('.prose');
        if (articleContent) {
            const paragraphs = articleContent.querySelectorAll('p');
            paragraphs.forEach(p => {
                p.classList.add('text-justify');
            });
        }



        // Add animation to related articles on scroll
        const relatedArticles = document.querySelectorAll('.grid > article');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        relatedArticles.forEach(article => {
            article.style.opacity = '0';
            article.style.transform = 'translateY(20px)';
            article.style.transition = 'all 0.6s ease-out';
            observer.observe(article);
        });
    });
</script>
@endpush