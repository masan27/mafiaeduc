<?php

namespace App\Filament\Resources;

use App\Entities\MentorEntities;
use App\enums\MentorStatusEnum;
use App\Filament\Resources\MentorResource\Pages;
use App\Filament\Resources\MentorResource\RelationManagers;
use App\Models\Mentors\Mentor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MentorResource extends Resource
{
    protected static ?string $model = Mentor::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Mentor';
    protected static ?string $modelLabel = 'Mentor';
    protected static ?string $navigationGroup = 'Staff';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        Grid::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Informasi Pengajar')
                                    ->description('Menu ini digunakan untuk mengelola data pengajar')
                                    ->schema([
                                        FileUpload::make('photo')
                                            ->label('Foto')
                                            ->required()
                                            ->disk('public')
                                            ->downloadable()
                                            ->image(),
                                        TextInput::make('full_name')
                                            ->required()
                                            ->placeholder('Masukkan Nama Lengkap')
                                            ->label('Nama Lengkap'),
                                        TextInput::make('phone')
                                            ->required()
                                            ->tel()
                                            ->placeholder('Masukkan Nomor Telepon')
                                            ->label('Nomor Telepon'),
                                        TextInput::make('address')
                                            ->required()
                                            ->placeholder('Masukkan Alamat')
                                            ->label('Alamat'),
                                        TextInput::make('salary')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp ')
                                            ->placeholder('Masukkan Gaji')
                                            ->label('Gaji'),
                                        Grid::make()->schema([
                                            Select::make('grade_id')
                                                ->relationship(name: 'grade', titleAttribute: 'name')
                                                ->required()
                                                ->placeholder('Pilih Jenjang Pengajar')
                                                ->label('Jenjang Pengajar'),
                                            Select::make('learning_method_id')
                                                ->relationship(name: 'learningMethod', titleAttribute: 'name')
                                                ->required()
                                                ->placeholder('Pilih Metode Pembelajaran')
                                                ->label('Metode Pembelajaran'),
                                        ]),
                                        TextInput::make('linkedin')
                                            ->placeholder('Masukkan Link Linkedin')
                                            ->label('Linkedin'),
                                        TextInput::make('teaching_video')
                                            ->required()
                                            ->placeholder('Masukkan Link Video Pengajaran')
                                            ->label('Video Pengajaran'),
                                    ]),
                                Section::make('Dokumen Pengajar')
                                    ->description('Menu ini digunakan untuk mengelola dokumen pengajar')
                                    ->schema([
                                        FileUpload::make('cv')
                                            ->label('CV')
                                            ->required()
                                            ->disk('public')
                                            ->downloadable(),
                                        FileUpload::make('identity_card')
                                            ->label('KTP')
                                            ->required()
                                            ->disk('public')
                                            ->downloadable(),
                                        FileUpload::make('certificate')
                                            ->label('Ijazah')
                                            ->required()
                                            ->disk('public')
                                            ->downloadable(),
                                    ]),
                            ]),
                        Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Status Mentor')
                                    ->description('Menu ini digunakan untuk mengelola status mentor')
                                    ->hidden(function ($record) {
                                        return collect([
                                            MentorEntities::MENTOR_STATUS_PENDING_APPROVAL,
                                            MentorEntities::MENTOR_STATUS_APPROVED,
                                            MentorEntities::MENTOR_STATUS_REJECTED,
                                        ])->contains($record->status->value);
                                    })
                                    ->hiddenOn(['create'])
                                    ->schema([
                                        Radio::make('status')
                                            ->live()
                                            ->options([
                                                MentorEntities::MENTOR_STATUS_PENDING_APPROVAL => MentorEntities::MENTOR_STATUS_PENDING_APPROVAL_TEXT,
                                                MentorEntities::MENTOR_STATUS_APPROVED => MentorEntities::MENTOR_STATUS_APPROVED_TEXT,
                                                MentorEntities::MENTOR_STATUS_REJECTED => MentorEntities::MENTOR_STATUS_REJECTED_TEXT,
                                                MentorEntities::MENTOR_STATUS_BLOCKED => MentorEntities::MENTOR_STATUS_BLOCKED_TEXT,
                                            ])
                                            ->required()
                                            ->label('Status'),
                                    ]),
                                Section::make('Mata Pelajaran Mentor')
                                    ->description('Menu ini digunakan untuk mengelola mata pelajaran mentor')
                                    ->schema([
                                        Select::make('subjects')
                                            ->relationship(name: 'subjects', titleAttribute: 'name')
                                            ->multiple()
                                            ->required()
                                            ->placeholder('Pilih Mata Pelajaran')
                                            ->label('Mata Pelajaran'),
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('No. HP')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->date('d F Y')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->placeholder('Pilih Status')
                    ->options(MentorStatusEnum::class),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
//                Tables\Actions\Action::make('Terima')
//                    ->color(Color::Green)
//                    ->icon('heroicon-o-check-circle')
//                    ->visible(fn($record) => $record->status ===
//                        MentorEntities::MENTOR_STATUS_PENDING_APPROVAL
//                    )
//                    ->requiresConfirmation()
//                    ->action(function (Mentor $records): void {
//                        $records->status = MentorEntities::MENTOR_STATUS_APPROVED;
//                        $records->save();
//                    }),
//                Tables\Actions\Action::make('Tolak')
//                    ->color(Color::Red)
//                    ->icon('heroicon-o-x-circle')
//                    ->requiresConfirmation()
//                    ->visible(
//                        fn($record) => $record->status ===
//                            MentorEntities::MENTOR_STATUS_PENDING_APPROVAL
//                    )
//                    ->action(function (Mentor $records): void {
//                        $records->status = MentorEntities::MENTOR_STATUS_REJECTED;
//                        $records->save();
//                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\CredentialsRelationManager::class,
            RelationManagers\PaymentMethodRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMentors::route('/'),
            'create' => Pages\CreateMentor::route('/create'),
            'edit' => Pages\EditMentor::route('/{record}/edit'),
        ];
    }
}
