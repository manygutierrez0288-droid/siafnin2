<?php

namespace App\Filament\Resources\Colores;

use App\Filament\Resources\Colores\Pages\ListColoress;
use App\Filament\Resources\Colores\Pages\CreateColores;
use App\Filament\Resources\Colores\Pages\EditColores;
use App\Models\Colore;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ColoreResource extends Resource
{
    protected static ?string $model = Colore::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListColoress::route('/'),
            'create' => CreateColores::route('/create'),
            'edit' => EditColores::route('/{record}/edit'),
        ];
    }
}
