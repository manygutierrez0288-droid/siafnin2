<?php

namespace App\Filament\Resources\Proveedore;

use App\Filament\Resources\Proveedore\Pages\ListProveedore;
use App\Filament\Resources\Proveedore\Pages\CreateProveedore;
use App\Filament\Resources\Proveedore\Pages\EditProveedore;
use App\Models\Proveedor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProveedoreResource extends Resource
{
    protected static ?string $model = Proveedor::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
            \Filament\Forms\Components\TextInput::make('numero_ruc')->label('Numero Ruc'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
            \Filament\Tables\Columns\TextColumn::make('numero_ruc')->label('Numero Ruc'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProveedore::route('/'),
            'create' => CreateProveedore::route('/create'),
            'edit' => EditProveedore::route('/{record}/edit'),
        ];
    }
}
