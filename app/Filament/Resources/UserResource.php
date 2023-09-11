<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Grades\Grade;
use App\Models\Users\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'User';
    protected static ?string $modelLabel = 'User';
    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        Section::make('Akun')
                            ->columnSpan(2)
                            ->description('Bagian ini berisi data diri pengguna')
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email')
                                    ->required()
                                    ->autofocus()
                                    ->placeholder('Masukkan Email'),
                                Group::make()
                                    ->relationship('detail')
                                    ->schema([
                                        TextInput::make('full_name')
                                            ->label('Nama Lengkap')
                                            ->required()
                                            ->placeholder('Masukkan Nama Lengkap'),
                                        TextInput::make('phone')
                                            ->label('No. HP')
                                            ->required()
                                            ->placeholder('Masukkan No. HP')
                                            ->tel(),
                                        TextInput::make('school_origin')
                                            ->label('Asal Sekolah')
                                            ->required()
                                            ->placeholder('Masukkan Asal Sekolah'),
                                        Select::make('grade_id')
                                            ->label('Jenjang')
                                            ->placeholder('Pilih Jenjang')
                                            ->options(Grade::all()->pluck('name', 'id'))
                                            ->required(),
                                        Select::make('gender')
                                            ->label('Jenis Kelamin')
                                            ->placeholder('Pilih Jenis Kelamin')
                                            ->options([
                                                'pria' => 'Laki-laki',
                                                'wanita' => 'Perempuan',
                                            ])
                                            ->required(),
                                        DateTimePicker::make('birth_date')
                                            ->label('Tanggal Lahir')
                                            ->format('d/m/Y')
                                            ->time(false)
                                            ->required()
                                            ->placeholder('Masukkan Tanggal Lahir'),
                                    ]),
                                Toggle::make('status')
                                    ->label('Status')
                                    ->hint('Status aktif menandakan bahwa pengguna dapat mengakses sistem')
                                    ->hiddenOn(['create'])
                                    ->required(),
                            ]),

                        Section::make('Ubah Password')
                            ->description('Bagian ini berisi data diri pengguna')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('password')
                                    ->label('Password')
                                    ->confirmed()
                                    ->password()
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->placeholder('Masukkan Password'),
                                TextInput::make('password_confirmation')
                                    ->label('Konfirmasi Password')
                                    ->password()
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->placeholder('Masukkan Konfirmasi Password'),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail.full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail.phone')
                    ->label('No. HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('detail.school_origin')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(Color::Blue)
                    ->label('Role')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ])
//            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
//            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
