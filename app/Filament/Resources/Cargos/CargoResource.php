<?php

namespace App\Filament\Resources\Cargos;

use App\Filament\Resources\Cargos\Pages\ListCargoss;
use App\Filament\Resources\Cargos\Pages\CreateCargos;
use App\Filament\Resources\Cargos\Pages\EditCargos;
use App\Models\Cargo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CargoResource extends Resource
{
    protected static ?string $model = Cargo::class;

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
            'index' => ListCargoss::route('/'),
            'create' => CreateCargos::route('/create'),
            'edit' => EditCargos::route('/{record}/edit'),
        ];
    }
}
