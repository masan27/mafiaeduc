<?php

namespace App\Filament\Resources\SalesResource\RelationManagers;

use App\Entities\SalesEntities;
use App\Filament\Resources\GroupClassResource;
use App\Filament\Resources\MaterialResource;
use App\Filament\Resources\PrivateClassResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
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
                Tables\Columns\TextColumn::make(
                    $type === SalesEntities::PRIVATE_CLASSES_TYPE ? 'privateClasses.mentor.full_name' : ($type === SalesEntities::GROUP_CLASSES_TYPE ? 'groupClasses.title' :
                        'material.title')
                )->label(
                    $type === SalesEntities::PRIVATE_CLASSES_TYPE ? 'Nama Mentor' : ($type === SalesEntities::GROUP_CLASSES_TYPE ? 'Judul Kelas' :
                        'Judul Materi')
                )
                    ->limit(50),
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
