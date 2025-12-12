<?php

namespace App\Filament\Resources\Proveedores;

use App\Filament\Resources\Proveedores\Pages\ListProveedoress;
use App\Filament\Resources\Proveedores\Pages\CreateProveedores;
use App\Filament\Resources\Proveedores\Pages\EditProveedores;
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
                \Filament\Forms\Components\TextInput::make('telefono')->label('Telefono'),
                \Filament\Forms\Components\TextInput::make('email')->label('Email'),
                \Filament\Forms\Components\TextInput::make('direccion')->label('Direccion'),
                \Filament\Forms\Components\TextInput::make('activo')->label('Activo')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('numero_ruc')->label('Numero Ruc'),
                \Filament\Tables\Columns\TextColumn::make('telefono')->label('Telefono'),
                \Filament\Tables\Columns\TextColumn::make('email')->label('Email'),
                \Filament\Tables\Columns\TextColumn::make('direccion')->label('Direccion'),
                \Filament\Tables\Columns\TextColumn::make('activo')->label('Activo')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProveedoress::route('/'),
            'create' => CreateProveedores::route('/create'),
            'edit' => EditProveedores::route('/{record}/edit'),
        ];
    }
}
