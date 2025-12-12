<?php

namespace App\Filament\Resources\EstadosActivo;

use App\Filament\Resources\EstadosActivo\Pages\ListEstadosActivos;
use App\Filament\Resources\EstadosActivo\Pages\CreateEstadosActivo;
use App\Filament\Resources\EstadosActivo\Pages\EditEstadosActivo;
use App\Models\EstadosActivo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class EstadosActivoResource extends Resource
{
    protected static ?string $model = EstadosActivo::class;

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
            'index' => ListEstadosActivos::route('/'),
            'create' => CreateEstadosActivo::route('/create'),
            'edit' => EditEstadosActivo::route('/{record}/edit'),
        ];
    }
}
