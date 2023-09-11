<?php

namespace App\Filament\Widgets;

use App\Models\Classes\GroupClass;
use App\Models\Classes\PrivateClass;
use App\Models\Mentors\Mentor;
use App\Models\Users\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            BaseWidget\Stat::make('Total Users', User::count()),
            BaseWidget\Stat::make('Total Mentors', Mentor::count()),
            BaseWidget\Stat::make('Total Group Classes', GroupClass::count()),
            BaseWidget\Stat::make('Total Group Classes', GroupClass::count()),
        ];
    }
}
