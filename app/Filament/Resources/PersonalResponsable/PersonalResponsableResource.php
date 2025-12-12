<?php

namespace App\Filament\Resources\PersonalResponsable;

use App\Filament\Resources\PersonalResponsable\Pages\ListPersonalResponsables;
use App\Filament\Resources\PersonalResponsable\Pages\CreatePersonalResponsable;
use App\Filament\Resources\PersonalResponsable\Pages\EditPersonalResponsable;
use App\Models\PersonalResponsable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PersonalResponsableResource extends Resource
{
    protected static ?string $model = PersonalResponsable::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\BelongsToSelect::make('idCargo')->relationship('cargo','nombre')->label('Cargo'),
                \Filament\Forms\Components\TextInput::make('numero_cedula')->label('Numero Cedula'),
                \Filament\Forms\Components\TextInput::make('telefono')->label('Telefono'),
                \Filament\Forms\Components\TextInput::make('email')->label('Email'),
                \Filament\Forms\Components\TextInput::make('activo')->label('Activo')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('cargo.nombre')->label('Cargo'),
                \Filament\Tables\Columns\TextColumn::make('numero_cedula')->label('Numero Cedula'),
                \Filament\Tables\Columns\TextColumn::make('telefono')->label('Telefono'),
                \Filament\Tables\Columns\TextColumn::make('email')->label('Email'),
                \Filament\Tables\Columns\TextColumn::make('activo')->label('Activo')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPersonalResponsables::route('/'),
            'create' => CreatePersonalResponsable::route('/create'),
            'edit' => EditPersonalResponsable::route('/{record}/edit'),
        ];
    }
}
