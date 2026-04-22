@extends('layouts.app')

@section('title', __('About Us') . ' - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Banner Section (Using Background Hero) -->
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="$heroSection->title ?? ($background->title ?? __('About Us'))"
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
    @elseif($background && $background->banner_image)
        <x-hero-banner
            :title="$background->title"
            :backgroundImage="$background->banner_image"
            height="medium"
            overlay="gradient"
            alignment="center"
            animation="slide-up"
            :showScrollIndicator="true"
            scrollTarget="#content-start"
        />
    @else
        <x-hero-banner
            :title="__('About Us')"
            height="medium"
            alignment="center"
            animation="fade"
            :showScrollIndicator="true"
            scrollTarget="#content-start"
        />
    @endif

    <div id="content-start">
        
        <!-- 1. Latar Belakang Section -->
        @if($background)
        <section class="py-20 bg-white relative overflow-hidden">
            <div class="container mx-auto px-4 max-w-5xl">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $background->title }}</h2>
                    <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
                </div>
                <div class="bg-white rounded-3xl shadow-soft p-8 md:p-12 border border-green-50" data-aos="fade-up">
                    <div class="prose prose-lg max-w-none prose-green text-justify leading-relaxed">
                        {!! $background->description !!}
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- 2. Tentang Grup Section -->
        @if($ourGroup)
        <section class="py-20 bg-emerald-50/30 relative overflow-hidden">
            <div class="container mx-auto px-4 max-w-6xl">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $ourGroup->title }}</h2>
                    <div class="w-24 h-1 bg-green-600 mx-auto rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                    <div class="prose prose-lg max-w-none text-gray-600 text-justify" data-aos="fade-right">
                        {!! $ourGroup->description !!}
                    </div>
                    @if($ourGroup->banner_image)
                    <div class="relative" data-aos="fade-left">
                        <div class="absolute -inset-4 bg-green-200/50 rounded-3xl blur-2xl"></div>
                        <img src="{{ asset('storage/' . $ourGroup->banner_image) }}" class="relative w-full rounded-3xl shadow-2xl border-4 border-white">
                    </div>
                    @endif
                </div>

                @if(!empty($ourGroup->icons))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($ourGroup->icons as $icon)
                        <div class="bg-white p-8 rounded-2xl shadow-soft border border-green-100/50 hover:shadow-xl transition-all duration-300" data-aos="zoom-in">
                            <div class="w-16 h-16 bg-green-50 rounded-xl flex items-center justify-center mb-6">
                                @if(!empty($icon['image']))
                                    <img src="{{ asset('storage/' . $icon['image']) }}" class="w-10 h-10 object-contain">
                                @else
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $icon['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">{{ $icon['description'] }}</p>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- 3. Rantai Nilai Section -->
        @if($valueChain)
        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-4 max-w-5xl">
                <div class="text-center mb-20" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $valueChain->title }}</h2>
                    <div class="w-24 h-1 bg-green-500 mx-auto rounded-full mb-6"></div>
                    <p class="text-gray-500 max-w-2xl mx-auto">{{ $valueChain->description }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 px-4 relative">
                    <!-- Connector Lines (Desktop Only) -->
                    <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-green-100 -translate-y-1/2 z-0"></div>

                    @foreach($valueChain->icons as $index => $icon)
                        <div class="relative z-10 group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <!-- Sector Badge -->
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
                                @php
                                    $sectors = ['UPSTREAM', 'MIDDLE STREAM', 'DOWNSTREAM'];
                                    $colors = ['bg-emerald-600', 'bg-green-600', 'bg-teal-600'];
                                @endphp
                                <span class="{{ $colors[$index] ?? 'bg-green-600' }} text-white text-[10px] font-black tracking-[0.2em] px-4 py-1.5 rounded-full shadow-lg">
                                    {{ $sectors[$index] ?? 'SECTOR' }}
                                </span>
                            </div>

                            <div class="bg-white rounded-3xl p-8 pt-12 shadow-soft border border-green-50 hover:border-green-300 transition-all duration-500 group-hover:shadow-soft-xl group-hover:-translate-y-2 h-full flex flex-col items-center text-center">
                                <!-- Step Circle -->
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg flex items-center justify-center text-white text-2xl font-bold mb-6 transform group-hover:rotate-6 transition-transform duration-500">
                                    {{ $index + 1 }}
                                </div>

                                @if(!empty($icon['image']))
                                    <div class="w-full h-40 rounded-2xl overflow-hidden mb-6 bg-gray-50 border-4 border-white shadow-inner">
                                        <img src="{{ asset('storage/' . $icon['image']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    </div>
                                @endif

                                <h3 class="text-xl font-bold text-gray-800 mb-4 group-hover:text-green-600 transition-colors duration-300">
                                    {{ $icon['title'] }}
                                </h3>
                                <p class="text-gray-500 leading-relaxed text-sm mb-8">
                                    {{ $icon['description'] }}
                                </p>

                                <!-- Companies/Partners Section -->
                                @if(!empty($icon['companies']))
                                    <div class="w-full pt-6 border-t border-green-50">
                                        <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest mb-4">Unit Bisnis / Mitra</p>
                                        <div class="flex flex-wrap justify-center gap-4">
                                            @foreach($icon['companies'] as $company)
                                                <div class="group/logo relative">
                                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-green-50 flex items-center justify-center p-2 hover:shadow-md hover:border-green-200 transition-all duration-300">
                                                        @if(!empty($company['logo']))
                                                            <img src="{{ asset('storage/' . $company['logo']) }}" alt="{{ $company['name'] }}" class="max-w-full max-h-full object-contain filter grayscale group-hover/logo:grayscale-0 transition-all duration-500">
                                                        @else
                                                            <span class="text-[8px] font-bold text-green-300 text-center uppercase">{{ $company['name'] }}</span>
                                                        @endif
                                                    </div>
                                                    <!-- Tooltip -->
                                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-[10px] rounded opacity-0 group-hover/logo:opacity-100 pointer-events-none transition-opacity duration-300 whitespace-nowrap z-30">
                                                        {{ $company['name'] }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Connector Arrow (Mobile Only) -->
                                @if(!$loop->last)
                                    <div class="md:hidden mt-8 text-green-200">
                                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Connector Arrow (Desktop Only) -->
                                @if(!$loop->last)
                                    <div class="hidden md:flex absolute -right-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-white rounded-full border border-green-100 shadow-md items-center justify-center text-green-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- 4. Struktur Organisasi Section -->
        @if($orgStructure)
        <section class="py-24 bg-gradient-to-br from-green-50 to-white relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-green-100/50 rounded-full blur-3xl -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-100/50 rounded-full blur-3xl -ml-48 -mb-48"></div>

            <div class="container mx-auto px-4 max-w-6xl relative z-10">
                <div class="text-center mb-20" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $orgStructure->title }}</h2>
                    <div class="w-24 h-1 bg-green-600 mx-auto rounded-full mb-6"></div>
                    <div class="prose prose-lg max-w-3xl mx-auto text-gray-600">
                        {!! $orgStructure->description !!}
                    </div>
                </div>

                @if(!empty($orgStructure->icons))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 mb-20">
                    @foreach($orgStructure->icons as $icon)
                        <div class="group flex flex-col items-center" data-aos="fade-up">
                            <div class="relative mb-8">
                                <div class="absolute -inset-3 bg-gradient-to-tr from-green-500 to-emerald-400 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                <div class="relative w-48 h-48 rounded-full overflow-hidden border-8 border-white shadow-2xl group-hover:shadow-soft-xl transition-all duration-500 transform group-hover:scale-105">
                                    @if(!empty($icon['image']))
                                        <img src="{{ asset('storage/' . $icon['image']) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-green-100" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">
                                    {{ $icon['title'] }}
                                </h3>
                                <div class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-sm font-bold uppercase tracking-wider rounded-full mb-4">
                                    {{ $icon['description'] }}
                                </div>
                                <div class="w-8 h-1 bg-green-200 mx-auto rounded-full group-hover:w-20 transition-all duration-500"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CTA Section -->
        <section class="py-20 bg-green-600">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-8">{{ __('Interested in partnering with us?') }}</h2>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="bg-white text-green-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-green-50 transition-all transform hover:scale-105 shadow-xl">
                        {{ __('Get in Touch') }}
                    </a>
                    <a href="{{ route('career') }}" class="border-2 border-white text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-green-600 transition-all transform hover:scale-105">
                        {{ __('Join Our Team') }}
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('styles')
<style>
    .shadow-soft {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
    }
    .shadow-soft-xl {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }
    .prose-green a {
        color: #10b981;
    }
    .prose-green blockquote {
        border-left-color: #10b981;
    }
</style>
@endpush
