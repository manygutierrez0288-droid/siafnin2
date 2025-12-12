<?php

namespace App\Filament\Resources\Mantenimientos;

use App\Filament\Resources\Mantenimientos\Pages\ListMantenimientoss;
use App\Filament\Resources\Mantenimientos\Pages\CreateMantenimientos;
use App\Filament\Resources\Mantenimientos\Pages\EditMantenimientos;
use App\Models\Mantenimiento;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MantenimientoResource extends Resource
{
    protected static ?string $model = Mantenimiento::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\BelongsToSelect::make('idActivoFijo')->relationship('activosFijo','nombre')->label('ActivosFijo'),
                \Filament\Forms\Components\TextInput::make('fecha')->label('Fecha'),
                \Filament\Forms\Components\TextInput::make('descripcion')->label('Descripcion'),
                \Filament\Forms\Components\TextInput::make('costo')->label('Costo'),
                \Filament\Forms\Components\BelongsToSelect::make('idTecnico')->relationship('tecnico','nombre')->label('Tecnico'),
                \Filament\Forms\Components\BelongsToSelect::make('idProveedor')->relationship('proveedore','nombre')->label('Proveedore'),
                \Filament\Forms\Components\BelongsToSelect::make('idEstado')->relationship('estadosActivo','nombre')->label('EstadosActivo'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuario')->relationship('usuario','nombre')->label('Usuario'),
                \Filament\Forms\Components\TextInput::make('fechaCreacion')->label('Fechacreacion')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('activosFijo.nombre')->label('ActivosFijo'),
                \Filament\Tables\Columns\TextColumn::make('fecha')->label('Fecha'),
                \Filament\Tables\Columns\TextColumn::make('descripcion')->label('Descripcion'),
                \Filament\Tables\Columns\TextColumn::make('costo')->label('Costo'),
                \Filament\Tables\Columns\TextColumn::make('tecnico.nombre')->label('Tecnico'),
                \Filament\Tables\Columns\TextColumn::make('proveedore.nombre')->label('Proveedore'),
                \Filament\Tables\Columns\TextColumn::make('estadosActivo.nombre')->label('EstadosActivo'),
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario'),
                \Filament\Tables\Columns\TextColumn::make('fechaCreacion')->label('Fechacreacion')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMantenimientoss::route('/'),
            'create' => CreateMantenimientos::route('/create'),
            'edit' => EditMantenimientos::route('/{record}/edit'),
        ];
    }
}
