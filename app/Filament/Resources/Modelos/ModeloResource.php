<?php

namespace App\Filament\Resources\Modelos;

use App\Filament\Resources\Modelos\Pages\ListModeloss;
use App\Filament\Resources\Modelos\Pages\CreateModelos;
use App\Filament\Resources\Modelos\Pages\EditModelos;
use App\Models\Modelo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ModeloResource extends Resource
{
    protected static ?string $model = Modelo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\BelongsToSelect::make('idMarca')->relationship('marca','nombre')->label('Idmarca')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('marca.nombre')->label('Idmarca')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModeloss::route('/'),
            'create' => CreateModelos::route('/create'),
            'edit' => EditModelos::route('/{record}/edit'),
        ];
    }
}
