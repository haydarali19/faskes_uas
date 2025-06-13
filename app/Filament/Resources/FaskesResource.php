<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaskesResource\Pages;
use App\Filament\Resources\FaskesResource\RelationManagers;
use App\Models\Faskes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class FaskesResource extends Resource
{
    protected static ?string $model = Faskes::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(100),

                TextInput::make('nama_pengelola')
                    ->required()
                    ->maxLength(45),

                Textarea::make('alamat')
                    ->required()
                    ->maxLength(100),

                // TextInput::make('website')
                //     ->label('Website')
                //     ->url()
                //     ->maxLength(45)
                //     ->nullable(),

                TextInput::make('email')
                    ->email()
                    ->maxLength(45)
                    ->nullable(),

                TextInput::make('rating')
                    ->numeric()
                    ->nullable(),

                TextInput::make('latitude')
                    ->numeric()
                    ->nullable(),

                TextInput::make('longitude')
                    ->numeric()
                    ->nullable(),

                Select::make('kabkota_id')
                    ->relationship('kabupatenKota', 'nama')
                    ->required()
                    ->label('Kabupaten/Kota'),

                Select::make('jenis_faskes_id')
                    ->relationship('jenisFaskes', 'nama')
                    ->required()
                    ->label('Jenis Faskes'),

                Select::make('kategori_id')
                    ->relationship('kategori', 'nama')
                    ->required()
                    ->label('Kategori'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('nama_pengelola')->sortable(),
                TextColumn::make('alamat')->limit(30),
                // TextColumn::make('website')->url()->label('Website'),
                TextColumn::make('email'),
                TextColumn::make('rating'),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
                TextColumn::make('kabupatenKota.nama')->label('Kab/Kota'),
                TextColumn::make('jenisFaskes.nama')->label('Jenis Faskes'),
                TextColumn::make('kategori.nama')->label('Kategori'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListFaskes::route('/'),
            'create' => Pages\CreateFaskes::route('/create'),
            'edit' => Pages\EditFaskes::route('/{record}/edit'),
        ];
    }
}
