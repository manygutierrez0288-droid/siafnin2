<?php

namespace App\Filament\Resources\Proveedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProveedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')->label('Nombre')->required(),
                TextInput::make('numero_ruc')->label('RUC'),
                TextInput::make('telefono')->label('Teléfono'),
                TextInput::make('email')->label('Email')->email(),
                TextInput::make('direccion')->label('Dirección'),
            ]);
    }
}
