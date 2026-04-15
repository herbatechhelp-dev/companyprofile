<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\MaklonFlowStep;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Vacancy;
use Carbon\CarbonPeriod;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverviewStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $messageTrend = $this->getDailyCounts(
            ContactMessage::query(),
            now()->subDays(6)->startOfDay(),
            now()->endOfDay()
        );

        $articleTrend = $this->getDailyCounts(
            Article::query()->whereNotNull('published_at')->where('published_at', '<=', now()),
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
            'published_at'
        );

        return [
            Stat::make('Pesan Belum Dibaca', ContactMessage::query()->where('is_read', false)->count())
                ->description('Total pesan masuk: ' . ContactMessage::query()->count())
                ->color('warning')
                ->chart($messageTrend),
            Stat::make('Artikel Publish', Article::query()->whereNotNull('published_at')->where('published_at', '<=', now())->count())
                ->description('Draft artikel: ' . Article::query()->whereNull('published_at')->count())
                ->color('success')
                ->chart($articleTrend),
            Stat::make('Produk Unggulan', Product::query()->where('is_featured', true)->count())
                ->description('Total produk: ' . Product::query()->count())
                ->color('primary'),
            Stat::make('Lowongan Aktif', Vacancy::query()->active()->count())
                ->description('Total lowongan: ' . Vacancy::query()->count())
                ->color('info'),
            Stat::make('Partner Aktif', Partner::query()->where('is_active', true)->count())
                ->description('Total partner: ' . Partner::query()->count())
                ->color('gray'),
            Stat::make('Step Maklon Aktif', MaklonFlowStep::query()->where('is_active', true)->count())
                ->description('Total step: ' . MaklonFlowStep::query()->count())
                ->color('success'),
        ];
    }

    /**
     * @return array<int, int>
     */
    private function getDailyCounts($query, $startDate, $endDate, string $column = 'created_at'): array
    {
        $counts = $query
            ->whereBetween($column, [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($record) => $record->{$column}->format('Y-m-d'))
            ->map(fn ($items) => $items->count());

        return collect(CarbonPeriod::create($startDate, $endDate))
            ->map(fn ($date) => $counts->get($date->format('Y-m-d'), 0))
            ->values()
            ->all();
    }
}
