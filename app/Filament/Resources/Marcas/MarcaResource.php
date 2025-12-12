<?php

namespace App\Filament\Resources\Marcas;

use App\Filament\Resources\Marcas\Pages\ListMarcass;
use App\Filament\Resources\Marcas\Pages\CreateMarcas;
use App\Filament\Resources\Marcas\Pages\EditMarcas;
use App\Models\Marca;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MarcaResource extends Resource
{
    protected static ?string $model = Marca::class;

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
            'index' => ListMarcass::route('/'),
            'create' => CreateMarcas::route('/create'),
            'edit' => EditMarcas::route('/{record}/edit'),
        ];
    }
}
