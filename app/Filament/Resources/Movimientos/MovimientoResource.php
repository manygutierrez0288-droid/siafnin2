<?php

namespace App\Filament\Resources\Movimientos;

use App\Filament\Resources\Movimientos\Pages\ListMovimientoss;
use App\Filament\Resources\Movimientos\Pages\CreateMovimientos;
use App\Filament\Resources\Movimientos\Pages\EditMovimientos;
use App\Models\Movimiento;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\BelongsToSelect::make('idActivoFijo')->relationship('activosFijo','nombre')->label('ActivosFijo'),
                \Filament\Forms\Components\BelongsToSelect::make('idUbicacionOrigen')->relationship('ubicacione','nombre')->label('Ubicacione'),
                \Filament\Forms\Components\BelongsToSelect::make('idUbicacionDestino')->relationship('ubicacione','nombre')->label('Ubicacione'),
                \Filament\Forms\Components\BelongsToSelect::make('idResponsableOrigen')->relationship('personalResponsable','nombre')->label('PersonalResponsable'),
                \Filament\Forms\Components\BelongsToSelect::make('idResponsableDestino')->relationship('personalResponsable','nombre')->label('PersonalResponsable'),
                \Filament\Forms\Components\TextInput::make('fecha')->label('Fecha'),
                \Filament\Forms\Components\TextInput::make('motivo')->label('Motivo'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuario')->relationship('usuario','nombre')->label('Idusuario')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('activosFijo.nombre')->label('ActivosFijo'),
                \Filament\Tables\Columns\TextColumn::make('ubicacione.nombre')->label('Ubicacione'),
                \Filament\Tables\Columns\TextColumn::make('ubicacione.nombre')->label('Ubicacione'),
                \Filament\Tables\Columns\TextColumn::make('personalResponsable.nombre')->label('PersonalResponsable'),
                \Filament\Tables\Columns\TextColumn::make('personalResponsable.nombre')->label('PersonalResponsable'),
                \Filament\Tables\Columns\TextColumn::make('fecha')->label('Fecha'),
                \Filament\Tables\Columns\TextColumn::make('motivo')->label('Motivo'),
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Idusuario')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMovimientoss::route('/'),
            'create' => CreateMovimientos::route('/create'),
            'edit' => EditMovimientos::route('/{record}/edit'),
        ];
    }
}
