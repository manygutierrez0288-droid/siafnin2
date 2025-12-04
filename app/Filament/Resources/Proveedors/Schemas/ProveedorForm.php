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
      

                TextInput::make('nombre')   ->required(),
                TextInput::make('telefono'),
                TextInput::make('direccion'),
                TextInput::make('email'),
                TextInput::make('numero_ruc'),
                    
            ]);
    }
}
