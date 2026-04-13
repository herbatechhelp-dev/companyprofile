@extends('layouts.app')

@section('title', 'Career Opportunities - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Hero Banner -->
    <x-hero-banner
        title="{{ __('Join Our Team') }}"
        subtitle="{{ __('Explore exciting career opportunities with us') }}"
        :backgroundImage="App\Models\SiteSetting::getValue('career_hero_image', 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')"
        height="small"
        overlay="gradient"
        alignment="center"
        animation="fade"
    />

    <!-- Vacancies List Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-green-600 font-semibold tracking-wider uppercase text-sm">{{ __('Grow With Us') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-3 mb-6">{{ __('Current Openings') }}</h2>
                <p class="text-gray-600 leading-relaxed">
                    {{ __('We are always looking for talented individuals to join our team. Check out our open positions below and see where you fit in.') }}
                </p>
            </div>

            @if($vacancies->count() > 0)
                <div class="grid gap-6">
                    @foreach($vacancies as $vacancy)
                        <a href="{{ route('career.detail', $vacancy->slug) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden transform hover:-translate-y-1">
                            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                            {{ $vacancy->division ?? __('General') }}
                                        </span>
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                            {{ $vacancy->type }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300 mb-2">
                                        {{ $vacancy->title }}
                                    </h3>
                                    <div class="flex items-center gap-4 text-gray-500 text-sm">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $vacancy->location }}
                                        </div>
                                        @if($vacancy->closing_date)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ __('Closes:') }} {{ $vacancy->closing_date->format('d M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors duration-300">
                                        {{ __('View Details') }}
                                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-800 mb-2">{{ __('No Openings Available') }}</h3>
                    <p class="text-gray-500">{{ __("We don't have any open positions right now. Please check back later.") }}</p>

                </div>
            @endif
        </div>
    </section>
@endsection
