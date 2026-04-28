@props([
    'title' => 'Welcome',
    'subtitle' => '',
    'content' => '',
    'backgroundImage' => null,
    'backgroundVideo' => null,
    'height' => 'medium', // small, medium, large, full
    'overlay' => 'dark', // dark, light, gradient, none
    'alignment' => 'center', // center, left, right
    'showScrollIndicator' => false,
    'scrollTarget' => '#content',
    'ctaText' => null,
    'ctaUrl' => null,
    'animation' => 'fade', // fade, slide-up, slide-down, zoom, none
])

@php
    // Height classes
    $heightClasses = [
        'small' => 'pt-32 pb-12 md:pt-40 md:pb-16',
        'medium' => 'pt-36 pb-20 md:pt-44 md:pb-24',
        'large' => 'pt-44 pb-32 md:pt-56 md:pb-40',
        'full' => 'min-h-screen flex items-center justify-center pt-24 md:pt-32'
    ];
    
    // Overlay classes
    $overlayClasses = [
        'dark' => 'bg-black bg-opacity-50',
        'light' => 'bg-white bg-opacity-30',
        'gradient' => 'bg-gradient-to-b from-black/70 via-black/50 to-transparent',
        'none' => ''
    ];
    
    // Alignment classes
    $alignmentClasses = [
        'center' => 'text-center items-center',
        'left' => 'text-left items-start',
        'right' => 'text-right items-end'
    ];
    
    // Animation classes
    $animationClasses = [
        'fade' => 'hero-fade-in',
        'slide-up' => 'hero-slide-up',
        'slide-down' => 'hero-slide-down',
        'zoom' => 'hero-zoom-in',
        'none' => ''
    ];
@endphp

<section class="relative overflow-hidden hero-banner -mt-24 {{ $heightClasses[$height] }}" data-animation="{{ $animation }}">
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0">
        @if($backgroundVideo)
            <!-- Video Background -->
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover hero-bg-video">
                <source src="{{ asset('storage/' . $backgroundVideo) }}" type="video/mp4">
            </video>
        @elseif($backgroundImage)
            <!-- Image Background -->
            <!-- Image Background -->
            @php
                $bgSrc = $backgroundImage;
                if (!Str::startsWith($bgSrc, ['http', 'https'])) {
                    if (Str::startsWith($bgSrc, ['/storage', 'storage'])) {
                         $bgSrc = asset($bgSrc);
                    } else {
                         $bgSrc = asset('storage/' . $bgSrc);
                    }
                }
            @endphp
            <img src="{{ $bgSrc }}"
                 alt="{{ $title }}"
                 class="w-full h-full object-cover hero-bg-image">
        @else
            <!-- Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
        @endif
        
        <!-- Overlay -->
        @if($overlayClasses[$overlay])
            <div class="absolute inset-0 {{ $overlayClasses[$overlay] }}"></div>
        @endif
    </div>
    
    <!-- Content Layer -->
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col {{ $alignmentClasses[$alignment] }} {{ $height === 'full' ? 'min-h-screen justify-center' : '' }}">
            <div class="max-w-4xl {{ $alignment === 'center' ? 'mx-auto' : '' }}">
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white {{ $animationClasses[$animation] }}" 
                    style="animation-delay: 0.1s">
                    {{ $title }}
                </h1>
                
                <!-- Subtitle -->
                @if($subtitle)
                    <p class="text-xl md:text-2xl text-gray-100 mb-6 {{ $animationClasses[$animation] }}" 
                       style="animation-delay: 0.2s">
                        {{ $subtitle }}
                    </p>
                @endif
                
                <!-- Content -->
                @if($content)
                    <div class="text-lg md:text-xl text-gray-200 mb-8 prose prose-invert prose-lg max-w-none {{ $animationClasses[$animation] }}" 
                         style="animation-delay: 0.3s">
                        {!! $content !!}
                    </div>
                @endif
                
                <!-- CTA Button -->
                @if($ctaText && $ctaUrl)
                    <div class="{{ $animationClasses[$animation] }}" style="animation-delay: 0.4s">
                        <a href="{{ $ctaUrl }}" 
                           class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105 hover:shadow-lg">
                            {{ $ctaText }}
                        </a>
                    </div>
                @endif
                
                <!-- Slot for custom content -->
                @if($slot->isNotEmpty())
                    <div class="{{ $animationClasses[$animation] }}" style="animation-delay: 0.5s">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    @if($showScrollIndicator)
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 hero-scroll-indicator">
            <a href="{{ $scrollTarget }}" 
               class="text-white hover:text-green-300 transition duration-300 flex flex-col items-center scroll-smooth-link">
                <span class="text-sm mb-2 opacity-75">{{ __('Scroll') }}</span>
                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    @endif
</section>

<style>
    /* Hero Banner Animations - Lightweight & Performant */
    @keyframes heroFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes heroSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes heroSlideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes heroZoomIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Animation Classes */
    .hero-fade-in {
        animation: heroFadeIn 0.8s ease-out forwards;
        opacity: 0;
    }
    
    .hero-slide-up {
        animation: heroSlideUp 0.8s ease-out forwards;
        opacity: 0;
    }
    
    .hero-slide-down {
        animation: heroSlideDown 0.8s ease-out forwards;
        opacity: 0;
    }
    
    .hero-zoom-in {
        animation: heroZoomIn 0.8s ease-out forwards;
        opacity: 0;
    }
    
    /* Background Image/Video Effects */
    .hero-bg-image,
    .hero-bg-video {
        transition: transform 8s ease-out;
    }
    
    .hero-banner:hover .hero-bg-image {
        transform: scale(1.05);
    }
    
    /* Scroll Indicator Animation */
    .hero-scroll-indicator {
        animation: heroFadeIn 1s ease-out 1s forwards;
        opacity: 0;
    }
    
    /* Smooth scroll behavior */
    .scroll-smooth-link {
        scroll-behavior: smooth;
    }
    
    /* Performance Optimization */
    .hero-banner {
        will-change: opacity;
    }
    
    .hero-banner * {
        will-change: transform, opacity;
    }
    
    /* Reduce motion for accessibility */
    @media (prefers-reduced-motion: reduce) {
        .hero-fade-in,
        .hero-slide-up,
        .hero-slide-down,
        .hero-zoom-in,
        .hero-scroll-indicator {
            animation: none;
            opacity: 1;
            transform: none;
        }
        
        .hero-banner:hover .hero-bg-image {
            transform: none;
        }
        
        .animate-bounce {
            animation: none;
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-banner h1 {
            font-size: 2rem;
        }
        
        .hero-banner p {
            font-size: 1rem;
        }
    }
</style>

<script>
    // Smooth scroll for scroll indicator
    document.addEventListener('DOMContentLoaded', function() {
        const scrollLinks = document.querySelectorAll('.scroll-smooth-link');
        scrollLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Parallax effect for background (optional, lightweight)
        const heroBanners = document.querySelectorAll('.hero-banner');
        if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
            heroBanners.forEach(banner => {
                const bgImage = banner.querySelector('.hero-bg-image, .hero-bg-video');
                if (bgImage) {
                    window.addEventListener('scroll', function() {
                        const scrolled = window.pageYOffset;
                        const rate = scrolled * 0.3;
                        if (scrolled < banner.offsetHeight) {
                            bgImage.style.transform = `translate3d(0, ${rate}px, 0)`;
                        }
                    }, { passive: true });
                }
            });
        }
    });
</script>
