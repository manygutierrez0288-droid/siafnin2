<?php

namespace App\Filament\Resources\Fuentes;

use App\Filament\Resources\Fuentes\Pages\ListFuentess;
use App\Filament\Resources\Fuentes\Pages\CreateFuentes;
use App\Filament\Resources\Fuentes\Pages\EditFuentes;
use App\Models\Fuente;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FuenteResource extends Resource
{
    protected static ?string $model = Fuente::class;

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
            'index' => ListFuentess::route('/'),
            'create' => CreateFuentes::route('/create'),
            'edit' => EditFuentes::route('/{record}/edit'),
        ];
    }
}
