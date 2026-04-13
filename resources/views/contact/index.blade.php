@extends('layouts.app')

@section('title', 'Contact Us - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Banner Section -->
    @if($heroSection && ($heroSection->background_image || $heroSection->background_video))
        <x-hero-banner
            :title="$heroSection->title ?? __('Contact Us')"
            :subtitle="!$heroSection->content ? __('Get in touch with us for any inquiries or collaborations') : ''"
            :content="$heroSection->content ?? ''"
            :backgroundImage="$heroSection->background_image"
            :backgroundVideo="$heroSection->background_video"
            height="medium"
            overlay="dark"
            alignment="center"
            animation="slide-up"
        />
    @else
        <x-hero-banner
            title="{{ __('Contact Us') }}"
            subtitle="{{ __('Get in touch with us for any inquiries or collaborations') }}"
            height="medium"
            alignment="center"
            animation="fade"
        />
    @endif

    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="animate-fade-in">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('Send us a Message') }}</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-custom mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Full Name *') }}</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-custom focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300"
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email Address *') }}</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-custom focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Message *') }}</label>
                            <textarea id="message" name="message" required rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-custom focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-custom transition duration-300">
                            {{ __('Send Message') }}
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="animate-fade-in">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('Get in Touch') }}</h2>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ __('Address') }}</h3>
                                <p class="text-gray-600">{{ App\Models\SiteSetting::getValue('address', 'Company Address') }}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ __('Phone') }}</h3>
                                <p class="text-gray-600">{{ App\Models\SiteSetting::getValue('phone', '+62 XXX XXXX') }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ __('Email') }}</h3>
                                <p class="text-gray-600">{{ App\Models\SiteSetting::getValue('email', 'info@company.com') }}</p>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ __('Business Hours') }}</h3>
                                <p class="text-gray-600">{{ __('Monday - Friday: 9:00 AM - 6:00 PM') }}</p>
                                <p class="text-gray-600">{{ __('Saturday: 9:00 AM - 2:00 PM') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Follow Us') }}</h3>
                        <div class="flex space-x-4">
                            @if($facebook = App\Models\SiteSetting::getValue('facebook_url'))
                            <a href="{{ $facebook }}" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            @endif
                            
                            @if($twitter = App\Models\SiteSetting::getValue('twitter_url'))
                            <a href="{{ $twitter }}" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            @endif
                            
                            @if($instagram = App\Models\SiteSetting::getValue('instagram_url'))
                            <a href="{{ $instagram }}" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.22 14.815 3.73 13.664 3.73 12.367s.49-2.448 1.396-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.906.875 1.396 2.026 1.396 3.323s-.49 2.448-1.396 3.323c-.875.807-2.026 1.297-3.323 1.297z"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">{{ __('Find Us Here') }}</h2>
            <div class="bg-white rounded-custom shadow-custom overflow-hidden">
                <!-- Replace with your actual Google Maps embed code -->
                <div class="h-96 bg-green-100 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-green-600 text-lg">{{ __('Google Maps Integration') }}</p>
                        <p class="text-green-500 text-sm mt-2"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1481.9607144855875!2d109.3738798317013!3d-7.425297115753845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65590064341891%3A0xca0455a08031b477!2sPT%20HERBATECH%20INNOPHARMA%20INDUSTRY!5e0!3m2!1sid!2sid!4v1761800362030!5m2!1sid!2sid" width="1200" height="400" style="border:0;" allowfullscreen="yes" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection