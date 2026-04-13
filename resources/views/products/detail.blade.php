@extends('layouts.app')

@section('title', $product->name . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Product Hero Banner -->
    @php
        $productImage = null;
        if ($product->images->count() > 0) {
            $productImage = $product->images->first()->image;
        } elseif ($product->image) {
            $productImage = $product->image;
        }
    @endphp
    
    @if($productImage)
        <x-hero-banner
            :title="$product->name"
            :subtitle="ucfirst($product->category)"
            :backgroundImage="$productImage"
            height="small"
            overlay="gradient"
            alignment="left"
            animation="slide-up"
        />
    @endif

    <!-- Product Detail Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-5xl">
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

            <article class="animate-fade-in bg-white rounded-2xl shadow-soft p-8 border border-green-50">
                <!-- Product Header -->
                <header class="mb-8">
                    <!-- Category Badge -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold w-fit shadow-sm">
                            {{ ucfirst($product->category) }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                        {{ $product->name }}
                    </h1>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <!-- Product Images Slideshow -->
                    @if($product->images->count() > 0)
                        <div>
                            @include('components.slideshow', [
                                'images' => $product->images,
                                'slideshowId' => 'product-slideshow-' . $product->id,
                                'containerClass' => 'rounded-xl overflow-hidden shadow-lg',
                                'showIndicators' => true,
                                'showCounter' => true,
                                'autoPlay' => true,
                                'autoPlayInterval' => 5000
                            ])
                        </div>
                    @elseif($product->image)
                        <div class="rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover">
                        </div>
                    @else
                        <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 h-96 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Product Information -->
                    <div class="flex flex-col justify-between">
                        <!-- Description -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Product Details') }}</h2>
                            <div class="prose max-w-none prose-green text-gray-700 leading-relaxed">
                                {!! $product->description ?: '&nbsp;' !!}
                            </div>
                        </div>

                        <!-- Featured Badge -->
                        @if($product->is_featured)
                            <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-yellow-700 font-semibold">{{ __('Featured Product') }}</span>
                            </div>
                        @endif

                        <!-- Call to Action -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">{{ __('Interested in this product?') }}</h3>
                            <p class="text-gray-600 mb-4">{{ __('Contact us to learn more about specifications, pricing, and availability.') }}</p>
                            <a href="{{ route('contact') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                                {{ __('Get in Touch') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Share Buttons -->
                <div class="border-t border-gray-200 pt-8 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">{{ __('Share this product') }}</h3>
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
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417a9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
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

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <section class="mt-16 border-t border-gray-200 pt-12">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('Related Products') }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <a href="{{ route('products.detail', $relatedProduct->slug) }}" 
                               class="group bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <!-- Product Image -->
                                <div class="h-48 rounded-lg overflow-hidden mb-4 bg-gray-200">
                                    @if($relatedProduct->images->count() > 0)
                                        <img src="{{ asset('storage/' . $relatedProduct->images->first()->image) }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @elseif($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div>
                                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">
                                        {{ ucfirst($relatedProduct->category) }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition duration-300">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

    <!-- Share Scripts -->
    <script>
        function shareOnFacebook() {
            const url = window.location.href;
            const title = document.title;
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter() {
            const url = window.location.href;
            const title = '{{ $product->name }}';
            window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
        }

        function shareOnLinkedIn() {
            const url = window.location.href;
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
        }
    </script>
@endsection
