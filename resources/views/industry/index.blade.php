@extends('layouts.app')

@section('title', 'Our Products - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="$heroSection->title ?? __('Our Products')"
            :subtitle="!$heroSection->content ?  : ''"
            :content="$heroSection->content ?? ''"
            :backgroundImage="$heroSection->background_image"
            :backgroundVideo="$heroSection->background_video"
            height="medium"
            overlay="dark"
            alignment="center"
            animation="slide-up"
            :showScrollIndicator="true"
            scrollTarget="#products"
            ctaText="{{ __('Explore Products') }}"
            ctaUrl="#products"
        />
    @else
        <x-hero-banner
            title="{{ __('Our Products') }}"
            
            height="medium"
            alignment="center"
            animation="fade"
            ctaText="{{ __('Explore Products') }}"
            ctaUrl="#products"
        />
    @endif

    <!-- Products Section -->
    <section id="products" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ __('Our Product Collection') }}</h2>
                    {{ __('Explore our comprehensive range of high-quality products designed to meet your needs') }}
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="flex flex-wrap justify-center gap-8">
                    @foreach($products as $product)
                        <a href="{{ route('products.detail', $product->slug) }}" 
                           class="w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.333rem)] group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            <!-- Product Image -->
                            <div class="h-64 overflow-hidden relative">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @elseif($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Featured Badge -->
                                @if($product->is_featured)
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                            {{ __('Featured') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-6">
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold mb-3">
                                    {{ ucfirst($product->category) }}
                                </span>
                                
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-green-600 transition duration-300">
                                    {{ $product->name }}
                                </h3>
                                
                                
                                
                                <div class="flex items-center justify-between text-sm font-semibold text-green-600 group-hover:text-green-700 transition duration-300">
                                    <span>{{ __('View Full Details') }}</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>

                <!-- Menampilkan jumlah produk -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 text-lg">
                        {{ __('Showing :total products', ['total' => $products->total()]) }}
                    </p>
                </div>

            @else
                <div class="text-center py-16">
                    <div class="bg-green-50 rounded-2xl p-12 max-w-md mx-auto border border-green-100">
                        <svg class="w-20 h-20 text-green-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1m4 0h-4"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('No Products Available') }}</h3>
                        <p class="text-gray-600 mb-6">{{ __("We're currently updating our product catalog. Please check back soon!") }}</p>
                        <a href="{{ url('/') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 inline-block">
                            {{ __('Return Home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Product Detail Modal -->
    <div id="product-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6">
                <!-- Close Button -->
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                    <h3 id="modal-title" class="text-2xl md:text-3xl font-bold text-gray-800"></h3>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Product Content -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>
                        <div id="modal-image" class="rounded-xl overflow-hidden bg-gray-100 shadow-lg">
                            <!-- Image will be loaded here -->
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span id="modal-category" class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold"></span>
                                <span id="modal-featured" class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold ml-2 hidden">
                                    ⭐ {{ __('Featured') }}
                                </span>
                            </div>
                            <div id="modal-price" class="text-2xl font-bold text-green-600"></div>
                        </div>

                        <div id="modal-description" class="prose max-w-none text-gray-700 leading-relaxed">
                            <!-- Description will be loaded here -->
                        </div>

                        <!-- Additional Info -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-4 text-lg">{{ __('Product Information') }}</h4>
                            <div id="modal-additional-info" class="space-y-3 text-sm text-gray-600">
                                <!-- Additional info will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    
    .prose {
        max-width: none;
        line-height: 1.7;
    }
    
    .prose p {
        margin-bottom: 1em;
        text-align: justify;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1em;
        padding-left: 1.5em;
    }
    
    .prose li {
        margin-bottom: 0.5em;
    }

    .animate-fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('product-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalCategory = document.getElementById('modal-category');
        const modalImage = document.getElementById('modal-image');
        const modalFeatured = document.getElementById('modal-featured');
        const modalDescription = document.getElementById('modal-description');
        const modalAdditionalInfo = document.getElementById('modal-additional-info');
        const modalPrice = document.getElementById('modal-price');
        const closeModal = document.getElementById('close-modal');
        
        // Product detail buttons
        document.querySelectorAll('.product-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const product = JSON.parse(this.getAttribute('data-product'));
                
                // Set modal content
                modalTitle.textContent = product.name;
                modalCategory.textContent = product.category;
                
                // Price
                if (product.price) {
                    modalPrice.textContent = `$${parseFloat(product.price).toFixed(2)}`;
                    modalPrice.classList.remove('hidden');
                } else {
                    modalPrice.classList.add('hidden');
                }
                
                // Featured badge
                if (product.is_featured) {
                    modalFeatured.classList.remove('hidden');
                } else {
                    modalFeatured.classList.add('hidden');
                }
                
                // Product image - full size
                if (product.image) {
                    modalImage.innerHTML = `
                        <img src="{{ asset('storage/') }}/${product.image}" 
                             alt="${product.name}" 
                             class="w-full h-80 object-cover">
                    `;
                } else {
                    modalImage.innerHTML = `
                        <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-xl">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">No Image Available</p>
                            </div>
                        </div>
                    `;
                }
                
                // Product description - full text with proper formatting
                if (product.description) {
                    modalDescription.innerHTML = product.description;
                } else {
                    modalDescription.innerHTML = '<p class="text-gray-500 text-center py-8">No description available for this product.</p>';
                }
                
                // Additional product information
                let additionalInfo = '';
                
                if (product.specifications) {
                    additionalInfo += `<div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-medium">Specifications:</span>
                        <span class="text-right">${product.specifications}</span>
                    </div>`;
                }
                
                if (product.in_stock !== undefined) {
                    const stockStatus = product.in_stock ? 
                        '<span class="text-green-600 font-semibold">In Stock</span>' : 
                        '<span class="text-red-600 font-semibold">Out of Stock</span>';
                    additionalInfo += `<div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-medium">Availability:</span>
                        <span>${stockStatus}</span>
                    </div>`;
                }
                
                if (product.category) {
                    additionalInfo += `<div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-medium">Category:</span>
                        <span>${product.category}</span>
                    </div>`;
                }
                
                if (product.created_at) {
                    const date = new Date(product.created_at);
                    additionalInfo += `<div class="flex justify-between py-2">
                        <span class="font-medium">Added:</span>
                        <span>${date.toLocaleDateString()}</span>
                    </div>`;
                }
                
                modalAdditionalInfo.innerHTML = additionalInfo || '<p class="text-gray-500 text-center py-4">No additional information available.</p>';
                
                // Show modal
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close modal
        function closeModalFunc() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
        
        closeModal.addEventListener('click', closeModalFunc);
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModalFunc();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModalFunc();
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush