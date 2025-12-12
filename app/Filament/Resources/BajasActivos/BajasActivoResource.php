<?php

namespace App\Filament\Resources\BajasActivos;

use App\Filament\Resources\BajasActivos\Pages\ListBajasActivoss;
use App\Filament\Resources\BajasActivos\Pages\CreateBajasActivos;
use App\Filament\Resources\BajasActivos\Pages\EditBajasActivos;
use App\Models\BajasActivo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BajasActivoResource extends Resource
{
    protected static ?string $model = BajasActivo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\BelongsToSelect::make('idActivoFijo')->relationship('activosFijo','nombre')->label('ActivosFijo'),
                \Filament\Forms\Components\TextInput::make('fecha')->label('Fecha'),
                \Filament\Forms\Components\TextInput::make('motivo')->label('Motivo'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuario')->relationship('usuario','nombre')->label('Usuario'),
                \Filament\Forms\Components\TextInput::make('fechaCreacion')->label('Fechacreacion')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('activosFijo.nombre')->label('ActivosFijo'),
                \Filament\Tables\Columns\TextColumn::make('fecha')->label('Fecha'),
                \Filament\Tables\Columns\TextColumn::make('motivo')->label('Motivo'),
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario'),
                \Filament\Tables\Columns\TextColumn::make('fechaCreacion')->label('Fechacreacion')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBajasActivoss::route('/'),
            'create' => CreateBajasActivos::route('/create'),
            'edit' => EditBajasActivos::route('/{record}/edit'),
        ];
    }
}
