<?php

namespace App\Filament\Resources\MentorResource\RelationManagers;

use App\Entities\MentorEntities;
use App\Models\Mentors\MentorCredentials;
use App\Services\Mentors\MentorService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CredentialsRelationManager extends RelationManager
{
    protected static string $relationship = 'credentials';

    protected static ?string $label = 'Akun';
    protected static ?string $title = 'Akun Mentor';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return (int)$ownerRecord->status->value === MentorEntities::MENTOR_STATUS_APPROVED;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->minLength(6),
                Forms\Components\Toggle::make('status')
                    ->default(true)
                    ->hint('Aktifkan akun mentor ini?')
                    ->hiddenOn(['create']),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->sortable(),
                Tables\Columns\TextColumn::make('api_token')
                    ->label('API Token')
                    ->limit(30)
                    ->copyable(),
                Tables\Columns\TextColumn::make('default_password')
                    ->label('Password Default')
                    ->copyable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status Akun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date('d F Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->hidden(function (): bool {
                        $curr = $this->ownerRecord->id;
                        return MentorCredentials::where('mentor_id', $curr)->exists();
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $mentorId = $this->ownerRecord->id;
                        $data['api_token'] = MentorService::generateApiToken($mentorId, $data['email']);
                        $data['default_password'] = $data['mentor123'];
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
