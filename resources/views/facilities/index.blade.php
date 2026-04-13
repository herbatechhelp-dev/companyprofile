@extends('layouts.app')

@section('title', 'Our Facilities - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="$heroSection->title ?? __('Our Facilities')"
            :subtitle="!$heroSection->content ? : ''"
            :content="$heroSection->content ?? ''"
            :backgroundImage="$heroSection->background_image"
            :backgroundVideo="$heroSection->background_video"
            height="medium"
            overlay="dark"
            alignment="center"
            animation="slide-up"
            :showScrollIndicator="true"
            scrollTarget="#facilities"
        />
    @else
        <x-hero-banner
            title="{{ __('Our Facilities') }}"
          
            height="medium"
            alignment="center"
            animation="fade"
        />
    @endif

    <!-- Facilities Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ __('Our Facilities') }}</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('We are equipped with modern facilities to support our operations and provide the best service') }}
                </p>
            </div>

            <!-- Facilities Grid -->
            @if($facilities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($facilities as $facility)
                        <a href="{{ route('facilities.detail', $facility->slug) }}" 
                           class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                            <!-- Facility Image -->
                            <div class="h-64 overflow-hidden relative">
                                @if($facility->images->count() > 0)
                                    <img src="{{ asset('storage/' . $facility->images->first()->image) }}" 
                                         alt="{{ $facility->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @elseif($facility->image)
                                    <img src="{{ asset('storage/' . $facility->image) }}" 
                                         alt="{{ $facility->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-18 0h2m8-8V7m0 4h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Facility Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-green-600 transition duration-300">{{ $facility->name }}</h3>
                                
                                @if($facility->location)
                                <div class="flex items-center text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $facility->location }}</span>
                                </div>
                                @endif

                                @if($facility->capacity)
                                <div class="flex items-center text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="text-sm">{{ __('Capacity: :count people', ['count' => $facility->capacity]) }}</span>
                                </div>
                                @endif
                                
                                <div class="text-gray-600 mb-4 line-clamp-3 leading-relaxed text-sm">
                                    {{ Str::limit(strip_tags($facility->description), 120) }}
                                </div>

                                @if($facility->features && count($facility->features) > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-2">{{ __('Features:') }}</h4>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($facility->features, 0, 3) as $feature)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                                {{ $feature['feature'] }}
                                            </span>
                                        @endforeach
                                        @if(count($facility->features) > 3)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                                                +{{ count($facility->features) - 3 }} {{ __('more') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex items-center justify-between text-sm font-semibold text-green-600 group-hover:text-green-700 transition duration-300">
                                    <span>{{ __('View Details') }}</span>
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
                    {{ $facilities->links() }}
                </div>

                <!-- Menampilkan jumlah fasilitas -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 text-lg">
                        {{ __('Showing :total facilities', ['total' => $facilities->total()]) }}
                    </p>
                </div>

            @else
                <div class="text-center py-16">
                    <div class="bg-green-50 rounded-2xl p-12 max-w-md mx-auto border border-green-100">
                        <svg class="w-20 h-20 text-green-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-18 0h2m8-8V7m0 4h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('No Facilities Available') }}</h3>
                        <p class="text-gray-600 mb-6">{{ __("We're currently updating our facilities information. Please check back soon!") }}</p>
                        <a href="{{ url('/') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 inline-block">
                            {{ __('Return Home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Facility Detail Modal -->
    <!-- Facility Detail Modal -->
    <div id="facility-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90dvh] overflow-hidden shadow-2xl flex flex-col">
            <!-- Modal Header -->
            <div class="p-4 md:p-6 flex justify-between items-center border-b border-gray-100 flex-shrink-0">
                <h3 id="modal-title" class="text-xl md:text-3xl font-bold text-gray-800 truncate"></h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="p-4 md:p-8 overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10">
                    <!-- Facility Image -->
                    <div class="flex-shrink-0">
                        <div id="modal-image" class="rounded-xl overflow-hidden bg-gray-100 shadow-md aspect-video lg:aspect-auto">
                            <!-- Image will be loaded here -->
                        </div>
                    </div>

                    <!-- Facility Details -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 lg:grid-cols-2 gap-4">
                            <div class="flex items-start text-gray-700">
                                <div class="p-2 bg-green-50 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Location') }}</p>
                                    <p id="modal-location" class="text-sm font-semibold text-gray-800 truncate"></p>
                                </div>
                            </div>

                            <div class="flex items-start text-gray-700">
                                <div class="p-2 bg-green-50 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Capacity') }}</p>
                                    <p id="modal-capacity" class="text-sm font-semibold text-gray-800"></p>
                                </div>
                            </div>
                        </div>

                        <div class="h-px bg-gray-100 w-full"></div>

                        <div id="modal-description" class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            <!-- Description will be loaded here -->
                        </div>

                        <!-- Features -->
                        <div id="modal-features" class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wider">{{ __('Facility Features') }}</h4>
                            <div id="modal-features-list" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <!-- Features will be loaded here -->
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
        const modal = document.getElementById('facility-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalImage = document.getElementById('modal-image');
        const modalLocation = document.getElementById('modal-location');
        const modalCapacity = document.getElementById('modal-capacity');
        const modalDescription = document.getElementById('modal-description');
        const modalFeaturesList = document.getElementById('modal-features-list');
        const modalFeatures = document.getElementById('modal-features');
        const closeModal = document.getElementById('close-modal');
        
        // Facility detail buttons
        document.querySelectorAll('.facility-detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const facility = JSON.parse(this.getAttribute('data-facility'));
                
                // Set modal content
                modalTitle.textContent = facility.name;
                
                // Location
                if (facility.location) {
                    modalLocation.textContent = facility.location;
                    modalLocation.parentElement.parentElement.classList.remove('hidden');
                } else {
                    modalLocation.parentElement.parentElement.classList.add('hidden');
                }
                
                // Capacity
                if (facility.capacity) {
                    modalCapacity.textContent = facility.capacity + ' people';
                    modalCapacity.parentElement.parentElement.classList.remove('hidden');
                } else {
                    modalCapacity.parentElement.parentElement.classList.add('hidden');
                }
                
                // Facility image
                if (facility.image) {
                    modalImage.innerHTML = `
                        <img src="{{ asset('storage/') }}/${facility.image}" 
                             alt="${facility.name}" 
                             class="w-full h-80 object-cover">
                    `;
                } else {
                    modalImage.innerHTML = `
                        <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-xl">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-18 0h2m8-8V7m0 4h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">No Image Available</p>
                            </div>
                        </div>
                    `;
                }
                
                // Facility description
                if (facility.description) {
                    modalDescription.innerHTML = facility.description;
                } else {
                    modalDescription.innerHTML = '<p class="text-gray-500 text-center py-8">No description available for this facility.</p>';
                }
                
                // Facility features
                if (facility.features && facility.features.length > 0) {
                    let featuresHtml = '';
                    facility.features.forEach(feature => {
                        featuresHtml += `
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">${feature.feature}</span>
                            </div>
                        `;
                    });
                    modalFeaturesList.innerHTML = featuresHtml;
                    modalFeatures.classList.remove('hidden');
                } else {
                    modalFeaturesList.innerHTML = '<p class="text-gray-500 text-center py-4">No features listed for this facility.</p>';
                    modalFeatures.classList.remove('hidden');
                }
                
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
    });
</script>
@endpush