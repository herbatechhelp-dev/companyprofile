<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class ContactMessagesChart extends ChartWidget
{
    protected static ?string $heading = 'Pesan Kontak 7 Hari Terakhir';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $messages = ContactMessage::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $grouped = $messages->groupBy(fn ($message) => $message->created_at->format('Y-m-d'));

        $labels = [];
        $totalData = [];
        $unreadData = [];

        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            $key = $date->format('Y-m-d');
            $items = $grouped->get($key, collect());

            $labels[] = $date->translatedFormat('d M');
            $totalData[] = $items->count();
            $unreadData[] = $items->where('is_read', false)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total pesan',
                    'data' => $totalData,
                    'borderColor' => '#059669',
                    'backgroundColor' => 'rgba(5, 150, 105, 0.12)',
                    'tension' => 0.35,
                    'fill' => true,
                ],
                [
                    'label' => 'Belum dibaca',
                    'data' => $unreadData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.12)',
                    'tension' => 0.35,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
