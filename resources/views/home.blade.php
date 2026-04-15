@extends('layouts.app')

@section('title', 'Home - ' . App\Models\SiteSetting::getValue('company_name', 'Company Name'))

@section('content')
    <!-- Hero Section - True Full Screen -->
    @php
        $heroSection = App\Models\HomeSection::where('section', 'hero')->first();
        $logo = App\Models\SiteSetting::getLogo();
        $companyName = App\Models\SiteSetting::getCompanyName();
        $tagline = App\Models\SiteSetting::getValue('tagline', 'Best Patner For Your Product');
    @endphp
    
    <section class="relative flex items-center justify-center overflow-hidden hero-section min-h-screen h-[100dvh]">
        <!-- Background Elements -->
        @if($heroSection && $heroSection->background_video)
            <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="{{ asset('storage/' . $heroSection->background_video) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif($heroSection && $heroSection->background_image)
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $heroSection->background_image) }}')"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-green-500 to-green-400"></div>
        @endif
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        
        <!-- Gradient Overlay for Better Text Readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/30"></div>
        
        <!-- Content -->
        <div class="relative z-10 px-4 w-full max-w-4xl mx-auto hero-content flex justify-center items-center">
            <!-- Text Content Section - Center -->
            <div class="w-full text-center text-white">
                <!-- Industry Badge -->
                <div data-aos="fade-down" class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-6 border border-white/30">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-semibold tracking-wider">{{ __('Herba & Food Industry') }}</span>
                </div>

                <!-- Company Name -->
                <h1 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight uppercase">
                    {{ $companyName }}
                </h1>

                <!-- Tagline -->
                <p data-aos="fade-up" data-aos-delay="200" class="text-lg md:text-xl lg:text-2xl mb-8 leading-relaxed max-w-2xl mx-auto text-white/90">
                    {{ __('Best Partner for Your Product') }}
                </p>

                <!-- Buttons - Lebih Kecil -->
                <div data-aos="zoom-in" data-aos-delay="300" class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                        <a href="{{ route('industry') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-custom font-semibold transition-all duration-300 inline-flex items-center transform hover:scale-105 shadow-lg text-sm">
                            <span>{{ __('Explore Products') }}</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7-7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}" class="border-2 border-white hover:bg-white hover:text-green-600 text-white px-6 py-3 rounded-custom font-semibold transition-all duration-300 inline-flex items-center transform hover:scale-105 text-sm">
                            <span>{{ __('Contact Us') }}</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="text-white hover:text-green-300 transition duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7m7-7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Section Divider -->
    <div class="relative bg-gradient-to-r from-green-500 to-emerald-500">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-white/30"></div>
        </div>
        <div class="relative flex justify-center py-4">
            <span class="bg-green-500 px-6 py-2 text-white rounded-full text-sm font-semibold shadow-lg">{{ __('About Us') }}</span>
        </div>
    </div>

    <!-- About Section - Hijau Muda -->
    @php
        $aboutSection = App\Models\HomeSection::where('section', 'about')->first();
    @endphp
    
    @if($aboutSection && $aboutSection->is_active)
    <section id="about" class="py-20 bg-gradient-to-br from-green-50 to-emerald-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6 shadow-md">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ $aboutSection->title ?? 'About Our Company' }}</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Learn more about our journey and values</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="text-gray-600 leading-relaxed space-y-4 text-justify">
                        {!! $aboutSection->content ?? 'Company description goes here...' !!}
                    </div>
                    
                    <!-- Video Display -->
                    @if($aboutSection->video_url)
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Our Story in Video') }}</h3>
                        <div class="bg-gray-900 rounded-custom overflow-hidden shadow-lg about-video-container border-4 border-white">
                            <!-- Video content -->
                            @php
                                $videoUrl = $aboutSection->video_url;
                                $embedUrl = '';
                                
                                if (str_contains($videoUrl, 'youtube.com/embed/')) {
                                    $embedUrl = $videoUrl;
                                } elseif (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                                    $videoId = substr($videoUrl, strpos($videoUrl, 'v=') + 2);
                                    if (str_contains($videoId, '&')) {
                                        $videoId = substr($videoId, 0, strpos($videoId, '&'));
                                    }
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                    $videoId = substr($videoUrl, strpos($videoUrl, 'youtu.be/') + 9);
                                    if (str_contains($videoId, '?')) {
                                        $videoId = substr($videoId, 0, strpos($videoId, '?'));
                                    }
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                } elseif (str_contains($videoUrl, 'vimeo.com/')) {
                                    $videoId = substr($videoUrl, strpos($videoUrl, 'vimeo.com/') + 10);
                                    if (str_contains($videoId, '?')) {
                                        $videoId = substr($videoId, 0, strpos($videoId, '?'));
                                    }
                                    $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                                } elseif (str_contains($videoUrl, 'storage/')) {
                                    $embedUrl = null;
                                } else {
                                    $embedUrl = $videoUrl;
                                }
                            @endphp
                            
                            @if($embedUrl)
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe 
                                        src="{{ $embedUrl }}" 
                                        class="w-full h-64 md:h-80"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        loading="lazy">
                                    </iframe>
                                </div>
                            @elseif(str_contains($aboutSection->video_url, 'storage/'))
                                <div class="aspect-w-16 aspect-h-9">
                                    <video 
                                        class="w-full h-64 md:h-80" 
                                        controls 
                                        poster="{{ $aboutSection->background_image ? asset('storage/' . $aboutSection->background_image) : '' }}"
                                    >
                                        <source src="{{ asset('storage/' . $aboutSection->video_url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @else
                                <div class="w-full h-64 md:h-80 bg-green-100 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-green-600 text-lg">{{ __('Video Not Available') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="animate-fade-in">
                    @if($aboutSection->background_image)
                    <img src="{{ asset('storage/' . $aboutSection->background_image) }}" alt="About Us" class="w-full rounded-custom shadow-custom border-4 border-white">
                    @else
                    <div class="bg-green-100 rounded-custom shadow-custom w-full h-96 flex items-center justify-center border-4 border-white">
                        <span class="text-green-600 text-lg">About Us Image</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Section Divider -->
    <div class="relative bg-gradient-to-r from-emerald-500 to-green-600">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center">
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-8 text-white">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                        <span class="font-semibold text-sm md:text-base">About</span>
                    </div>
                    <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-200 rounded-full"></div>
                        <span class="font-semibold text-sm md:text-base">Vision & Mission</span>
                    </div>
                    <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-300 rounded-full"></div>
                        <span class="font-semibold text-sm md:text-base">Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Vision & Mission Section - Hijau Sedang -->
    @php
        $visionInfo = App\Models\CompanyInfo::where('page', 'vision')->first();
        $missionInfo = App\Models\CompanyInfo::where('page', 'mission')->first();
        $cultureInfo = App\Models\CompanyInfo::where('page', 'culture')->first();
    @endphp
    
    <section id="vision-mission" class="py-20 bg-gradient-to-br from-emerald-50 to-green-100">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6 shadow-md">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Landasan Perusahaan') }}</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Our guiding principles and future aspirations</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start mb-12">
                <!-- Vision -->
                <div class="animate-fade-in">
                    <div class="bg-white rounded-custom shadow-custom p-8 hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border-l-4 border-green-500">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $visionInfo ? $visionInfo->title : 'Visi' }}</h3>
                        </div>
                        <div class="text-gray-600 leading-relaxed text-lg text-justify">
                            @if($visionInfo)
                                {!! $visionInfo->description !!}
                            @else
                                <p>“Menjadi perusahaan Manufacture produk kesehatan terbaik berskala internasional yang terpercaya dalam menyediakan produk dengan kualitas terbaik, aman, halal serta ramah lingkungan melalui proses produksi yang dikelola secara profesional dengan inovasi berkelanjutan.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Mission -->
                <div class="animate-fade-in">
                    <div class="bg-white rounded-custom shadow-custom p-8 hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border-l-4 border-green-600">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $missionInfo ? $missionInfo->title : 'Misi' }}</h3>
                        </div>
                        <div class="text-gray-600 leading-relaxed text-lg text-justify">
                            @if($missionInfo)
                                {!! $missionInfo->description !!}
                            @else
                                <p>Beberapa dari Misi kami untuk menghasilkan produk yang berdaya guna dan bersaing secara Internasional :</p>
                            @endif
                        </div>
                        
                        <!-- Mission Points -->
                        <div class="mt-6 space-y-3">
                            @if($missionInfo && !empty($missionInfo->icons))
                                @foreach($missionInfo->icons as $index => $icon)
                                    <div class="flex items-start text-green-600">
                                        <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">{{ $index + 1 }}</span>
                                        <div class="text-gray-700 text-justify">
                                            @if(!empty($icon['title']))
                                                <strong>{{ $icon['title'] }}</strong> 
                                            @endif
                                            {!! $icon['description'] !!}
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(!$missionInfo)
                                <div class="flex items-start text-green-600">
                                    <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">1</span>
                                    <p class="text-gray-700 text-justify">Berkomitmen terhadap penyediaan produk berkualitas, aman, halal dan ramah lingkungan.</p>
                                </div>
                                <div class="flex items-start text-green-600">
                                    <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">2</span>
                                    <p class="text-gray-700 text-justify">Konsisten dalam penerapan sistem manajemen mutu (CPOTB, CPPOB, Halal Assurance System, ISO9001 & ISO22001) yang didukung oleh keunggulan teknologi dan kompetensi SDM yang terlibat.</p>
                                </div>
                                <div class="flex items-start text-green-600">
                                    <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">3</span>
                                    <p class="text-gray-700 text-justify">Meningkatkan kerja sama dalam organisasi secara profesional</p>
                                </div>
                                <div class="flex items-start text-green-600">
                                    <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">4</span>
                                    <p class="text-gray-700 text-justify">Continuous improvement di segala aspek.</p>
                                </div>
                                <div class="flex items-start text-green-600">
                                    <span class="min-w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-semibold mr-3 mt-0.5">5</span>
                                    <p class="text-gray-700 text-justify">Melakukan inovasi produk secara berkelanjutan dengan pembaharuan teknologi dan sesuai kebutuhan pasar.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
 
                 @if($cultureInfo)
                 <!-- Corporate Culture -->
                 <div class="animate-fade-in">
                     <div class="bg-white rounded-custom shadow-custom p-8 hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border-l-4 border-green-800">
                         <div class="flex items-center mb-6">
                             <div class="w-16 h-16 bg-green-800 rounded-full flex items-center justify-center mr-4 shadow-lg">
                                 @if($cultureInfo->banner_image)
                                     <img src="{{ asset('storage/'.$cultureInfo->banner_image) }}" class="w-10 h-10 object-contain rounded-full" alt="Culture">
                                 @else
                                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                     </svg>
                                 @endif
                             </div>
                             <h3 class="text-3xl font-bold text-gray-800">{{ $cultureInfo->title }}</h3>
                         </div>
                         
                         <div class="text-gray-600 leading-relaxed text-lg text-justify font-medium mb-8">
                             {!! $cultureInfo->description !!}
                         </div>
                         
                         @if(!empty($cultureInfo->icons))
                         <!-- Culture Points -->
                         <div class="space-y-4">
                             @foreach($cultureInfo->icons as $culturePoint)
                                 @php
                                     $initial = substr(strtoupper($culturePoint['title']), 0, 1);
                                 @endphp
                                 <div class="flex items-start">
                                     <span class="min-w-10 h-10 bg-green-800 text-white rounded-full flex items-center justify-center font-bold text-lg mr-4 shadow-md flex-shrink-0 mt-0.5">{{ $initial }}</span>
                                     <div class="text-gray-700 text-justify font-medium pt-1">
                                         {!! $culturePoint['description'] !!}
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                         @endif
                     </div>
                 </div>
                 @endif
            </div>



        </div>
    </section>

    <!-- Tagline Banner (Sebagai Batas Section Full Width) -->
    @php
        $taglineInfo = App\Models\CompanyInfo::where('page', 'tagline')->first();
    @endphp
    
    @if($taglineInfo || true) <!-- Akan kita tampilkan default statis jika kosong -->
    <div class="w-full relative overflow-hidden py-24 md:py-32">
        <!-- Background & Overlay -->
        @php
            $bgImage = ($taglineInfo && $taglineInfo->banner_image) ? asset('storage/'.$taglineInfo->banner_image) : asset('storage/company/factory-banner.jpg');
        @endphp
        <div class="absolute inset-0 bg-cover bg-center" style="background-color: #1f2937; background-image: url('{{ $bgImage }}');"></div>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
        
        <div class="relative px-6 text-center flex flex-col items-center justify-center">
            
            <div class="relative inline-block max-w-4xl mx-auto py-12 px-10 md:px-20">
                <!-- Custom Quote Borders -->
                <div class="absolute top-0 left-0 w-16 h-16 border-t-2 border-l-2 border-white/60 rounded-tl-xl"></div>
                <div class="absolute bottom-0 right-0 w-16 h-16 border-b-2 border-r-2 border-white/60 rounded-br-xl"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 border-b-2 border-l-2 border-white/60 rounded-bl-xl hidden md:block"></div>
                <div class="absolute top-0 right-0 w-16 h-16 border-t-2 border-r-2 border-white/60 rounded-tr-xl hidden md:block"></div>
                
                <!-- Quotation Marks -->
                <div class="absolute top-0 left-4 md:left-12 -translate-y-[45%] text-7xl md:text-8xl font-serif text-white/80 leading-none tracking-tighter" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">“</div>
                
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-widest uppercase text-white drop-shadow-xl" style="line-height: 1.4;">
                    @if($taglineInfo && $taglineInfo->title)
                        {!! nl2br(e($taglineInfo->title)) !!}
                    @else
                        THINK BIG,<br/>SCALE UP!
                    @endif
                </h2>
                
                <div class="absolute bottom-0 right-4 md:right-12 translate-y-[35%] text-7xl md:text-8xl font-serif text-white/80 leading-none rotate-180 tracking-tighter" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">“</div>
            </div>

        </div>
    </div>
    @endif

    <!-- Services Section - Layanan Unggulan Kami -->
    @php
        $services = App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
    @endphp

    @if($services->count() > 0)
    <!-- Section Divider Layanan -->
    <div class="relative bg-gradient-to-r from-emerald-600 to-green-700">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-3 text-white bg-black/20 px-8 py-3.5 rounded-full shadow-lg">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="font-semibold text-base md:text-lg tracking-wide text-center">{{ __('Layanan Unggulan Kami') }}</span>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- JSON data untuk modal (diakses JS) -->
    <script id="services-data" type="application/json">
        [
        @foreach($services as $idx => $service)
        @php
            $subContentsWithUrls = collect($service->sub_contents ?? [])->map(function($sub) {
                if (!empty($sub['image'])) {
                    $sub['image'] = asset('storage/' . $sub['image']);
                }
                return $sub;
            })->values()->toArray();
        @endphp
        {
            "id": {{ $service->id }},
            "title": @json($service->title),
            "description": @json($service->description ?? ''),
            "image": @json($service->image ? asset('storage/' . $service->image) : null),
            "sub_contents": @json($subContentsWithUrls)
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
        ]
    </script>

    <!-- Modal Detail Layanan -->
    <div id="service-modal"
         class="fixed inset-0 z-[999] hidden items-center justify-center"
         role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeServiceModal()"></div>
        <!-- Panel: lebar 60vw, tinggi maks 80vh, benar-benar di tengah -->
        <div id="modal-panel"
             class="relative bg-white rounded-2xl shadow-2xl overflow-y-auto
                    border-t-4 border-green-500 transform transition-all duration-300 scale-95 opacity-0"
             style="width:60vw; max-width:900px; min-width:320px; max-height:80vh;">
            <!-- Close button -->
            <button onclick="closeServiceModal()"
                    class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full
                           bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 transition-all duration-200"
                    aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Konten modal -->
            <div id="modal-body" class="p-8"></div>
        </div>
    </div>

    <section id="services" class="py-20 bg-gradient-to-br from-green-50 to-emerald-100">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-3">{{ __('Layanan Unggulan Kami') }}</h2>
                <div class="w-16 h-1 bg-amber-400 mx-auto mb-5"></div>
                <p class="text-gray-600 max-w-2xl mx-auto text-base leading-relaxed">
                    {{ __('Kami menawarkan berbagai solusi manufaktur kemasan yang dirancang khusus untuk memenuhi standar industri tertinggi.') }}
                </p>
            </div>

            <!-- Grid 3 kolom light mint cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="service-card group bg-emerald-50 rounded-2xl p-7
                            cursor-pointer select-none transition-all duration-300 text-center
                            hover:-translate-y-2 hover:shadow-xl hover:bg-white
                            border border-emerald-200 hover:border-green-400/60 shadow-sm"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}"
                     onclick="openServiceModal({{ $service->id }})"
                     role="button"
                     tabindex="0"
                     onkeypress="if(event.key==='Enter') openServiceModal({{ $service->id }})">

                    {{-- Icon / Gambar di tengah atas --}}
                    <div class="flex justify-center mb-5">
                        @if($service->image)
                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-emerald-100
                                    group-hover:scale-110 transition-transform duration-300 shadow-sm border border-emerald-200">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center
                                    group-hover:scale-110 transition-transform duration-300 shadow-sm border border-emerald-200">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h3 class="text-gray-800 font-bold text-base leading-snug mb-3">
                        {{ $service->title }}
                    </h3>

                    {{-- Deskripsi singkat --}}
                    @if($service->description)
                    <p class="text-teal-700 text-sm leading-relaxed line-clamp-5">
                        {{ Str::limit(strip_tags($service->description), 150) }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Section Bahan yang Kami Gunakan -->
    @php
        $materials = App\Models\Material::where('is_active', true)->orderBy('sort_order')->get();
    @endphp

    @if($materials->count() > 0)
    <!-- Section Divider Bahan -->
    <div class="relative bg-gradient-to-r from-green-700 to-emerald-700">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-3 text-white bg-black/20 px-8 py-3.5 rounded-full shadow-lg">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <span class="font-semibold text-base md:text-lg tracking-wide text-center">{{ __('Produk yang Kami Hasilkan') }}</span>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <section id="materials" class="py-14 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">

            {{-- Section Header --}}
            <div class="text-center mb-10" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-green-700 mb-3">{{ __('Produk yang Kami Hasilkan') }}</h2>
                <div class="w-14 h-1 bg-green-600 mx-auto rounded-full"></div>
            </div>

            {{-- Kategori Loop --}}
            <div class="space-y-10">
                @foreach($materials as $material)
                @php
                    $itemCount = count($material->items ?? []);
                    $useLargeCards = $itemCount <= 5;
                @endphp
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">

                    {{-- Category Header --}}
                    <div class="flex items-center gap-2 mb-5">
                        <span class="text-green-700 flex-shrink-0">
                            @if($material->image)
                                <img src="{{ asset('storage/' . $material->image) }}"
                                     alt="{{ $material->title }}"
                                     class="w-6 h-6 object-contain">
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            @endif
                        </span>
                        <h3 class="text-base font-bold text-gray-800">{{ $material->title }}</h3>
                    </div>

                    @if(!empty($material->items))

                    @if($useLargeCards)
                    {{-- ===== LARGE CARD GRID (<=5 items) ===== --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($material->items as $item)
                        <div class="group bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100
                                    hover:shadow-md hover:border-green-200 transition-all duration-300">
                            <div class="aspect-square overflow-hidden bg-gray-50">
                                @if(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     alt="{{ $item['name'] ?? '' }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="px-3 py-2.5">
                                @if(!empty($item['name']))
                                <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $item['name'] }}</p>
                                @endif
                                @if(!empty($item['description']))
                                <span class="inline-block mt-1.5 bg-green-50 text-green-700 border border-green-200
                                             text-xs px-2 py-0.5 rounded-full leading-tight">
                                    {{ Str::limit(strip_tags($item['description']), 28) }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    {{-- ===== HORIZONTAL THUMBNAIL GRID (>5 items) ===== --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($material->items as $item)
                        <div class="group flex items-center gap-3 bg-white rounded-xl p-3
                                    shadow-sm border border-gray-100
                                    hover:shadow-md hover:border-green-200 transition-all duration-300">
                            <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50 border border-gray-100">
                                @if(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     alt="{{ $item['name'] ?? '' }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                @if(!empty($item['name']))
                                <p class="text-sm font-semibold text-gray-800 leading-tight truncate">{{ $item['name'] }}</p>
                                @endif
                                @if(!empty($item['description']))
                                <p class="text-xs text-gray-500 mt-0.5 leading-tight">
                                    {{ Str::limit(strip_tags($item['description']), 32) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @endif
                </div>

                @if(!$loop->last)
                <hr class="border-gray-200">
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Section Mengapa Harus Kami? -->
    @php
        $advantages = App\Models\Advantage::active()->orderBy('sort_order')->get();
        $maklonSteps = App\Models\MaklonFlowStep::active()->ordered()->get();
    @endphp

    @if($advantages->count() > 0)
    <!-- Section Divider Mengapa Harus Kami -->
    <div class="relative bg-gradient-to-r from-emerald-600 to-green-700">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-3 text-white bg-black/20 px-8 py-3.5 rounded-full shadow-lg">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="font-semibold text-base md:text-lg tracking-wide text-center">{{ __('Mengapa Memilih Kami?') }}</span>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <section id="why-choose-us" class="py-16 bg-white relative">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">{{ __('Mengapa Harus Kami?') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
                    {{ __('Dedikasi kami pada kualitas dan inovasi menjadikan kami mitra manufaktur pilihan untuk pertumbuhan brand Anda.') }}
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($advantages as $adv)
                <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 hover:shadow-[0_8px_30px_rgb(46,139,87,0.08)] transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center mb-5 border border-green-100">
                        @if($adv->icon_image)
                            <img src="{{ asset('storage/' . $adv->icon_image) }}" alt="{{ $adv->title }}" class="w-6 h-6 object-contain">
                        @else
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $adv->title }}</h3>
                    @if($adv->description)
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $adv->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <div class="relative bg-gradient-to-r from-green-600 to-emerald-600">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-3 rounded-full bg-black/20 px-8 py-3.5 text-white shadow-lg">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path>
                    </svg>
                    <span class="text-center text-base font-semibold tracking-wide md:text-lg">{{ __('Alur Maklon') }}</span>
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Alur Maklon -->
    <section id="maklon-flow" class="py-16 bg-emerald-50 relative">
        @php
            $fallbackMaklonSteps = collect([
                ['title' => __('Konsultasi & briefing'), 'description' => __('Bersama Anda kami menentukan spesifikasi produk, target pasar, dan kebutuhan manufaktur.')],
                ['title' => __('Perencanaan produksi'), 'description' => __('Mengatur jadwal, kapasitas produksi, bahan baku, serta dokumentasi teknis.')],
                ['title' => __('Sample & quality control'), 'description' => __('Produksi sample, pengujian mutu, dan persetujuan sebelum produksi massal.')],
                ['title' => __('Produksi massal'), 'description' => __('Produksi berjalan dengan kontrol kualitas dan pengawasan setiap tahap.')],
                ['title' => __('Pengiriman & dukungan'), 'description' => __('Paket dikirim, dilacak, dan kami siap mendukung layanan purna jual.')],
            ]);

            $flowSteps = $maklonSteps->isNotEmpty()
                ? $maklonSteps->map(fn ($step) => [
                    'title' => $step->title,
                    'description' => trim(strip_tags(html_entity_decode((string) $step->description))),
                ])->values()
                : $fallbackMaklonSteps;
        @endphp
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">{{ __('Alur Maklon') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
                    {{ __('Langkah-langkah kerjasama maklon kami agar proses produksi berjalan lancar dan sesuai kebutuhan brand Anda.') }}
                </p>
            </div>

            <div class="maklon-flow-shell relative overflow-hidden rounded-[2rem] border border-emerald-100 bg-white p-6 md:p-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]" data-aos="fade-up">
                <div class="pointer-events-none absolute inset-x-6 top-6 h-28 rounded-full bg-[radial-gradient(circle_at_top,rgba(16,185,129,0.16),transparent_60%)] blur-2xl"></div>
                <div class="relative mb-10 flex flex-wrap items-center justify-center gap-3 text-center md:mb-14">
                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-700">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ __('Proses berjalan terarah') }}
                    </span>
                    <span class="text-sm text-gray-500">{{ __('Setiap tahap dirancang berurutan agar brand Anda bergerak dari ide ke produk jadi dengan kontrol yang jelas.') }}</span>
                </div>

                <div class="maklon-road relative mx-auto max-w-5xl">
                    <div class="maklon-road-track absolute bottom-0 left-6 top-0 w-[4px] overflow-hidden rounded-full md:left-1/2 md:-translate-x-1/2"></div>
                    <div class="maklon-road-runner absolute left-6 top-0 h-16 w-16 md:left-1/2 md:-translate-x-1/2"></div>

                    @foreach($flowSteps as $index => $step)
                        <article class="maklon-road-step relative grid grid-cols-[3rem_1fr] items-start gap-4 pb-8 md:grid-cols-2 md:gap-12 md:pb-10" data-aos="{{ $index % 2 === 0 ? 'fade-right' : 'fade-left' }}" data-aos-delay="{{ 120 + ($index * 110) }}">
                            <div class="maklon-road-node absolute left-6 top-6 h-5 w-5 -translate-x-1/2 rounded-full border-[5px] border-white bg-emerald-500 shadow-[0_0_0_8px_rgba(16,185,129,0.15)] md:left-1/2"></div>

                            <div class="col-start-2 {{ $index % 2 === 0 ? 'md:col-start-1 md:pr-20 md:text-right' : 'md:col-start-2 md:pl-20' }}">
                                <div class="maklon-flow-card group relative overflow-hidden rounded-[1.75rem] border border-emerald-100 bg-gradient-to-br from-white via-emerald-50 to-green-50 p-6 shadow-[0_18px_40px_rgba(15,23,42,0.08)] transition duration-500 hover:-translate-y-1 hover:shadow-[0_22px_50px_rgba(16,185,129,0.18)]" style="--step-delay: {{ number_format($index * 0.45, 2, '.', '') }}s;">
                                    <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-emerald-200/40 blur-2xl transition duration-500 group-hover:scale-125"></div>
                                    <div class="relative flex {{ $index % 2 === 0 ? 'md:justify-end' : 'md:justify-start' }}">
                                        <span class="inline-flex items-center gap-3 rounded-full bg-emerald-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-50 shadow-lg shadow-emerald-900/20">
                                            <span class="text-emerald-200">{{ __('Step') }}</span>
                                            <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        </span>
                                    </div>
                                    <h4 class="relative mt-5 text-xl font-bold text-green-900">{{ $step['title'] }}</h4>
                                    <p class="relative mt-3 text-sm leading-7 text-gray-600">{{ $step['description'] }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Section Divider Produk -->
    <div class="relative bg-gradient-to-r from-green-600 to-emerald-600">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <div class="inline-flex flex-wrap items-center justify-center gap-3 text-white bg-black/20 px-8 py-3.5 rounded-full shadow-lg">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <span class="font-semibold text-base md:text-lg tracking-wide text-center">{{ __('Temukan Produk Inovatif Kami') }}</span>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section - Hijau Tua -->
    @php
        $productsSection = App\Models\HomeSection::where('section', 'products')->first();
        $featuredProducts = App\Models\Product::featured()->orderBy('order')->get();
    @endphp
    
    @if($productsSection && $productsSection->is_active)
    <section id="products" class="py-20 bg-gradient-to-br from-green-100 to-emerald-200">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-200 rounded-full mb-6 shadow-md">
                    <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ $productsSection->title ?? 'Our Products' }}</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto mb-6"></div>
                <div class="text-xl text-gray-600 max-w-2xl mx-auto">{!! html_entity_decode($productsSection->content ?? 'Discover our innovative product portfolio') !!}</div>
            </div>
            
            @if($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-custom shadow-custom overflow-hidden hover:shadow-xl transition duration-300 animate-fade-in transform hover:-translate-y-1 border-t-4 border-green-600">
                        <div class="h-48 overflow-hidden">
                            @if($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                            @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                            @else
                            <div class="w-full h-full bg-green-100 flex items-center justify-center">
                                <span class="text-green-600">Product Image</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold mb-3">{{ $product->category }}</span>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 text-justify">{{ $product->name }}</h3>
                            
                            <a href="{{ $product->slug ? route('products.detail', $product->slug) : '#' }}" class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center">
                                {{ __('Learn More') }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-12 animate-fade-in">
                    <a href="{{ route('industry') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-custom font-semibold transition duration-300 inline-block transform hover:scale-105 shadow-lg">
                        {{ __('View All Products') }}
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-green-50 rounded-custom p-8 max-w-md mx-auto border-2 border-green-300">
                        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1m4 0h-4"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('No Products Available') }}</h3>
                        <p class="text-gray-600">{{ __('Check back later for our featured products.') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Partner/Client Marquee Section -->
    @php
        $partners = App\Models\Partner::active()->orderBy('sort_order')->get();
    @endphp

    @if($partners->count() > 0)
    <div class="bg-green-50 py-12 sm:py-16 overflow-hidden relative z-10" data-aos="fade-up">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <h3 class="text-sm md:text-lg font-bold tracking-[0.2em] uppercase text-green-700">
                {{ __('TELAH DIPERCAYA OLEH PERUSAHAAN TERNAMA') }}
            </h3>
        </div>

        <div class="marquee-wrapper items-center">
            @php
                $repeatCount = 4;
            @endphp
            @for ($i = 0; $i < $repeatCount; $i++)
            <div class="animate-marquee flex items-center gap-24 sm:gap-40 px-12 sm:px-20" {!! $i > 0 ? 'aria-hidden="true"' : '' !!}>
                @foreach($partners as $partner)
                <div class="flex-shrink-0 transition-all duration-500 hover:scale-110">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" 
                         class="h-14 sm:h-20 md:h-24 w-auto object-contain transition-all duration-300">
                </div>
                @endforeach
            </div>
            @endfor
        </div>
    </div>
    @endif

    <!-- Section Divider -->
    <div class="relative bg-gradient-to-r from-emerald-600 to-green-700 py-12">
        <div class="container mx-auto px-4 text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-white opacity-90" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
            </svg>
            <p class="text-xl md:text-2xl font-light italic text-white max-w-3xl mx-auto leading-relaxed">
                "{{ __("Innovation and quality are at the heart of everything we do. We're committed to delivering products that make a difference.") }}"
            </p>
            <div class="mt-6 w-16 h-1 bg-white/80 mx-auto rounded-full"></div>
        </div>
    </div>
    @endif

    <!-- Research Section - Hijau Gelap -->
    @php
        $researchSection = App\Models\HomeSection::where('section', 'research')->first();
    @endphp
    
    @if($researchSection && $researchSection->is_active)
    <section id="research" class="py-20 bg-gradient-to-br from-emerald-100 to-green-200">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-300 rounded-full mb-6 shadow-md">
                    <svg class="w-8 h-8 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ $researchSection->title ?? 'Research & Innovation' }}</h2>
                <div class="w-24 h-1 bg-green-700 mx-auto mb-6"></div>
                <div class="text-xl text-gray-600 max-w-2xl mx-auto">{!! html_entity_decode($researchSection->content ?? 'Stay updated with our latest research and innovations') !!}</div>
            </div>
            
            <div class="max-w-4xl mx-auto animate-fade-in">
                @if($researchSection->video_url)
                    <div class="bg-gray-900 rounded-custom overflow-hidden shadow-custom research-video-container border-4 border-white shadow-2xl">
                        <!-- Video content -->
                        @php
                            $videoUrl = $researchSection->video_url;
                            $embedUrl = '';
                            
                            if (str_contains($videoUrl, 'youtube.com/embed/')) {
                                $embedUrl = $videoUrl;
                            } elseif (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                                $videoId = substr($videoUrl, strpos($videoUrl, 'v=') + 2);
                                if (str_contains($videoId, '&')) {
                                    $videoId = substr($videoId, 0, strpos($videoId, '&'));
                                }
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                $videoId = substr($videoUrl, strpos($videoUrl, 'youtu.be/') + 9);
                                if (str_contains($videoId, '?')) {
                                    $videoId = substr($videoId, 0, strpos($videoId, '?'));
                                }
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            } elseif (str_contains($videoUrl, 'vimeo.com/')) {
                                $videoId = substr($videoUrl, strpos($videoUrl, 'vimeo.com/') + 10);
                                if (str_contains($videoId, '?')) {
                                    $videoId = substr($videoId, 0, strpos($videoId, '?'));
                                }
                                $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                            } elseif (str_contains($videoUrl, 'storage/')) {
                                $embedUrl = null;
                            } else {
                                $embedUrl = $videoUrl;
                            }
                        @endphp
                        
                        @if($embedUrl)
                            <iframe 
                                src="{{ $embedUrl }}?rel=0&modestbranding=1" 
                                class="w-full h-64 md:h-96 lg:h-[500px]"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        @elseif(str_contains($researchSection->video_url, 'storage/'))
                            <div class="aspect-w-16 aspect-h-9">
                                <video 
                                    class="w-full h-64 md:h-96 lg:h-[500px]" 
                                    controls 
                                    poster="{{ $researchSection->background_image ? asset('storage/' . $researchSection->background_image) : '' }}"
                                >
                                    <source src="{{ asset('storage/' . $researchSection->video_url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <div class="w-full h-64 md:h-96 lg:h-[500px] bg-green-100 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-green-600 text-lg">Research Video Coming Soon</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                <div class="bg-green-100 rounded-custom shadow-custom w-full h-64 md:h-96 lg:h-[500px] flex items-center justify-center border-4 border-white">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-green-600 text-lg">Research Video Coming Soon</p>
                        <p class="text-green-500 text-sm mt-2">We're working on exciting new research content</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Final Section Divider -->
    <div class="relative bg-gradient-to-r from-green-700 to-emerald-800 py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="inline-flex items-center space-x-6 text-white">
                    <div class="w-4 h-4 bg-green-300 rounded-full animate-pulse"></div>
                    <div class="w-4 h-4 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                    <div class="w-4 h-4 bg-green-500 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                    <div class="w-4 h-4 bg-green-600 rounded-full animate-pulse" style="animation-delay: 0.6s"></div>
                    <div class="w-4 h-4 bg-green-700 rounded-full animate-pulse" style="animation-delay: 0.8s"></div>
                </div>
                <p class="text-white/80 mt-4 font-semibold">{{ __('Thank you for visiting our website') }}</p>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Hero Section Full Screen Fix */
    .hero-section {
        min-height: 100vh !important;
        height: 100vh !important;
    }
    
    /* Smooth transitions for all elements */
    .animate-fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
    
    .animate-fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Custom scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom border radius */
    .rounded-custom {
        border-radius: 12px;
    }
    
    /* Custom shadows */
    .shadow-custom {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .maklon-flow-shell {
        background-image:
            linear-gradient(135deg, rgba(236, 253, 245, 0.86), rgba(255, 255, 255, 0.98)),
            radial-gradient(circle at top right, rgba(16, 185, 129, 0.18), transparent 30%);
    }

    .maklon-road {
        padding-top: 0.5rem;
    }

    .maklon-road-track {
        background: linear-gradient(180deg, rgba(52, 211, 153, 0.18), rgba(5, 150, 105, 0.5), rgba(6, 95, 70, 0.2));
    }

    .maklon-road-track::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(
            180deg,
            rgba(255, 255, 255, 0.95) 0,
            rgba(255, 255, 255, 0.95) 14px,
            transparent 14px,
            transparent 28px
        );
        opacity: 0.55;
    }

    .maklon-road-runner::before,
    .maklon-road-runner::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        border-radius: 9999px;
        transform: translateX(-50%);
    }

    .maklon-road-runner::before {
        height: 3.5rem;
        width: 3.5rem;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.9) 0%, rgba(16, 185, 129, 0.85) 45%, rgba(5, 150, 105, 0) 78%);
        filter: blur(1px);
        animation: maklon-run 8s linear infinite;
    }

    .maklon-road-runner::after {
        height: 1rem;
        width: 1rem;
        top: 1.2rem;
        background: white;
        box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.22);
        animation: maklon-run-dot 8s linear infinite;
    }

    .maklon-flow-card {
        animation: maklon-card-float 5.5s ease-in-out infinite;
        animation-delay: var(--step-delay);
    }

    .maklon-flow-card::after {
        content: '';
        position: absolute;
        inset: auto 1.5rem 1rem;
        height: 1px;
        background: linear-gradient(90deg, rgba(16, 185, 129, 0), rgba(16, 185, 129, 0.38), rgba(16, 185, 129, 0));
    }

    @keyframes maklon-run {
        0% {
            transform: translate(-50%, 0);
            opacity: 0;
        }
        8% {
            opacity: 1;
        }
        92% {
            opacity: 1;
        }
        100% {
            transform: translate(-50%, calc(100% - 3.5rem));
            opacity: 0;
        }
    }

    @keyframes maklon-run-dot {
        0% {
            transform: translate(-50%, 0) scale(0.9);
            opacity: 0;
        }
        12% {
            opacity: 1;
        }
        50% {
            transform: translate(-50%, calc(50% - 0.5rem)) scale(1.05);
        }
        100% {
            transform: translate(-50%, calc(100% - 1rem)) scale(0.92);
            opacity: 0;
        }
    }

    @keyframes maklon-card-float {
        0%,
        100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .hero-section {
            height: 100dvh !important;
            min-height: 100dvh !important;
        }
        
        .hero-content h1 {
            font-size: 2rem !important;
            line-height: 1.2 !important;
        }
        
        .hero-content p {
            font-size: 1rem !important;
        }

        .hero-content .inline-flex {
            margin-bottom: 1rem !important;
        }

        /* Adjust section dividers for mobile */
        .grid-cols-1 .flex-row {
            flex-direction: column !important;
            gap: 1rem !important;
        }

        .maklon-road-runner {
            left: 1.5rem;
            transform: translateX(-50%);
        }

        .maklon-road-step:last-child {
            padding-bottom: 0;
        }

        .maklon-flow-card {
            animation-duration: 4.8s;
        }

    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer for fade-in animations
        const fadeElements = document.querySelectorAll('.animate-fade-in');
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { 
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        fadeElements.forEach(element => {
            fadeInObserver.observe(element);
        });

        // Hero section height adjustment
        function setHeroHeight() {
            const hero = document.querySelector('.hero-section');
            if (hero) {
                const windowHeight = window.innerHeight;
                hero.style.height = windowHeight + 'px';
                
                const absoluteChildren = hero.querySelectorAll('.absolute');
                absoluteChildren.forEach(child => {
                    child.style.height = windowHeight + 'px';
                });
            }
        }

        setHeroHeight();
        window.addEventListener('resize', setHeroHeight);
        window.addEventListener('orientationchange', setHeroHeight);
    });

    // ============================================================
    // Modal Layanan Unggulan
    // ============================================================
    var _servicesData = [];
    try {
        var _el = document.getElementById('services-data');
        if (_el) _servicesData = JSON.parse(_el.textContent);
    } catch(e) {}

    function openServiceModal(serviceId) {
        var svc = _servicesData.find(function(s) { return s.id === serviceId; });
        if (!svc) return;

        var body = document.getElementById('modal-body');
        if (!body) return;

        // Bangun HTML konten modal
        var html = '';

        // Header: image jika ada
        if (svc.image) {
            html += '<div class="-mx-8 -mt-8 mb-6 h-48 overflow-hidden rounded-t-2xl">' +
                    '<img src="' + svc.image + '" alt="' + _esc(svc.title) + '" class="w-full h-full object-cover">' +
                    '</div>';
        }

        // Judul
        html += '<div class="flex items-start gap-3 mb-5">' +
                '<div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">' +
                '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>' +
                '</svg></div>' +
                '<h2 id="modal-title" class="text-2xl font-bold text-gray-800 leading-snug">' + _esc(svc.title) + '</h2>' +
                '</div>';

        // Deskripsi utama
        if (svc.description) {
            html += '<div class="text-gray-600 text-sm leading-relaxed mb-5 prose prose-sm max-w-none">' + svc.description + '</div>';
        }

        // Sub-konten
        if (svc.sub_contents && svc.sub_contents.length > 0) {
            html += '<div class="border-t border-gray-100 pt-5">' +
                    '<h3 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-3">Detail Layanan</h3>' +
                    '<div class="space-y-3">';

            svc.sub_contents.forEach(function(sub) {
                html += '<div class="bg-green-50 border border-green-200 rounded-xl overflow-hidden">';
                if (sub.image) {
                    html += '<div class="h-28 overflow-hidden">' +
                            '<img src="' + sub.image + '" alt="' + _esc(sub.title || '') + '" class="w-full h-full object-cover">' +
                            '</div>';
                }
                html += '<div class="px-4 py-3">';
                if (sub.title) {
                    html += '<p class="font-semibold text-green-800 text-sm flex items-center gap-1.5 mb-1">' +
                            '<svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>' +
                            '</svg>' + _esc(sub.title) + '</p>';
                }
                if (sub.description) {
                    html += '<div class="text-gray-500 text-xs leading-relaxed pl-5 prose prose-sm max-w-none">' + sub.description + '</div>';
                }
                html += '</div></div>';
            });

            html += '</div></div>';
        }

        body.innerHTML = html;

        // Tampilkan modal
        var modal = document.getElementById('service-modal');
        var panel = document.getElementById('modal-panel');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                panel.classList.remove('scale-95', 'opacity-0');
                panel.classList.add('scale-100', 'opacity-100');
            });
        });
    }

    function closeServiceModal() {
        var modal = document.getElementById('service-modal');
        var panel = document.getElementById('modal-panel');
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');
        setTimeout(function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
            document.getElementById('modal-body').innerHTML = '';
        }, 280);
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeServiceModal();
    });

    // Helper: escape HTML untuk keamanan
    function _esc(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
</script>
@endpush