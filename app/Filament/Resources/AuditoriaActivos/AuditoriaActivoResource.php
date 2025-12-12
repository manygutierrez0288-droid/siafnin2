<?php

namespace App\Filament\Resources\AuditoriaActivos;

use App\Filament\Resources\AuditoriaActivos\Pages\ListAuditoriaActivoss;
use App\Filament\Resources\AuditoriaActivos\Pages\CreateAuditoriaActivos;
use App\Filament\Resources\AuditoriaActivos\Pages\EditAuditoriaActivos;
use App\Models\AuditoriaActivo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AuditoriaActivoResource extends Resource
{
    protected static ?string $model = AuditoriaActivo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\BelongsToSelect::make('idActivoFijo')->relationship('activosFijo','nombre')->label('ActivosFijo'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuario')->relationship('usuario','nombre')->label('Usuario'),
                \Filament\Forms\Components\TextInput::make('tipo')->label('Tipo'),
                \Filament\Forms\Components\TextInput::make('detalle')->label('Detalle'),
                \Filament\Forms\Components\TextInput::make('fecha')->label('Fecha')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('activosFijo.nombre')->label('ActivosFijo'),
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario'),
                \Filament\Tables\Columns\TextColumn::make('tipo')->label('Tipo'),
                \Filament\Tables\Columns\TextColumn::make('detalle')->label('Detalle'),
                \Filament\Tables\Columns\TextColumn::make('fecha')->label('Fecha')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuditoriaActivoss::route('/'),
            'create' => CreateAuditoriaActivos::route('/create'),
            'edit' => EditAuditoriaActivos::route('/{record}/edit'),
        ];
    }
}
