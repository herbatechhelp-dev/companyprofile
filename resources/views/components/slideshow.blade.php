@php
    // Calculate aspect ratio for consistent image dimensions
    $imageHeight = $imageHeight ?? '400px';
    $containerClass = $containerClass ?? 'rounded-xl overflow-hidden shadow-lg';
@endphp

<div id="{{ $slideshowId ?? 'slideshow-' . bin2hex(random_bytes(8)) }}" class="{{ $containerClass }}">
    <!-- Slides Container -->
    <div class="relative w-full overflow-hidden bg-gray-900">
        <!-- Slides -->
        @foreach($images as $index => $image)
            <div data-slide
                 class="absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'active' : '' }}"
                 style="opacity: {{ $index === 0 ? '1' : '0' }};">
                <img src="{{ asset('storage/' . $image->image) }}"
                     alt="{{ __('Slide') }} {{ $index + 1 }}"
                     class="w-full h-full object-cover">
            </div>
        @endforeach

        <!-- Navigation Buttons -->
        @if($images->count() > 1)
            <!-- Previous Button -->
            <button data-slide-prev
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="{{ __('Previous slide') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button data-slide-next
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="{{ __('Next slide') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Slide Counter (optional) -->
            @if($showCounter ?? true)
                <div class="absolute top-4 right-4 z-10 bg-black/60 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    <span id="slide-counter-current">1</span> / <span id="slide-counter-total">{{ $images->count() }}</span>
                </div>
            @endif
        @endif

        <!-- Image Height -->
        <div style="padding-bottom: 66.67%; background-color: #1f2937;"></div>
    </div>

    <!-- Indicators/Dots -->
    @if($images->count() > 1 && ($showIndicators ?? true))
        <div class="flex justify-center gap-2 bg-gray-900 py-4 px-4">
            @foreach($images as $index => $image)
                <button data-slide-dot
                        class="w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'active bg-green-500 w-8' : 'bg-gray-500 hover:bg-gray-400' }}"
                        aria-label="{{ __('Go to slide') }} {{ $index + 1 }}"
                        data-index="{{ $index }}">
                </button>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slideshowId = @json($slideshowId ?? 'slideshow-' . bin2hex(random_bytes(8)));
        
        if (typeof Slideshow !== 'undefined') {
            new Slideshow(slideshowId, {
                autoPlay: @json($autoPlay ?? true),
                autoPlayInterval: @json($autoPlayInterval ?? 5000),
                transitionDuration: 500
            });
        }
    });
</script>

<style>
    [data-slide] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    [data-slide].active {
        opacity: 1;
    }

    [data-slide-dot] {
        position: relative;
    }

    [data-slide-dot].active {
        background-color: rgb(34, 197, 94) !important;
        width: 2rem !important;
    }
</style>
