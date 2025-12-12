<?php

namespace App\Filament\Resources\Vehiculos;

use App\Filament\Resources\Vehiculos\Pages\ListVehiculoss;
use App\Filament\Resources\Vehiculos\Pages\CreateVehiculos;
use App\Filament\Resources\Vehiculos\Pages\EditVehiculos;
use App\Models\Vehiculo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class VehiculoResource extends Resource
{
    protected static ?string $model = Vehiculo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('placa')->label('Placa'),
                \Filament\Forms\Components\TextInput::make('numeroMotor')->label('Numeromotor'),
                \Filament\Forms\Components\TextInput::make('chasis')->label('Chasis'),
                \Filament\Forms\Components\TextInput::make('anio')->label('Anio'),
                \Filament\Forms\Components\BelongsToSelect::make('idActivoFijo')->relationship('activosFijo','nombre')->label('ActivosFijo'),
                \Filament\Forms\Components\TextInput::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Forms\Components\TextInput::make('fechaActualizacion')->label('Fechaactualizacion')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('placa')->label('Placa'),
                \Filament\Tables\Columns\TextColumn::make('numeroMotor')->label('Numeromotor'),
                \Filament\Tables\Columns\TextColumn::make('chasis')->label('Chasis'),
                \Filament\Tables\Columns\TextColumn::make('anio')->label('Anio'),
                \Filament\Tables\Columns\TextColumn::make('activosFijo.nombre')->label('ActivosFijo'),
                \Filament\Tables\Columns\TextColumn::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Tables\Columns\TextColumn::make('fechaActualizacion')->label('Fechaactualizacion')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVehiculoss::route('/'),
            'create' => CreateVehiculos::route('/create'),
            'edit' => EditVehiculos::route('/{record}/edit'),
        ];
    }
}
