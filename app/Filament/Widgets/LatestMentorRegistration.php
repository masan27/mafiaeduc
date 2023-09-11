<?php

namespace App\Filament\Widgets;

use App\Entities\MentorEntities;
use App\Models\Mentors\Mentor;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMentorRegistration extends BaseWidget
{

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Mentor::query()->where('status', MentorEntities::MENTOR_STATUS_PENDING_APPROVAL)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('full_name'),
            Tables\Columns\TextColumn::make('address'),
            Tables\Columns\TextColumn::make('phone'),
            Tables\Columns\TextColumn::make('salary')->money('idr', true),
            Tables\Columns\TextColumn::make('status')
                ->colors([
                    'primary',
                    'success' => MentorEntities::MENTOR_STATUS_APPROVED,
                    'warning' => MentorEntities::MENTOR_STATUS_PENDING_APPROVAL,
                    'danger' => MentorEntities::MENTOR_STATUS_REJECTED || MentorEntities::MENTOR_STATUS_BLOCKED,
                ])
        ];
    }
}
