<?php

namespace App\Filament\Resources\Ubicaciones;

use App\Filament\Resources\Ubicaciones\Pages\ListUbicacioness;
use App\Filament\Resources\Ubicaciones\Pages\CreateUbicaciones;
use App\Filament\Resources\Ubicaciones\Pages\EditUbicaciones;
use App\Models\Ubicacione;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UbicacioneResource extends Resource
{
    protected static ?string $model = Ubicacione::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\TextInput::make('descripcion')->label('Descripcion'),
                \Filament\Forms\Components\TextInput::make('activo')->label('Activo')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('descripcion')->label('Descripcion'),
                \Filament\Tables\Columns\TextColumn::make('activo')->label('Activo')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUbicacioness::route('/'),
            'create' => CreateUbicaciones::route('/create'),
            'edit' => EditUbicaciones::route('/{record}/edit'),
        ];
    }
}
