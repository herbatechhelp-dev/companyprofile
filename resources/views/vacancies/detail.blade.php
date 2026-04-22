@extends('layouts.app')

@section('title', $vacancy->title . ' - ' . __('Career'))

@section('content')
    <!-- Header Section -->
    <div class="bg-gray-900 -mt-24 pt-24 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" class="w-full h-full object-cover" alt="Background">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="px-4 py-1 rounded-full bg-green-500/20 text-green-300 border border-green-500/30 text-sm font-semibold backdrop-blur-sm">
                        {{ $vacancy->division ?? __('General') }}
                    </span>
                    <span class="px-4 py-1 rounded-full bg-white/10 text-white border border-white/20 text-sm font-semibold backdrop-blur-sm">
                        {{ $vacancy->type }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $vacancy->title }}</h1>
                <div class="flex flex-wrap items-center justify-center gap-6 text-gray-300">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $vacancy->location }}
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Posted :time', ['time' => $vacancy->created_at->diffForHumans()]) }}
                    </div>
                    @if($vacancy->closing_date)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Closes:') }} {{ $vacancy->closing_date->format('d M Y') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-6xl mx-auto">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        {{ __('Job Description') }}
                    </h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! $vacancy->description !!}
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </span>
                        {{ __('Requirements') }}
                    </h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! $vacancy->requirements !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('Apply for this position') }}</h3>
                    <p class="text-gray-500 text-sm mb-6">{{ __('Interested in this role? Send us your application today.') }}</p>

                    @php
                        $applyLink = $vacancy->application_link;
                        $buttonText = __('Apply Now');
                        
                        if (!$applyLink) {
                            $defaultEmail = App\Models\SiteSetting::getValue('email', 'hr@company.com');
                            $subject = 'Application for ' . $vacancy->title;
                            $body = 'Dear HR Team,%0D%0A%0D%0AI am writing to apply for the ' . $vacancy->title . ' position...';
                            $applyLink = "mailto:$defaultEmail?subject=$subject&body=$body";
                            $buttonText = __('Apply via Email');
                        }
                    @endphp

                    <a href="{{ $applyLink }}" 
                       target="{{ str_contains($applyLink, 'mailto:') ? '_self' : '_blank' }}"
                       class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 mb-4">
                        {{ $buttonText }}
                    </a>
                    
                    <div class="text-center text-xs text-gray-400 mb-6">
                         @if(!str_contains($applyLink, 'mailto:'))
                            {{ __('(Opens in a new tab)') }}
                         @else
                            {{ __('Please include your CV and Portfolio') }}
                         @endif
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="font-semibold text-gray-800 mb-4 text-sm">{{ __('Share this opening') }}</h4>
                        <div class="flex justify-center space-x-4">
                            <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}', '_blank', 'width=600,height=400')" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </button>
                            <button onclick="window.open('https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $vacancy->title }}', '_blank', 'width=600,height=400')" class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white flex items-center justify-center transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </button>
                            <button onclick="window.open('https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}', '_blank', 'width=600,height=400')" class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white flex items-center justify-center transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mx-auto px-4 pb-16">
        <a href="javascript:history.back()" class="inline-flex items-center text-gray-500 hover:text-green-600 font-medium transition duration-300">

            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('Back') }}

        </a>
    </div>
@endsection
