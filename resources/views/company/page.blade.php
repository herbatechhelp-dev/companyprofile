@extends('layouts.app')

@section('title', $pageTitle . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Banner Section -->
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="$heroSection->title ?? $companyInfo->title"
            :subtitle="!$heroSection->content ? '' : ''"
            :content="$heroSection->content ?? ''"
            :backgroundImage="$heroSection->background_image"
            :backgroundVideo="$heroSection->background_video"
            height="medium"
            overlay="dark"
            alignment="center"
            animation="slide-up"
            :showScrollIndicator="true"
            scrollTarget="#content-start"
        />
    @elseif($companyInfo->banner_image)
        <x-hero-banner
            :title="$companyInfo->title"
            :backgroundImage="$companyInfo->banner_image"
            height="medium"
            overlay="gradient"
            alignment="center"
            animation="slide-up"
            :showScrollIndicator="true"
            scrollTarget="#content-start"
        />
    @else
        <x-hero-banner
            :title="$companyInfo->title"
            height="medium"
            alignment="center"
            animation="fade"
            :showScrollIndicator="true"
            scrollTarget="#content-start"
        />
    @endif

    <!-- Main Content Section -->
    <section id="content-start" class="py-20 bg-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%2310b981\" fill-opacity=\"0.2\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto px-4 max-w-4xl relative z-10">
            <!-- Elegant Back Button - Moved below banner -->
            <div class="mb-12">
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

            <!-- Breadcrumb with Style -->
            <nav class="flex items-center justify-center space-x-3 text-sm text-gray-500 mb-16">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors duration-300 font-medium">{{ __('Home') }}</a>
                <div class="w-1 h-1 bg-green-300 rounded-full"></div>
                <span class="text-green-600 font-semibold">{{ $pageTitle }}</span>
            </nav>

            <!-- Main Content Card -->
            <div class="animate-fade-in">
                <div class="bg-white rounded-2xl shadow-soft p-8 md:p-12 mb-16 border border-green-50">
                    <div class="prose prose-lg max-w-none prose-green text-justify leading-relaxed">
                        {!! $companyInfo->description !!}
                    </div>
                </div>

                <!-- Enhanced Icons / Visualization Section -->
                @php
                    $icons = $companyInfo->icons ?? [];
                    $pageType = $companyInfo->page;
                @endphp
    
                @if(is_array($icons) && count($icons) > 0)
                    @if($pageType === 'org-structure')
                        <!-- DESIGN: Organizational Structure (Team Cards) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-20 px-4">
                            @foreach($icons as $icon)
                                <div class="group flex flex-col items-center" data-aos="fade-up">
                                    <div class="relative mb-6">
                                        <!-- Ring Decoration -->
                                        <div class="absolute -inset-2 bg-gradient-to-tr from-green-500 to-emerald-400 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                        <!-- Photo Container -->
                                        <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-xl group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-105">
                                            @if(!empty($icon['image']))
                                                <img src="{{ asset('storage/' . $icon['image']) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-green-200" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-green-600 transition-colors duration-300">
                                            {{ $icon['title'] }}
                                        </h3>
                                        <p class="text-green-600 font-semibold text-sm uppercase tracking-wider mb-2">
                                            {{ $icon['description'] }}
                                        </p>
                                        <div class="w-8 h-1 bg-green-200 mx-auto rounded-full group-hover:w-16 transition-all duration-500"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif($pageType === 'value-chain')
                        <!-- DESIGN: Value Chain (Upstream to Downstream Flow) -->
                        <div class="space-y-12 mb-20 px-4">
                            @foreach($icons as $index => $icon)
                                <div class="relative flex flex-col md:flex-row items-center gap-8 group" data-aos="fade-left">
                                    <!-- Connector Line (Desktop) -->
                                    @if(!$loop->last)
                                        <div class="hidden md:block absolute left-10 top-20 bottom-0 w-1 bg-gradient-to-b from-green-500 to-transparent z-0 opacity-20"></div>
                                    @endif
                                    
                                    <!-- Step Number/Icon -->
                                    <div class="relative z-10 flex-shrink-0 w-20 h-20 bg-green-600 rounded-2xl shadow-lg flex items-center justify-center text-white text-3xl font-bold transform group-hover:rotate-6 transition-transform duration-500">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    <!-- Content Card -->
                                    <div class="flex-1 bg-white rounded-3xl p-8 shadow-soft border border-green-50 hover:border-green-200 transition-all duration-500 group-hover:shadow-soft-xl">
                                        <div class="flex flex-col lg:flex-row gap-6 items-center lg:items-start">
                                            @if(!empty($icon['image']))
                                                <div class="w-full lg:w-48 h-32 rounded-xl overflow-hidden flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $icon['image']) }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-green-600 transition-colors duration-300">
                                                    {{ $icon['title'] }}
                                                </h3>
                                                <p class="text-gray-600 leading-relaxed text-lg">
                                                    {{ $icon['description'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- DESIGN: Default Icons (Standard Grid) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                            @foreach($icons as $index => $icon)
                                @if(is_array($icon) && isset($icon['title']) && isset($icon['description']))
                                    <div class="group text-center p-8 bg-gradient-to-br from-white to-green-50 rounded-2xl border border-green-100 hover:shadow-soft-xl transition-all duration-500 transform hover:-translate-y-3">
                                        <!-- Animated Icon Container -->
                                        <div class="relative mb-6">
                                            <div class="absolute inset-0 bg-green-100 rounded-full transform scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                                            <div class="relative w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition-all duration-500">
                                                @if(!empty($icon['image']))
                                                    <img src="{{ asset('storage/' . $icon['image']) }}" class="w-12 h-12 object-contain filter brightness-0 invert">
                                                @else
                                                    <svg class="w-8 h-8 text-white transform group-hover:scale-110 transition-transform duration-500" 
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <h3 class="text-xl font-bold text-gray-800 mb-4 group-hover:text-green-700 transition-colors duration-300">
                                            {{ $icon['title'] }}
                                        </h3>
                                        <p class="text-gray-600 leading-relaxed text-justify group-hover:text-gray-700 transition-colors duration-300">
                                            {{ $icon['description'] }}
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endif

                <!-- Additional Content with Elegant Design -->
                @if($companyInfo->additional_content)
                    <div class="mb-20">
                        <div class="text-center mb-12">
                            <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-emerald-500 mx-auto mb-6 rounded-full"></div>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">{{ __('Further Insights') }}</h2>
                            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">{{ __('Discover more about our vision and values') }}</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-8 md:p-12 border border-green-200">
                            <div class="prose prose-lg max-w-none prose-green text-justify leading-relaxed">
                                {!! $companyInfo->additional_content !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Contact CTA Section -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-12 text-center text-white relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.2\"%3E%3Cpath d=\"M0 0h40v40H0V0zm20 20a8 8 0 110-16 8 8 0 010 16z\"/%3E%3C/g%3E%3C/svg%3E');"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">{{ __('Ready to Connect?') }}</h2>
                        <p class="text-green-100 text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
                            {{ __("Let's discuss how we can work together to achieve your goals") }}
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('contact') }}" 
                               class="group bg-white text-green-600 hover:bg-green-50 px-8 py-4 rounded-xl font-semibold transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center">
                                <span>{{ __('Get in Touch') }}</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-500" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <a href="tel:+1234567890" 
                               class="group border-2 border-white text-white hover:bg-white hover:text-green-600 px-8 py-4 rounded-xl font-semibold transition-all duration-500 transform hover:scale-105 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ __('Call Us') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Elegant Bottom Navigation -->
            <div class="flex justify-center mt-16">
                <a href="javascript:history.back()" 
                   class="group inline-flex items-center bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-500 transform hover:scale-105 shadow-lg hover:shadow-xl">

                    <svg class="w-5 h-5 mr-3 transform group-hover:-translate-x-1 transition-transform duration-500" 
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
    .animate-fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
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
    
    .shadow-soft-xl {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }
    
    /* Enhanced prose styles */
    .prose {
        line-height: 1.8;
        text-align: justify;
    }
    
    .prose p {
        margin-bottom: 1.5em;
        text-align: justify;
    }
    
    .prose img {
        border-radius: 16px;
        margin: 2.5em auto;
        display: block;
        max-width: 100%;
        height: auto;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }
    
    .prose h2 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 2.5em;
        margin-bottom: 1.2em;
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
        margin-top: 2em;
        margin-bottom: 1em;
        text-align: left;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.8em;
        text-align: left;
    }
    
    .prose li {
        margin-bottom: 0.6em;
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
        padding-left: 2em;
        margin: 2.5em 0;
        font-style: italic;
        color: #6b7280;
        text-align: left;
        background: #f9fafb;
        padding: 2em;
        border-radius: 12px;
        border-left: 4px solid #10b981;
    }
    
    .prose table {
        width: 100%;
        margin: 2.5em 0;
        border-collapse: collapse;
        text-align: left;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .prose th, .prose td {
        padding: 1em;
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add intersection observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Animate icon cards
        const iconCards = document.querySelectorAll('.grid > div');
        iconCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s ease-out ${index * 0.1}s`;
            observer.observe(card);
        });



        // Parallax effect for banner
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const banner = document.querySelector('section.relative.py-24');
            if (banner) {
                banner.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    });
</script>
@endpush