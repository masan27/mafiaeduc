<?php

namespace App\Filament\Widgets;

use App\Models\Mentors\MentorCredentials;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MentorChart extends LineChartWidget
{
    protected static ?string $heading = 'Mentor Accepted Chart';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(MentorCredentials::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mentor Accepted',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
