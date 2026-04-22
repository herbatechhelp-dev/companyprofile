<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    public function run()
    {
        // 1. Latar Belakang
        CompanyInfo::updateOrCreate(
            ['page' => 'background'],
            [
                'title' => 'Latar Belakang Herbatech',
                'description' => '<p>Didirikan pada tahun 2010, Herbatech berawal dari sebuah laboratorium penelitian kecil yang berfokus pada pengembangan produk kesehatan berbasis bahan alami Indonesia. Dengan komitmen yang kuat terhadap inovasi dan kualitas, kami telah tumbuh menjadi salah satu pemimpin industri dalam penyediaan solusi kesehatan terpadu.</p><p>Visi kami adalah menjadi pionir kemandirian kesehatan bangsa melalui pengolahan kekayaan hayati nusantara dengan standar teknologi global. Misi kami meliputi riset berkelanjutan, standarisasi proses manufaktur, serta pengembangan rantai nilai yang memberdayakan petani lokal.</p>',
                'icons' => []
            ]
        );

        // 2. Tentang Grup
        CompanyInfo::updateOrCreate(
            ['page' => 'our-group'],
            [
                'title' => 'Profil Herbatech Group',
                'description' => '<p>Herbatech Group adalah ekosistem bisnis terintegrasi yang mencakup berbagai unit strategis mulai dari hulu hingga hilir. Kami mengelola perkebunan tanaman obat, pusat riset bioteknologi, fasilitas produksi farmasi, hingga jaringan distribusi logistik nasional.</p><p>Kekuatan kami terletak pada sinergi antar unit bisnis yang memastikan setiap produk yang sampai ke tangan konsumen telah melalui kontrol kualitas yang sangat ketat dan transparan. Kami percaya bahwa kolaborasi adalah kunci untuk menciptakan dampak sosial yang berkelanjutan bagi masyarakat Indonesia.</p>',
                'icons' => [
                    ['title' => 'Inovasi Tanpa Henti', 'description' => 'Terus mengembangkan teknologi ekstraksi bahan alam terbaru.'],
                    ['title' => 'Standar Global', 'description' => 'Sertifikasi GMP, ISO, dan Halal pada seluruh lini produksi.'],
                    ['title' => 'Impact Sosial', 'description' => 'Bekerjasama dengan lebih dari 10.000 petani lokal.'],
                ]
            ]
        );

        // 3. Rantai Nilai
        CompanyInfo::updateOrCreate(
            ['page' => 'value-chain'],
            [
                'title' => 'Rantai Nilai Strategis',
                'description' => 'Kami mengintegrasikan seluruh lini bisnis untuk menciptakan nilai tambah yang berkelanjutan bagi seluruh pemangku kepentingan.',
                'icons' => [
                    [
                        'title' => 'Upstream (Sektor Hulu)', 
                        'description' => 'Pengelolaan perkebunan mandiri dan kemitraan strategis dengan ribuan petani lokal untuk memastikan pasokan bahan baku herbal kualitas terbaik secara berkelanjutan.',
                        'image' => null,
                        'companies' => [
                            ['name' => 'PT. Agri Herb Utama', 'logo' => null],
                            ['name' => 'Koperasi Tani Mandiri', 'logo' => null],
                        ]
                    ],
                    [
                        'title' => 'Midstream (Sektor Antara)', 
                        'description' => 'Fasilitas Research & Development modern berstandar internasional yang dipadukan dengan manufaktur otomatis untuk menghasilkan produk dengan efikasi tinggi.',
                        'image' => null,
                        'companies' => [
                            ['name' => 'Herbatech Innovation Lab', 'logo' => null],
                            ['name' => 'PT. Pharma Pro Indonesia', 'logo' => null],
                        ]
                    ],
                    [
                        'title' => 'Downstream (Sektor Hilir)', 
                        'description' => 'Jaringan distribusi nasional dan global yang didukung sistem cold-chain terintegrasi serta strategi pemasaran digital untuk menjangkau konsumen akhir.',
                        'image' => null,
                        'companies' => [
                            ['name' => 'HerbaLogistics', 'logo' => null],
                            ['name' => 'PT. Jaringan Apotek Sehat', 'logo' => null],
                        ]
                    ]
                ]
            ]
        );

        // 4. Struktur Organisasi
        CompanyInfo::updateOrCreate(
            ['page' => 'org-structure'],
            [
                'title' => 'Struktur Kepemimpinan',
                'description' => '<p>Di Herbatech, kami dipimpin oleh para profesional berpengalaman yang memiliki dedikasi tinggi dalam memajukan industri kesehatan nasional.</p>',
                'icons' => [
                    [
                        'title' => 'Ir. Ahmad Sudrajat', 
                        'description' => 'Direktur Utama',
                        'image' => null
                    ],
                    [
                        'title' => 'Dr. Sari Wijaya', 
                        'description' => 'General Manager',
                        'image' => null
                    ],
                    [
                        'title' => 'Budi Santoso, MBA', 
                        'description' => 'Manajer Produksi',
                        'image' => null
                    ]
                ]
            ]
        );
    }
}
