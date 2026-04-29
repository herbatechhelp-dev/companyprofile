<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', App\Models\SiteSetting::getValue('company_name', 'Company Profile'))</title>

    <!-- Favicon -->
    @php
        $logo = App\Models\SiteSetting::getLogo();
        $favicon = App\Models\SiteSetting::getFavicon();
        $companyName = App\Models\SiteSetting::getCompanyName();

        // Pilih icon: gunakan favicon jika ada, jika tidak fallback ke logo
        $siteIcon = $favicon ?: $logo;

        $articleCategories = App\Models\ArticleCategory::whereNotIn('name', ['CSR Activities', 'Events & News'])
            ->orderBy('name')
            ->get();
    @endphp

    @if($siteIcon)
        <!-- Favicon dari pengaturan (favicon atau logo) -->
        <link rel="icon" type="image/x-icon" href="{{ $siteIcon }}">
        <link rel="icon" type="image/png" href="{{ $siteIcon }}">
        <link rel="apple-touch-icon" href="{{ $siteIcon }}">
        <link rel="shortcut icon" href="{{ $siteIcon }}" type="image/x-icon">
    @else
        <!-- Fallback favicon dengan inisial company -->
        <link rel="icon"
            href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90' fill='%232E8B57'>{{ substr($companyName, 0, 1) }}</text></svg>">
    @endif

    <!-- Meta tags untuk favicon -->
    <meta name="theme-color" content="#2E8B57">
    <meta name="msapplication-TileColor" content="#2E8B57">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #2E8B57;
            --secondary-green: #A4D792;
            --light-green: #E8F5E9;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .rounded-custom {
            border-radius: 20px;
        }

        .shadow-custom {
            box-shadow: 0 4px 20px rgba(46, 139, 87, 0.1);
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Marquee Animation for Partners */
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @php
            $marqueeSpeed = App\Models\SiteSetting::getValue('partner_marquee_speed', 25);
        @endphp
        .animate-marquee {
            display: flex !important;
            flex-shrink: 0 !important;
            min-width: 100% !important;
            align-items: center;
            justify-content: space-around;
            animation: marquee
                {{ $marqueeSpeed }}
                s linear infinite !important;
            will-change: transform;
        }

        .marquee-wrapper:hover .animate-marquee {
            animation-play-state: paused !important;
        }

        .marquee-wrapper {
            overflow: hidden;
            display: flex;
            flex-wrap: nowrap;
            white-space: nowrap;
            width: 100%;
        }

        /* Header Styles - Default (for non-home pages) */
        .header-default {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(46, 139, 87, 0.1);
        }

        /* Header Styles - For Home Page Only */
        .header-transparent {
            background: transparent;
            backdrop-filter: blur(0px);
            transition: all 0.3s ease-in-out;
        }

        .header-solid {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(46, 139, 87, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .header-hidden {
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .header-visible {
            transform: translateY(0);
            transition: transform 0.3s ease-in-out;
        }

        /* Footer Styles */
        .footer-gradient {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }

        /* Mobile Menu Transitions */
        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: white;
            z-index: 50;
            transition: all 0.3s ease-in-out;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .mobile-menu-panel.active {
            right: 0;
        }

        /* Hamburger Animation */
        .hamburger-line {
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }

        .mobile-menu-active .hamburger-line:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }

        .mobile-menu-active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-active .hamburger-line:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }

        /* Accordion Styles */
        .mobile-accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-accordion-active .mobile-accordion-content {
            max-height: 500px;
            transition: max-height 0.5s ease-in;
        }

        .mobile-accordion-header svg {
            transition: transform 0.3s ease;
        }

        .mobile-accordion-active .mobile-accordion-header svg {
            transform: rotate(180deg);
        }

        /* =============================================
           CUSTOM SCROLLBAR - Aesthetic Green Theme
        ============================================= */

        /* Global Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(232, 245, 233, 0.4);
            border-radius: 100px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #2E8B57 0%, #A4D792 100%);
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: background 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #1f6b40 0%, #2E8B57 100%);
            box-shadow: 0 0 6px rgba(46, 139, 87, 0.4);
        }

        ::-webkit-scrollbar-corner {
            background: transparent;
        }

        /* Firefox Scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #2E8B57 rgba(232, 245, 233, 0.4);
        }

        /* =============================================
           FLOATING CONTACT WIDGET
        ============================================= */
        .fab-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            display: flex;
            flex-direction: column-reverse;
            align-items: center;
            gap: 15px;
        }

        .fab-main {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2E8B57 0%, #1f6b40 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 10px 25px rgba(46, 139, 87, 0.3);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .fab-main::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid #2E8B57;
            opacity: 0;
            animation: fab-pulse 2s infinite;
        }

        @keyframes fab-pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        .fab-main:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .fab-main.active {
            transform: scale(1.1) rotate(90deg);
            background: #1a1a1a;
        }

        .fab-menu {
            display: flex;
            flex-direction: column-reverse;
            gap: 12px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .fab-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .fab-item {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            text-decoration: none;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .fab-item:hover {
            transform: scale(1.1);
        }

        .fab-item.whatsapp {
            background: #25D366;
        }

        .fab-item.instagram {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .fab-item.phone {
            background: #3b82f6;
        }

        .fab-tooltip {
            position: absolute;
            right: 70px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .fab-item:hover .fab-tooltip {
            opacity: 1;
            visibility: visible;
            right: 65px;
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: #2E8B57 rgba(232, 245, 233, 0.4);
        }

        /* Mobile & Modal Scrollable Areas */
        .overflow-y-auto::-webkit-scrollbar,
        .overflow-y-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb,
        .overflow-y-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #2E8B57 0%, #A4D792 100%);
            border-radius: 100px;
        }

        .overflow-y-auto::-webkit-scrollbar-track,
        .overflow-y-scroll::-webkit-scrollbar-track {
            background: rgba(232, 245, 233, 0.3);
            border-radius: 100px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Header -->
    @php
        $isHomePage = request()->is('/');
    @endphp

    <!-- Header -->
    @php
        $isHomePage = request()->is('/');
    @endphp

    <header id="main-header"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $isHomePage ? 'header-transparent' : 'header-default' }}">
        <nav class="container mx-auto px-4 py-1.5 lg:py-2">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2.5 flex-1 min-w-0 pr-4">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2.5 flex-1 min-w-0">
                        <div
                            class="w-12 h-12 md:w-14 md:h-14 rounded-lg flex-shrink-0 flex items-center justify-center logo-container">
                            @if($logo)
                                <img src="{{ $logo }}" alt="Logo" class="w-12 h-12 md:w-14 md:h-14 object-contain">
                            @else
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 bg-green-500 rounded-lg flex items-center justify-center text-white font-bold text-sm md:text-base">
                                    {{ substr($companyName, 0, 2) }}
                                </div>
                            @endif
                        </div>
                        <div class="header-text flex-1 min-w-0">
                            <h1
                                class="text-[13px] md:text-[15px] font-bold {{ $isHomePage ? 'text-white' : 'text-gray-800' }} transition-colors duration-300 truncate leading-none mt-0.5">
                                {{ App\Models\SiteSetting::getNavbarCompanyName1() }}
                            </h1>
                            @if(App\Models\SiteSetting::getNavbarCompanyName2())
                                <p
                                    class="text-[11px] md:text-[12px] font-semibold {{ $isHomePage ? 'text-green-200' : 'text-green-600' }} transition-colors duration-300 hidden lg:block truncate leading-tight mt-0.5">
                                    {{ App\Models\SiteSetting::getNavbarCompanyName2() }}
                                </p>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-5 lg:space-x-7 text-[13px] lg:text-[14px]">
                    <a href="{{ url('/') }}"
                        class="nav-link font-medium transition duration-300 {{ $isHomePage ? 'text-white hover:text-green-300' : 'text-gray-700 hover:text-green-600' }}">
                        {{ __('Home') }}
                    </a>

                    <a href="{{ route('about') }}"
                        class="nav-link font-medium transition duration-300 {{ $isHomePage ? 'text-white hover:text-green-300' : 'text-gray-700 hover:text-green-600' }}">
                        {{ __('About Us') }}
                    </a>

                    <!-- Articles Dropdown -->
                    <div class="relative group">
                        <button
                            class="nav-link font-medium transition duration-300 flex items-center {{ $isHomePage ? 'text-white hover:text-green-300' : 'text-gray-700 hover:text-green-600' }}">
                            {{ __('Articles') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-56 bg-white rounded-custom shadow-custom opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 dropdown-menu">
                            @foreach($articleCategories as $cat)
                                <a href="{{ route('articles.category', $cat->slug) }}"
                                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 {{ $loop->first ? 'rounded-t-custom' : '' }} {{ $loop->last ? 'rounded-b-custom' : '' }} transition duration-300">
                                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-18 0h2m8-8V7m0 4h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                            @if($articleCategories->isEmpty())
                                <div class="px-4 py-3 text-gray-500 text-sm">{{ __('No categories') }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Our Company Dropdown -->


                    <!-- Business Dropdown (Industry & Facilities) -->
                    <div class="relative group">
                        <button
                            class="nav-link font-medium transition duration-300 flex items-center {{ $isHomePage ? 'text-white hover:text-green-300' : 'text-gray-700 hover:text-green-600' }}">
                            {{ __('Business') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-56 bg-white rounded-custom shadow-custom opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 dropdown-menu">
                            <a href="{{ route('industry') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-t-custom transition duration-300">
                                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                {{ __('Our Products') }}
                            </a>
                            <a href="{{ route('facilities') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition duration-300">
                                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-18 0h2m8-8V7m0 4h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('Our Facilities') }}
                            </a>
                            <a href="{{ route('career') }}"
                                class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-b-custom transition duration-300">
                                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('Career') }}
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}"
                        class="nav-link font-medium transition duration-300 {{ $isHomePage ? 'text-white hover:text-green-300' : 'text-gray-700 hover:text-green-600' }}">
                        {{ __('Contact') }}
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex-shrink-0">
                    <button id="mobile-menu-button"
                        class="relative z-50 p-2 focus:outline-none {{ $isHomePage ? 'text-white' : 'text-gray-700' }}"
                        aria-label="Toggle Menu">
                        <div class="w-6 h-5 flex flex-col justify-between">
                            <span class="hamburger-line block h-0.5 w-full bg-current rounded-full"></span>
                            <span class="hamburger-line block h-0.5 w-full bg-current rounded-full"></span>
                            <span class="hamburger-line block h-0.5 w-full bg-current rounded-full"></span>
                        </div>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="mobile-menu-overlay md:hidden"></div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu-panel" class="mobile-menu-panel md:hidden">
            <!-- Close button & Logo -->
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-custom flex items-center justify-center">
                        @if($logo)
                            <img src="{{ $logo }}" alt="Logo" class="w-10 h-10 object-contain">
                        @else
                            <div
                                class="w-10 h-10 bg-green-500 rounded-custom flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($companyName, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="font-bold text-gray-800 leading-tight">{{ App\Models\SiteSetting::getNavbarCompanyName1() }}</span>
                        @if(App\Models\SiteSetting::getNavbarCompanyName2())
                            <span
                                class="text-sm font-medium text-green-600 leading-tight">{{ App\Models\SiteSetting::getNavbarCompanyName2() }}</span>
                        @endif
                    </div>
                </div>
                <button id="mobile-menu-close"
                    class="p-2 text-gray-500 hover:text-green-600 focus:outline-none transition-colors rounded-full hover:bg-gray-100"
                    aria-label="Close Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto py-6 px-6 space-y-6">
                <a href="{{ url('/') }}"
                    class="flex items-center text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                    {{ __('Home') }}
                </a>

                <a href="{{ route('about') }}"
                    class="flex items-center text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                    {{ __('About Us') }}
                </a>

                <!-- Articles Accordion -->
                <div class="mobile-accordion">
                    <button
                        class="mobile-accordion-header w-full flex items-center justify-between text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                        <span>{{ __('Articles') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="mobile-accordion-content mt-2 space-y-3 pl-4">
                        @foreach($articleCategories as $cat)
                            <a href="{{ route('articles.category', $cat->slug) }}"
                                class="block text-gray-600 hover:text-green-600 transition duration-300">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Business Accordion -->
                <div class="mobile-accordion">
                    <button
                        class="mobile-accordion-header w-full flex items-center justify-between text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                        <span>{{ __('Business') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="mobile-accordion-content mt-2 space-y-3 pl-4">
                        <a href="{{ route('industry') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">
                            {{ __('Our Products') }}
                        </a>
                        <a href="{{ route('facilities') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">
                            {{ __('Our Facilities') }}
                        </a>
                        <a href="{{ route('career') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">
                            {{ __('Career') }}
                        </a>
                    </div>
                </div>

                <!-- Our Company Accordion (If applicable) -->
                <div class="mobile-accordion">
                    <button
                        class="mobile-accordion-header w-full flex items-center justify-between text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                        <span>{{ __('Our Company') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="mobile-accordion-content mt-2 space-y-3 pl-4">
                        <a href="{{ route('company.page', 'our-group') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">Our Group</a>
                        <a href="{{ route('company.page', 'sustainability') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">Sustainability</a>
                        <a href="{{ route('company.page', 'legal') }}"
                            class="block text-gray-600 hover:text-green-600 transition duration-300">Legal &
                            Compliance</a>
                    </div>
                </div>

                <a href="{{ route('contact') }}"
                    class="block text-lg font-medium text-gray-700 hover:text-green-600 transition duration-300">
                    {{ __('Contact') }}
                </a>
            </div>

            <!-- Footer in Mobile Menu -->
            <div class="p-6 border-t border-gray-100 space-y-4">
                <div class="flex items-center space-x-4">
                    @if($facebook = App\Models\SiteSetting::getValue('facebook_url'))
                        <a href="{{ $facebook }}" target="_blank" class="text-gray-400 hover:text-green-600"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg></a>
                    @endif
                    @if($instagram = App\Models\SiteSetting::getValue('instagram_url'))
                        <a href="{{ $instagram }}" target="_blank" class="text-gray-400 hover:text-green-600"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.22 14.815 3.73 13.664 3.73 12.367s.49-2.448 1.396-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.906.875 1.396 2.026 1.396 3.323s-.49 2.448-1.396 3.323c-.875.807-2.026 1.297-3.323 1.297z" />
                            </svg></a>
                    @endif
                </div>
                <p class="text-xs text-gray-400">© {{ date('Y') }} {{ $companyName }}</p>
            </div>
        </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="{{ $isHomePage ? 'pt-0' : 'pt-24' }}">
        <!-- No padding-top for home, padding for other pages to clear the 80px header -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#06121A] text-white relative overflow-hidden">
        <!-- Premium background layer -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <!-- Grid subtle pattern -->
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDM5LjVoNDBNMzkuNSAwdjQwIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiIHN0cm9rZS13aWR0aD0iMSIvPjwvc3ZnPg==')] z-0 opacity-40">
            </div>
            <!-- Dynamic Glowing Orbs -->
            <div
                class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-[#63809A]/15 blur-[130px] animate-pulse z-0">
            </div>
            <div
                class="absolute bottom-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-[#8CAAC5]/10 blur-[150px] z-0">
            </div>
            <div
                class="absolute top-[40%] left-[50%] -translate-x-1/2 w-[800px] h-[300px] rounded-full bg-[#13344A]/40 blur-[120px] z-0">
            </div>
            <!-- Glassy top border -->
            <div
                class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-[#B8D5F1]/20 to-transparent">
            </div>
        </div>

        <div class="container mx-auto px-6 pt-20 pb-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Company Info Panel -->
                <div class="lg:col-span-5 relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[#63809A]/10 to-transparent rounded-[2rem] blur-xl transition-all duration-700 group-hover:from-[#63809A]/20">
                    </div>
                    <div
                        class="relative h-full bg-[#13344A]/40 backdrop-blur-xl border border-white/[0.08] rounded-[2rem] p-8 lg:p-10 shadow-2xl transition-all duration-500 hover:border-white/[0.15] hover:bg-[#13344A]/60">
                        <div class="flex items-center space-x-5 mb-8">
                            <div
                                class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md border border-white/10 shadow-[0_0_20px_rgba(184,213,241,0.15)] relative overflow-hidden group-hover:shadow-[0_0_30px_rgba(184,213,241,0.3)] transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-[#B8D5F1]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>
                                @if($logo)
                                    <img src="{{ $logo }}" alt="Logo"
                                        class="w-10 h-10 object-contain relative z-10 drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">
                                @else
                                    <div class="text-[#B8D5F1] font-bold text-2xl relative z-10 tracking-wider">
                                        {{ substr($companyName, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3
                                    class="text-3xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-[#B8D5F1] drop-shadow-md">
                                    {{ $companyName }}
                                </h3>
                                @if(App\Models\SiteSetting::getCompanySubName())
                                    <p
                                        class="text-[10px] font-bold text-[#B8D5F1] uppercase tracking-[0.25em] mt-1.5 opacity-100">
                                        {{ App\Models\SiteSetting::getCompanySubName() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <p class="text-white leading-relaxed font-normal text-sm mb-8 pr-4 drop-shadow-sm">
                            {{ App\Models\SiteSetting::getValue('footer_description', 'Leading the way in sustainable technology and environmental solutions for a better tomorrow.') }}
                            <br><span
                                class="inline-block mt-4 text-xs italic text-[#B8D5F1] border-l-2 border-[#8CAAC5] pl-3 py-0.5">{{ App\Models\SiteSetting::getTagline() }}</span>
                        </p>

                        <div class="flex items-center space-x-3 pt-4 border-t border-white/[0.08]">
                            @if($facebook = App\Models\SiteSetting::getValue('facebook_url'))
                                <a href="{{ $facebook }}" target="_blank"
                                    class="w-10 h-10 rounded-xl bg-white/[0.05] flex items-center justify-center border border-white/[0.08] text-[#8CAAC5] hover:text-[#B8D5F1] hover:bg-[#63809A]/30 hover:border-[#8CAAC5]/50 hover:-translate-y-1 hover:shadow-[0_5px_15px_rgba(99,128,154,0.3)] transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            @endif

                            @if($twitter = App\Models\SiteSetting::getValue('twitter_url'))
                                <a href="{{ $twitter }}" target="_blank"
                                    class="w-10 h-10 rounded-xl bg-white/[0.05] flex items-center justify-center border border-white/[0.08] text-[#8CAAC5] hover:text-[#B8D5F1] hover:bg-[#63809A]/30 hover:border-[#8CAAC5]/50 hover:-translate-y-1 hover:shadow-[0_5px_15px_rgba(99,128,154,0.3)] transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                </a>
                            @endif

                            @if($instagram = App\Models\SiteSetting::getValue('instagram_url'))
                                <a href="{{ $instagram }}" target="_blank"
                                    class="w-10 h-10 rounded-xl bg-white/[0.05] flex items-center justify-center border border-white/[0.08] text-[#8CAAC5] hover:text-[#B8D5F1] hover:bg-[#63809A]/30 hover:border-[#8CAAC5]/50 hover:-translate-y-1 hover:shadow-[0_5px_15px_rgba(99,128,154,0.3)] transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.22 14.815 3.73 13.664 3.73 12.367s.49-2.448 1.396-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.906.875 1.396 2.026 1.396 3.323s-.49 2.448-1.396 3.323c-.875.807-2.026 1.297-3.323 1.297z" />
                                    </svg>
                                </a>
                            @endif

                            @if($linkedin = App\Models\SiteSetting::getValue('linkedin_url'))
                                <a href="{{ $linkedin }}" target="_blank"
                                    class="w-10 h-10 rounded-xl bg-white/[0.05] flex items-center justify-center border border-white/[0.08] text-[#8CAAC5] hover:text-[#B8D5F1] hover:bg-[#63809A]/30 hover:border-[#8CAAC5]/50 hover:-translate-y-1 hover:shadow-[0_5px_15px_rgba(99,128,154,0.3)] transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation Links Panel -->
                <div class="lg:col-span-3 lg:col-start-6 lg:-mt-2 relative">
                    <h4 class="text-[11px] font-bold tracking-[0.25em] text-white uppercase mb-8 flex items-center drop-shadow-sm">
                        <span class="w-8 h-px bg-[#8CAAC5] mr-4"></span>
                        {{ __('Quick Links') }}
                    </h4>
                    <div class="space-y-4 pl-12 flex flex-col items-start">
                        <a href="{{ url('/') }}"
                            class="group flex items-center space-x-3 text-[#B8D5F1] hover:text-white transition-all duration-300 font-medium">
                            <span
                                class="w-0 h-px bg-[#B8D5F1] transition-all duration-300 group-hover:w-4 group-hover:bg-white"></span>
                            <span
                                class="text-sm transform transition-transform duration-300 group-hover:translate-x-1">Home</span>
                        </a>
                        @foreach($articleCategories as $cat)
                            <a href="{{ route('articles.category', $cat->slug) }}"
                                class="group flex items-center space-x-3 text-[#B8D5F1] hover:text-white transition-all duration-300 font-medium">
                                <span
                                    class="w-0 h-px bg-[#B8D5F1] transition-all duration-300 group-hover:w-4 group-hover:bg-white"></span>
                                <span
                                    class="text-sm transform transition-transform duration-300 group-hover:translate-x-1">{{ $cat->name }}</span>
                            </a>
                        @endforeach
                        <a href="{{ route('industry') }}"
                            class="group flex items-center space-x-3 text-[#B8D5F1] hover:text-white transition-all duration-300 font-medium">
                            <span
                                class="w-0 h-px bg-[#B8D5F1] transition-all duration-300 group-hover:w-4 group-hover:bg-white"></span>
                            <span
                                class="text-sm transform transition-transform duration-300 group-hover:translate-x-1">Our
                                Products</span>
                        </a>
                        <a href="{{ route('facilities') }}"
                            class="group flex items-center space-x-3 text-[#B8D5F1] hover:text-white transition-all duration-300 font-medium">
                            <span
                                class="w-0 h-px bg-[#B8D5F1] transition-all duration-300 group-hover:w-4 group-hover:bg-white"></span>
                            <span
                                class="text-sm transform transition-transform duration-300 group-hover:translate-x-1">Our
                                Facilities</span>
                        </a>
                        <a href="{{ route('contact') }}"
                            class="group flex items-center space-x-3 text-[#B8D5F1] hover:text-white transition-all duration-300 font-medium">
                            <span
                                class="w-0 h-px bg-[#B8D5F1] transition-all duration-300 group-hover:w-4 group-hover:bg-white"></span>
                            <span
                                class="text-sm transform transition-transform duration-300 group-hover:translate-x-1">Contact
                                Us</span>
                        </a>
                    </div>
                </div>

                <!-- Contact Info Panel -->
                <div class="lg:col-span-4 lg:-mt-2 relative">
                    <h4 class="text-[11px] font-bold tracking-[0.25em] text-white uppercase mb-8 flex items-center drop-shadow-sm">
                        <span class="w-8 h-px bg-[#8CAAC5] mr-4"></span>
                        {{ __('Contact Info') }}
                    </h4>
                    <div class="space-y-6">
                        <div
                            class="flex items-start space-x-4 group p-3 -m-3 rounded-2xl hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/[0.12]">
                            <div
                                class="mt-1 w-10 h-10 rounded-xl bg-white/[0.08] border border-white/[0.12] flex items-center justify-center flex-shrink-0 relative overflow-hidden group-hover:border-[#B8D5F1]/60 group-hover:bg-[#63809A]/40 transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md">
                                </div>
                                <svg class="w-4 h-4 text-[#B8D5F1] group-hover:text-white transition-colors relative z-10 duration-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-sm text-white font-normal leading-relaxed pt-1.5">{{ App\Models\SiteSetting::getValue('address', 'Jl. Sustainable Development No. 123, Jakarta, Indonesia') }}</span>
                        </div>

                        <div
                            class="flex items-center space-x-4 group p-3 -mx-3 -my-1.5 rounded-2xl hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/[0.12]">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/[0.08] border border-white/[0.12] flex items-center justify-center flex-shrink-0 relative overflow-hidden group-hover:border-[#B8D5F1]/60 group-hover:bg-[#63809A]/40 transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md">
                                </div>
                                <svg class="w-4 h-4 text-[#B8D5F1] group-hover:text-white transition-colors relative z-10 duration-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <a href="tel:{{ App\Models\SiteSetting::getValue('phone', '+622112345678') }}"
                                class="text-sm text-white font-normal group-hover:text-[#B8D5F1] transition-colors duration-500">
                                {{ App\Models\SiteSetting::getValue('phone', '+62 21 1234 5678') }}
                            </a>
                        </div>

                        <div
                            class="flex items-center space-x-4 group p-3 -mx-3 -my-1.5 rounded-2xl hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/[0.12]">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/[0.08] border border-white/[0.12] flex items-center justify-center flex-shrink-0 relative overflow-hidden group-hover:border-[#B8D5F1]/60 group-hover:bg-[#63809A]/40 transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md">
                                </div>
                                <svg class="w-4 h-4 text-[#B8D5F1] group-hover:text-white transition-colors relative z-10 duration-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <a href="mailto:{{ App\Models\SiteSetting::getValue('email', 'info@company.com') }}"
                                class="text-sm text-white font-normal group-hover:text-[#B8D5F1] transition-colors duration-500">
                                {{ App\Models\SiteSetting::getValue('email', 'info@company.com') }}
                            </a>
                        </div>

                        <div
                            class="flex items-start space-x-4 group p-3 -mx-3 -my-1.5 rounded-2xl hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/[0.12]">
                            <div
                                class="mt-1 w-10 h-10 rounded-xl bg-white/[0.08] border border-white/[0.12] flex items-center justify-center flex-shrink-0 relative overflow-hidden group-hover:border-[#B8D5F1]/60 group-hover:bg-[#63809A]/40 transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md">
                                </div>
                                <svg class="w-4 h-4 text-[#B8D5F1] group-hover:text-white transition-colors relative z-10 duration-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-sm text-white font-normal leading-relaxed pt-1.5 space-y-1">
                                <p>Monday - Friday: 8:00 - 17.00 WIB</p>
                                <p>Saturday: 8:00 - 12:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div
                class="mt-20 pt-10 border-t border-white/[0.12] flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 relative z-10 pb-2">
                <p class="text-[#B8D5F1] text-xs font-normal tracking-wide text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="text-white font-bold">{{ $companyName }}</span>.
                    {{ __('All rights reserved.') }}
                </p>

            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenuPanel = document.getElementById('mobile-menu-panel');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const body = document.body;

        function toggleMobileMenu() {
            if (mobileMenuButton) mobileMenuButton.classList.toggle('mobile-menu-active');
            if (mobileMenuPanel) mobileMenuPanel.classList.toggle('active');
            if (mobileMenuOverlay) mobileMenuOverlay.classList.toggle('active');
            body.classList.toggle('overflow-hidden');
        }

        if (mobileMenuButton) mobileMenuButton.addEventListener('click', toggleMobileMenu);
        if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', toggleMobileMenu);

        const mobileMenuCloseBtn = document.getElementById('mobile-menu-close');
        if (mobileMenuCloseBtn) {
            mobileMenuCloseBtn.addEventListener('click', toggleMobileMenu);
        }

        // Mobile Accordion Logic
        document.querySelectorAll('.mobile-accordion-header').forEach(header => {
            header.addEventListener('click', function () {
                const accordion = this.parentElement;
                const isOpen = accordion.classList.contains('mobile-accordion-active');

                // Close other accordions
                document.querySelectorAll('.mobile-accordion').forEach(acc => {
                    acc.classList.remove('mobile-accordion-active');
                });

                // Toggle current
                if (!isOpen) {
                    accordion.classList.add('mobile-accordion-active');
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    if (mobileMenuPanel.classList.contains('active')) {
                        toggleMobileMenu();
                    }
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Check if current page is home page
        const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';

        // Header scroll effect - ONLY FOR HOME PAGE
        if (isHomePage) {
            let lastScrollTop = 0;
            const header = document.getElementById('main-header');
            const navLinks = document.querySelectorAll('.nav-link:not(#mobile-menu-button)');
            const headerText = document.querySelector('.header-text');

            function updateHeader() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                // Show/hide header based on scroll direction
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                    header.classList.add('header-visible');
                }

                // Change header background based on scroll position
                if (scrollTop > 50) {
                    header.classList.remove('header-transparent');
                    header.classList.add('header-solid');

                    navLinks.forEach(link => {
                        link.classList.remove('text-white', 'hover:text-green-300');
                        link.classList.add('text-gray-700', 'hover:text-green-600');
                    });

                    const mobileBtn = document.getElementById('mobile-menu-button');
                    if (mobileBtn && !mobileBtn.classList.contains('mobile-menu-active')) {
                        mobileBtn.classList.remove('text-white');
                        mobileBtn.classList.add('text-gray-700');
                    }

                    if (headerText) {
                        const title = headerText.querySelector('h1');
                        const tagline = headerText.querySelector('p');
                        if (title) { title.classList.remove('text-white'); title.classList.add('text-gray-800'); }
                        if (tagline) { tagline.classList.remove('text-green-200'); tagline.classList.add('text-green-600'); }
                    }
                } else {
                    header.classList.remove('header-solid');
                    header.classList.add('header-transparent');

                    navLinks.forEach(link => {
                        link.classList.remove('text-gray-700', 'hover:text-green-600');
                        link.classList.add('text-white', 'hover:text-green-300');
                    });

                    const mobileBtn = document.getElementById('mobile-menu-button');
                    if (mobileBtn && !mobileBtn.classList.contains('mobile-menu-active')) {
                        mobileBtn.classList.remove('text-gray-700');
                        mobileBtn.classList.add('text-white');
                    }

                    if (headerText) {
                        const title = headerText.querySelector('h1');
                        const tagline = headerText.querySelector('p');
                        if (title) { title.classList.remove('text-gray-800'); title.classList.add('text-white'); }
                        if (tagline) { tagline.classList.remove('text-green-600'); tagline.classList.add('text-green-200'); }
                    }
                }
                lastScrollTop = scrollTop;
            }

            let ticking = false;
            window.addEventListener('scroll', function () {
                if (!ticking) {
                    window.requestAnimationFrame(function () {
                        updateHeader();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
            updateHeader();
        }
    </script>

    <!-- Slideshow Script -->
    <script>
        {!! file_get_contents(resource_path('js/slideshow.js')) !!}
    </script>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
        });
    </script>

    <!-- Floating Contact Widget -->
    @php
        $phone = App\Models\SiteSetting::getPhone();
        $waNumber = preg_replace('/[^0-9]/', '', $phone);
        $igUrl = App\Models\SiteSetting::getInstagramUrl();
        $fbUrl = App\Models\SiteSetting::getFacebookUrl();
        $companyName = App\Models\SiteSetting::getCompanyName();
        $waMessage = urlencode("Halo {$companyName}, saya ingin bertanya mengenai layanan Anda...");
    @endphp

    <div class="fab-container">
        <!-- Main Float Button -->
        <div class="fab-main" id="contactFab" onclick="toggleFabMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                </path>
            </svg>
        </div>

        <!-- Float Menu -->
        <div class="fab-menu" id="fabMenu">
            <!-- WhatsApp -->
            @if($waNumber)
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="fab-item whatsapp">
                    <span class="fab-tooltip">Chat WhatsApp</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .018 5.396.015 12.03a11.968 11.968 0 001.605 6.059l-1.706 6.233 6.376-1.673a11.903 11.903 0 005.698 1.448h.005c6.637 0 12.032-5.397 12.036-12.031a11.817 11.817 0 00-3.617-8.53">
                        </path>
                    </svg>
                </a>
            @endif

            <!-- Instagram -->
            @if($igUrl)
                <a href="{{ $igUrl }}" target="_blank" class="fab-item instagram">
                    <span class="fab-tooltip">Follow Instagram</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"></rect>
                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="2"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2"></line>
                    </svg>
                </a>
            @endif

            <!-- Phone -->
            @if($phone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="fab-item phone">
                    <span class="fab-tooltip">Hubungi Kami</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                        </path>
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <script>
        function toggleFabMenu() {
            const btn = document.getElementById('contactFab');
            const menu = document.getElementById('fabMenu');
            btn.classList.toggle('active');
            menu.classList.toggle('active');
        }

        // Close when clicking outside
        document.addEventListener('click', function (event) {
            const container = document.querySelector('.fab-container');
            const menu = document.getElementById('fabMenu');
            const btn = document.getElementById('contactFab');

            if (container && !container.contains(event.target)) {
                menu.classList.remove('active');
                btn.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>