<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\VacancyResource;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminQuickActions extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Tambah Artikel', 'Buka form artikel')
                ->description('Buat artikel baru untuk website')
                ->color('success')
                ->url(ArticleResource::getUrl('create')),
            Stat::make('Tambah Produk', 'Buka form produk')
                ->description('Tambahkan produk unggulan atau katalog')
                ->color('primary')
                ->url(ProductResource::getUrl('create')),
            Stat::make('Tambah Lowongan', 'Buka form lowongan')
                ->description('Publikasikan kebutuhan rekrutmen terbaru')
                ->color('info')
                ->url(VacancyResource::getUrl('create')),
            Stat::make('Lihat Pesan', ContactMessage::query()->where('is_read', false)->count() . ' belum dibaca')
                ->description('Buka inbox pesan kontak dari website')
                ->color('warning')
                ->url(ContactMessageResource::getUrl('index')),
        ];
    }
}
