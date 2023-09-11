<?php

namespace App\Filament\Resources\PrivateClassResource\RelationManagers;

use App\Entities\SalesEntities;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->placeholder('Pilih tanggal')
                    ->required(),
                Forms\Components\TimePicker::make('time')
                    ->placeholder('Pilih waktu')
                    ->seconds(false)
                    ->required(),
                Forms\Components\Select::make('meeting_platform')
                    ->options([
                        'Zoom' => 'Zoom',
                        'Google Meet' => 'Google Meet',
                        'Microsoft Teams' => 'Microsoft Teams',
                        'Skype' => 'Skype',
                        'Discord' => 'Discord',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->hidden(function (): bool {
                        $learningMethod = $this->ownerRecord->learning_method_id;
                        return $learningMethod === 2;
                    })
                    ->placeholder('Pilih platform')
                    ->label('Platform'),
                Forms\Components\TextInput::make('meeting_link')
                    ->required()
                    ->string()
                    ->hidden(function (): bool {
                        $learningMethod = $this->ownerRecord->learning_method_id;
                        return $learningMethod === 2;
                    })
                    ->placeholder('Masukkan link meeting')
                    ->label('Link Meeting'),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->string()
                    ->hidden(function (): bool {
                        $learningMethod = $this->ownerRecord->learning_method_id;
                        return $learningMethod === 1;
                    })
                    ->placeholder('Masukkan alamat')
                    ->label('Alamat'),
                Forms\Components\Toggle::make('is_done')
                    ->hiddenOn(['create'])
                    ->hint('Apakah kelas sudah selesai?')
                    ->label('Status'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->sortable()
                    ->searchable()
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('date')
                    ->date('d F Y')
                    ->sortable()
                    ->searchable()
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('time')
                    ->sortable()
                    ->searchable()
                    ->label('Waktu'),
                Tables\Columns\TextColumn::make('meeting_platform')
                    ->label('Platform'),
                Tables\Columns\TextColumn::make('is_done')
                    ->label('Status')
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['learning_method_id'] = (int)$this->ownerRecord->learning_method_id;
                        $data['mentor_id'] = (int)$this->ownerRecord->mentor_id;
                        $data['subject_id'] = (int)$this->ownerRecord->subject_id;
                        $data['grade_id'] = (int)$this->ownerRecord->grade_id;
                        return $data;
                    })
                    ->using(function (array $data, $model): Model {
                        $privateClassId = $data['private_classes_id'];
                        $modelCreated = $model::create($data);

                        $isBooked = DB::table('sales_details')
                            ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                            ->where([
                                ['private_classes_id', $privateClassId],
                                ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                            ])->exists();

                        if ($isBooked) {
                            // add user_id to the user_schedule table
                            $users = DB::table('sales_details')
                                ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                                ->where([
                                    ['private_classes_id', $privateClassId],
                                    ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                                ])->get();

                            foreach ($users as $user) {
                                DB::table('user_schedule')->insert([
                                    'user_id' => $user->user_id,
                                    'schedule_id' => $modelCreated->id,
                                ]);
                            }
                        }

                        return $modelCreated;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Mark as Done')
                        ->label('Tandai sebagai selesai')
                        ->requiresConfirmation()
                        ->color(Color::Green)
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            $records->each(function (Model $record) {
                                $record->update([
                                    'is_done' => true,
                                ]);
                            });
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['learning_method_id'] = (int)$this->ownerRecord->learning_method_id;
                        $data['mentor_id'] = (int)$this->ownerRecord->mentor_id;
                        $data['subject_id'] = (int)$this->ownerRecord->subject_id;
                        $data['grade_id'] = (int)$this->ownerRecord->grade_id;
                        $data['private_classes_id'] = (int)$this->ownerRecord->id;
                        return $data;
                    })
                    ->using(function (array $data, $model): Model {
                        $privateClassId = $data['private_classes_id'];
                        $modelCreated = $model::create($data);

                        $isBooked = DB::table('sales_details')
                            ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                            ->where([
                                ['private_classes_id', $privateClassId],
                                ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                            ])->exists();

                        if ($isBooked) {
                            // add user_id to the user_schedule table
                            $users = DB::table('sales_details')
                                ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                                ->where([
                                    ['private_classes_id', $privateClassId],
                                    ['sales.sales_status_id', SalesEntities::SALES_STATUS_PAID],
                                ])->get();

                            foreach ($users as $user) {
                                DB::table('user_schedule')->insert([
                                    'user_id' => $user->user_id,
                                    'schedule_id' => $modelCreated->id,
                                ]);
                            }
                        }

                        return $modelCreated;
                    })
            ]);
    }
}
