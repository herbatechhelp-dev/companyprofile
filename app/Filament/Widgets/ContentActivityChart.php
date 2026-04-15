<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Product;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class ContentActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas Konten 6 Bulan Terakhir';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $startMonth = now()->subMonths(5)->startOfMonth();
        $endMonth = now()->endOfMonth();

        $publishedArticles = Article::query()
            ->whereNotNull('published_at')
            ->whereBetween('published_at', [$startMonth, $endMonth])
            ->get()
            ->groupBy(fn ($article) => $article->published_at->format('Y-m'));

        $createdProducts = Product::query()
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->get()
            ->groupBy(fn ($product) => $product->created_at->format('Y-m'));

        $labels = [];
        $articleData = [];
        $productData = [];

        foreach (CarbonPeriod::create($startMonth, '1 month', $endMonth) as $month) {
            $key = $month->format('Y-m');

            $labels[] = $month->translatedFormat('M Y');
            $articleData[] = $publishedArticles->get($key, collect())->count();
            $productData[] = $createdProducts->get($key, collect())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Artikel publish',
                    'data' => $articleData,
                    'backgroundColor' => '#10b981',
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'Produk ditambahkan',
                    'data' => $productData,
                    'backgroundColor' => '#0f766e',
                    'borderRadius' => 8,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
