# Hero Banner Component - Panduan Penggunaan

## 📖 Overview

Komponen `hero-banner` adalah komponen Blade yang dapat digunakan untuk membuat banner hero yang menarik dengan animasi ringan dan dapat disesuaikan penuh dari admin panel Filament.

## ✨ Fitur

- ✅ **Fully Customizable** - Semua aspek dapat disesuaikan melalui props
- ✅ **Admin Panel Integration** - Terintegrasi dengan HomeSection model di Filament
- ✅ **Multiple Animations** - Fade, Slide Up, Slide Down, Zoom
- ✅ **Lightweight** - Animasi CSS3 yang ringan dan performant
- ✅ **Responsive** - Mobile-first design
- ✅ **Parallax Effect** - Background parallax saat scroll (optional)
- ✅ **Accessibility** - Mendukung `prefers-reduced-motion`
- ✅ **Multiple Background Types** - Image, Video, atau Gradient
- ✅ **Scroll Indicator** - Animasi scroll indicator dengan smooth scroll

## 🎨 Props yang Tersedia

| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `title` | string | 'Welcome' | Judul utama banner |
| `subtitle` | string | '' | Subjudul banner |
| `content` | string/HTML | '' | Konten tambahan (mendukung HTML) |
| `backgroundImage` | string | null | Path gambar background |
| `backgroundVideo` | string | null | Path video background |
| `height` | string | 'medium' | Tinggi banner: `small`, `medium`, `large`, `full` |
| `overlay` | string | 'dark' | Overlay style: `dark`, `light`, `gradient`, `none` |
| `alignment` | string | 'center' | Alignment konten: `center`, `left`, `right` |
| `animation` | string | 'fade' | Jenis animasi: `fade`, `slide-up`, `slide-down`, `zoom`, `none` |
| `showScrollIndicator` | boolean | false | Tampilkan scroll indicator |
| `scrollTarget` | string | '#content' | Target scroll indicator |
| `ctaText` | string | null | Text untuk CTA button |
| `ctaUrl` | string | null | URL untuk CTA button |

## 📝 Contoh Penggunaan

### 1. Basic Usage (Gradient Background)
```blade
<x-hero-banner
    title="Our Products"
    subtitle="Discover our high-quality product portfolio"
/>
```

### 2. With Custom Background Image
```blade
<x-hero-banner
    title="Welcome to Our Company"
    subtitle="Innovation meets excellence"
    backgroundImage="banners/hero-bg.jpg"
    height="large"
    overlay="gradient"
    animation="slide-up"
/>
```

### 3. With Video Background
```blade
<x-hero-banner
    title="Experience Innovation"
    subtitle="Watch our story unfold"
    backgroundVideo="videos/company-intro.mp4"
    height="full"
    overlay="dark"
    :showScrollIndicator="true"
    scrollTarget="#about"
/>
```

### 4. With CTA Button
```blade
<x-hero-banner
    title="Our Facilities"
    subtitle="State-of-the-art infrastructure"
    backgroundImage="facilities/main-facility.jpg"
    height="medium"
    animation="fade"
    ctaText="Explore Facilities"
    ctaUrl="#facilities"
/>
```

### 5. Integrated with HomeSection Model
```blade
@php
    $hero = App\Models\HomeSection::where('section', 'products')
                ->where('is_active', true)
                ->first();
@endphp

@if($hero && $hero->background_image)
    <x-hero-banner
        :title="$hero->title ?? 'Our Products'"
        :subtitle="!$hero->content ? 'Discover our portfolio' : ''"
        :content="$hero->content ?? ''"
        :backgroundImage="$hero->background_image"
        height="medium"
        overlay="dark"
        animation="slide-up"
        :showScrollIndicator="true"
        scrollTarget="#products"
        ctaText="Explore Products"
        ctaUrl="#products"
    />
@else
    <x-hero-banner
        title="Our Products"
        subtitle="Discover our portfolio"
        height="medium"
    />
@endif
```

### 6. With Custom Slot Content
```blade
<x-hero-banner
    title="Join Our Team"
    subtitle="We're hiring!"
    backgroundImage="careers/office.jpg"
    height="large"
    animation="zoom"
>
    <div class="flex gap-4 justify-center mt-6">
        <a href="/careers" class="btn-primary">View Openings</a>
        <a href="/about" class="btn-secondary">Learn More</a>
    </div>
</x-hero-banner>
```

