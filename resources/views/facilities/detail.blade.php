@extends('layouts.app')

@section('title', $facility->name . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Facility Hero Banner -->
    @php
        $facilityImage = null;
        if ($facility->images->count() > 0) {
            $facilityImage = $facility->images->first()->image;
        } elseif ($facility->image) {
            $facilityImage = $facility->image;
        }
    @endphp
    
    @if($facilityImage)
        <x-hero-banner
            :title="$facility->name"
            :subtitle="(strtoupper($facility->type ?? __('FACILITY'))) . ' • ' . $facility->created_at->format('d F Y')"
            :backgroundImage="$facilityImage"
            height="small"
            overlay="gradient"
            alignment="left"
            animation="slide-up"
        />
    @endif

    <!-- Facility Detail Section -->
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

            <article class="animate-fade-in bg-white rounded-2xl shadow-soft p-8 border border-green-50">
                <!-- Facility Header -->
                <header class="mb-8">
                    <!-- Category and Date -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        @if($facility->type)
                        <span class="inline-block {{ $facility->type == 'Kegiatan' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }} px-4 py-2 rounded-full text-sm font-semibold w-fit shadow-sm">
                            {{ strtoupper($facility->type) }}
                        </span>
                        @endif
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Published:') }} {{ $facility->created_at->format('d F Y') }}
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight text-center">
                        {{ $facility->name }}
                    </h1>
                </header>

                <!-- Facility Thumbnail or Slideshow -->
                @if($facility->images->count() > 0)
                    <!-- Multiple Images Slideshow -->
                    <div class="mb-8">
                        @include('components.slideshow', [
                            'images' => $facility->images,
                            'slideshowId' => 'facility-slideshow-' . $facility->id,
                            'containerClass' => 'rounded-xl overflow-hidden shadow-lg',
                            'showIndicators' => false,
                            'showCounter' => false,
                            'autoPlay' => true,
                            'autoPlayInterval' => 5000
                        ])
                    </div>
                @elseif($facility->image)
                    <!-- Fallback to Thumbnail -->
                    <div class="mb-8 rounded-xl overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $facility->image) }}" 
                             alt="{{ $facility->name }}" 
                             class="w-full h-64 md:h-96 object-cover hover:scale-105 transition duration-500">
                    </div>
                @endif

                <!-- Facility Content -->
                <div class="prose max-w-none prose-green prose-lg mb-12 text-justify leading-relaxed">
                    {!! $facility->description ?? __('No description available.') !!}
                </div>

                <!-- Detailed Image Gallery (Vertical with Captions) -->
                @if($facility->images->count() > 0)
                    <div class="space-y-12 mb-12">
                        @foreach($facility->images as $index => $image)
                            <div class="flex flex-col gap-4">
                                <div class="rounded-xl overflow-hidden shadow-lg">
                                    <img src="{{ asset('storage/' . $image->image) }}" 
                                         alt="{{ $image->caption ?? 'Facility Image ' . ($index + 1) }}" 
                                         class="w-full h-auto object-cover">
                                </div>
                                @if($image->caption)
                                    <p class="text-center text-gray-600 italic font-medium">
                                        {{ $image->caption }}
                                    </p>
                                @endif
                                <!-- Optional: If we wanted to split text, it would be hard, but we can assume this flow works for now -->
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Share Buttons -->
                <div class="border-t border-gray-200 pt-8 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">{{ __('Share this facility') }}</h3>
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

            <!-- Related Facilities -->
            @if($relatedFacilities->count() > 0)
                <section class="mt-16 border-t border-gray-200 pt-12">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('Other Facilities') }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedFacilities as $relatedFacility)
                            <a href="{{ route('facilities.detail', $relatedFacility->slug) }}" 
                               class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <!-- Facility Image -->
                                <div class="h-48 overflow-hidden bg-gray-200 relative">
                                    @if($relatedFacility->images->count() > 0)
                                        <img src="{{ asset('storage/' . $relatedFacility->images->first()->image) }}" 
                                             alt="{{ $relatedFacility->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @elseif($relatedFacility->image)
                                        <img src="{{ asset('storage/' . $relatedFacility->image) }}" 
                                             alt="{{ $relatedFacility->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($relatedFacility->type)
                                    <div class="absolute top-2 left-2">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-md {{ $relatedFacility->type == 'Kegiatan' ? 'bg-blue-100/90 text-blue-700' : 'bg-green-100/90 text-green-700' }}">
                                            {{ $relatedFacility->type }}
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Facility Info -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition duration-300 mb-2">
                                        {{ $relatedFacility->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {!! Str::limit(strip_tags($relatedFacility->description), 100) !!}
                                    </p>
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
            const title = '{{ $facility->name }}';
            window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
        }

        function shareOnLinkedIn() {
            const url = window.location.href;
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
        }
    </script>
@endsection
