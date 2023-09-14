<?php

namespace App\Filament\Resources\SalesResource\RelationManagers;

use App\Entities\SalesEntities;
use App\Filament\Resources\GroupClassResource;
use App\Filament\Resources\MaterialResource;
use App\Filament\Resources\PrivateClassResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';
    protected static ?string $title = 'Detail Pesanan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sales_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        $type = (int)$this->ownerRecord->type->value;

        return $table
            ->recordTitleAttribute('sales_id')
            ->columns([
                Tables\Columns\TextColumn::make('privateClasses.mentor.full_name')
                    ->hidden($type !== SalesEntities::PRIVATE_CLASSES_TYPE)
                    ->label('Nama Mentor')
                    ->limit(50),
                Tables\Columns\TextColumn::make('groupClasses.title')
                    ->hidden($type !== SalesEntities::GROUP_CLASSES_TYPE)
                    ->label('Judul Kelas')
                    ->limit(50),
                Tables\Columns\TextColumn::make('material.title')
                    ->hidden($type !== SalesEntities::MATERIALS_TYPE)
                    ->label('Judul Materi')
                    ->limit(50),
                Tables\Columns\TextColumn::make('privateClasses.subject.name')
                    ->hidden($type !== SalesEntities::PRIVATE_CLASSES_TYPE)
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('groupClasses.subject.name')
                    ->hidden($type !== SalesEntities::GROUP_CLASSES_TYPE)
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('material.grade.name')
                    ->hidden($type !== SalesEntities::MATERIALS_TYPE)
                    ->label('Jenjang Kelas'),
                Tables\Columns\TextColumn::make('privateClasses.grade.name')
                    ->hidden($type !== SalesEntities::PRIVATE_CLASSES_TYPE)
                    ->label('Jenjang Kelas'),
                Tables\Columns\TextColumn::make('groupClasses.grade.name')
                    ->hidden($type !== SalesEntities::GROUP_CLASSES_TYPE)
                    ->label('Jenjang Kelas'),
                Tables\Columns\TextColumn::make('groupClasses.learningMethod.name')
                    ->badge()
                    ->color(Color::Blue)
                    ->hidden($type !== SalesEntities::GROUP_CLASSES_TYPE)
                    ->label('Metode Pembelajaran'),
                Tables\Columns\TextColumn::make('material.learningMethod.name')
                    ->hidden($type !== SalesEntities::MATERIALS_TYPE)
                    ->badge()
                    ->color(Color::Blue)
                    ->label('Metode Pembelajaran'),
                Tables\Columns\TextColumn::make('material.price')
                    ->hidden($type !== SalesEntities::MATERIALS_TYPE)
                    ->label('Harga Materi'),
                Tables\Columns\TextColumn::make('privateClasses.price')
                    ->hidden($type !== SalesEntities::PRIVATE_CLASSES_TYPE)
                    ->label('Harga Kelas'),
                Tables\Columns\TextColumn::make('groupClasses.price')
                    ->hidden($type !== SalesEntities::GROUP_CLASSES_TYPE)
                    ->money('idr')
                    ->label('Harga Kelas'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Lihat Detail')
                    ->action(function ($record) {
                        // redirect to group class detail page
                        $type = (int)$this->ownerRecord->type->value;
                        if ($type === SalesEntities::PRIVATE_CLASSES_TYPE) {
                            $path = PrivateClassResource::getUrl('edit', ['record' => $record->private_classes_id]);
                            return redirect($path);
                        } else if ($type === SalesEntities::GROUP_CLASSES_TYPE) {
                            $path = GroupClassResource::getUrl('edit', ['record' => $record->group_classes_id]);
                            return redirect($path);
                        } else {
                            $path = MaterialResource::getUrl('edit', ['record' => $record->material_id]);
                            return redirect($path);
                        }
                    }),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
            ]);
    }
}
