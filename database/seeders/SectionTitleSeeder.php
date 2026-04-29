<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SectionTitleSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Section: Layanan Unggulan Kami
            [
                'key'   => 'services_title',
                'value' => 'Layanan Unggulan Kami',
                'type'  => 'text',
            ],
            [
                'key'   => 'services_subtitle',
                'value' => 'Kami menawarkan berbagai solusi manufaktur kemasan yang dirancang khusus untuk memenuhi standar industri tertinggi.',
                'type'  => 'textarea',
            ],

            // Section: Produk yang Kami Hasilkan
            [
                'key'   => 'materials_title',
                'value' => 'Produk yang Kami Hasilkan',
                'type'  => 'text',
            ],

            // Section: Partner / Client
            [
                'key'   => 'partners_title',
                'value' => 'TELAH DIPERCAYA OLEH PERUSAHAAN TERNAMA',
                'type'  => 'text',
            ],

            // Section: Mengapa Harus Kami (sudah dibuat sebelumnya, pastikan ada)
            [
                'key'   => 'why_us_title',
                'value' => 'Mengapa Harus Kami?',
                'type'  => 'text',
            ],
            [
                'key'   => 'why_us_subtitle',
                'value' => 'Dedikasi kami pada kualitas dan inovasi menjadikan kami mitra manufaktur pilihan untuk pertumbuhan brand Anda.',
                'type'  => 'textarea',
            ],

            // Section: Alur Maklon
            [
                'key'   => 'maklon_title',
                'value' => 'Alur Maklon',
                'type'  => 'text',
            ],
            [
                'key'   => 'maklon_subtitle',
                'value' => 'Langkah-langkah kerjasama maklon kami agar proses produksi berjalan lancar dan sesuai kebutuhan brand Anda.',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'maklon_badge',
                'value' => 'Proses berjalan terarah',
                'type'  => 'text',
            ],
            [
                'key'   => 'maklon_badge_desc',
                'value' => 'Setiap tahap dirancang berurutan agar brand Anda bergerak dari ide ke produk jadi dengan kontrol yang jelas.',
                'type'  => 'textarea',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Section title settings berhasil disimpan!');
    }
}