## 🎛️ Height Options

- **`small`**: `py-12 md:py-16` - Untuk banner sederhana (halaman detail, list)
- **`medium`**: `py-20 md:py-24` - Untuk banner standar (halaman kategori)
- **`large`**: `py-32 md:py-40` - Untuk banner prominan (landing pages)
- **`full`**: `min-h-screen` - Untuk hero section full screen (homepage)

## 🎨 Overlay Options

- **`dark`**: Overlay hitam 50% opacity - cocok untuk gambar terang
- **`light`**: Overlay putih 30% opacity - cocok untuk gambar gelap
- **`gradient`**: Gradient dari hitam ke transparan - modern look
- **`none`**: Tanpa overlay - untuk gambar yang sudah optimal

## ⚡ Animation Types

1. **`fade`**: Simple fade in dengan sedikit slide up
2. **`slide-up`**: Slide dari bawah
3. **`slide-down`**: Slide dari atas
4. **`zoom`**: Zoom in effect
5. **`none`**: Tanpa animasi

## 🎯 Best Practices

### Image Optimization
```
Recommended sizes:
- Full height hero: 1920x1080px
- Medium banner: 1920x600px
- Small banner: 1920x400px

Format: WebP or optimized JPG
```

### Video Optimization
```
Format: MP4 (H.264)
Max duration: 10-15 seconds (looping)
Max size: 5MB
Resolution: 1920x1080px
```

### Performance Tips
1. Compress images/videos sebelum upload
2. Gunakan `height="small"` untuk halaman detail
3. Gunakan `animation="none"` jika performa prioritas
4. Video background hanya untuk hero utama (homepage)

## 🔧 Cara Mengatur dari Admin Panel

### 1. Login ke Filament Admin Panel
```
URL: /admin
```

### 2. Navigasi ke "Home Sections"
```
Sidebar → Site Management → Home Sections
```

### 3. Buat/Edit Section
Available sections:
- `hero` - Homepage hero
- `products` - Products page banner
- `facilities` - Facilities page banner
- `articles` - Articles page banner
- `about` - About page banner
- `research` - Research page banner

### 4. Upload Assets
- **Background Image**: Klik "Choose file" di field "Background Image"
- **Background Video**: Klik "Choose file" di field "Background Video"
- **Title**: Masukkan judul banner
- **Content**: Rich text editor untuk konten tambahan
- **Is Active**: Toggle untuk mengaktifkan/nonaktifkan

### 5. Save & Preview
Klik "Save" dan buka halaman terkait untuk melihat hasilnya.

## 🎬 Animasi Performance

Semua animasi menggunakan CSS3 transforms dan opacity yang di-optimasi untuk GPU acceleration:

```css
/* Hardware accelerated */
transform: translateY() scale()
opacity: 0 to 1

/* Respects user preferences */
@media (prefers-reduced-motion: reduce) {
    /* Animations disabled */
}
```

## 📱 Responsive Behavior

- **Desktop**: Full animations, parallax effect
- **Tablet**: Simplified animations
- **Mobile**: Minimal animations, optimized text sizes
- **Reduced Motion**: All animations disabled

## 🔍 Troubleshooting

### Banner tidak muncul
- Pastikan `is_active = true` di database
- Cek path gambar/video di storage
- Jalankan `php artisan storage:link`

### Animasi tidak smooth
- Pastikan browser support CSS3 transforms
- Cek console browser untuk errors
- Test di browser lain

### Background tidak penuh
- Pastikan parent container tidak memiliki overflow hidden
- Cek aspect ratio gambar
- Gunakan gambar dengan resolusi tinggi

## 📚 Related Files

```
Component: resources/views/components/hero-banner.blade.php
Model: app/Models/HomeSection.php
Resource: app/Filament/Resources/HomeSectionResource.php
Migration: database/migrations/*_create_home_sections_table.php
```

## 🚀 Future Enhancements

- [ ] Ken Burns effect untuk background image
- [ ] Multiple image carousel dalam banner
- [ ] Text typing animation
- [ ] Particle effects background
- [ ] Video playlist support
- [ ] Custom animation timing controls

---

**Created**: December 20, 2025
**Last Updated**: December 20, 2025
**Version**: 1.0.0
