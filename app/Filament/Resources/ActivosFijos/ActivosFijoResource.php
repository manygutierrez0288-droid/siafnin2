<?php

namespace App\Filament\Resources\ActivosFijos;

use App\Filament\Resources\ActivosFijos\Pages\ListActivosFijoss;
use App\Filament\Resources\ActivosFijos\Pages\CreateActivosFijos;
use App\Filament\Resources\ActivosFijos\Pages\EditActivosFijos;
use App\Models\ActivosFijo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ActivosFijoResource extends Resource
{
    protected static ?string $model = ActivosFijo::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\BelongsToSelect::make('idMarca')->relationship('marca','nombre')->label('Marca'),
                \Filament\Forms\Components\BelongsToSelect::make('idModelo')->relationship('modelo','nombre')->label('Modelo'),
                \Filament\Forms\Components\BelongsToSelect::make('idColor')->relationship('colore','nombre')->label('Colore'),
                \Filament\Forms\Components\BelongsToSelect::make('idCategoria')->relationship('categoria','nombre')->label('Categoria'),
                \Filament\Forms\Components\BelongsToSelect::make('idDepartamento')->relationship('departamento','nombre')->label('Departamento'),
                \Filament\Forms\Components\BelongsToSelect::make('idUbicacion')->relationship('ubicacione','nombre')->label('Ubicacione'),
                \Filament\Forms\Components\BelongsToSelect::make('idFuente')->relationship('fuente','nombre')->label('Fuente'),
                \Filament\Forms\Components\BelongsToSelect::make('idProveedor')->relationship('proveedore','nombre')->label('Proveedore'),
                \Filament\Forms\Components\BelongsToSelect::make('idResponsable')->relationship('personalResponsable','nombre')->label('PersonalResponsable'),
                \Filament\Forms\Components\BelongsToSelect::make('idEstado')->relationship('estadosActivo','nombre')->label('EstadosActivo'),
                \Filament\Forms\Components\TextInput::make('fechaAdquisicion')->label('Fechaadquisicion'),
                \Filament\Forms\Components\TextInput::make('valorAdquisicion')->label('Valoradquisicion'),
                \Filament\Forms\Components\TextInput::make('vidaUtilAnios')->label('Vidautilanios'),
                \Filament\Forms\Components\TextInput::make('valorResidual')->label('Valorresidual'),
                \Filament\Forms\Components\TextInput::make('depreciacionAcumulada')->label('Depreciacionacumulada'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuarioCreacion')->relationship('usuario','nombre')->label('Usuario'),
                \Filament\Forms\Components\TextInput::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuarioUltimaModificacion')->relationship('usuarioUltimaModificacion','nombre')->label('Idusuarioultimamodificacion'),
                \Filament\Forms\Components\TextInput::make('fechaUltimaModificacion')->label('Fechaultimamodificacion')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('marca.nombre')->label('Marca'),
                \Filament\Tables\Columns\TextColumn::make('modelo.nombre')->label('Modelo'),
                \Filament\Tables\Columns\TextColumn::make('colore.nombre')->label('Colore'),
                \Filament\Tables\Columns\TextColumn::make('categoria.nombre')->label('Categoria'),
                \Filament\Tables\Columns\TextColumn::make('departamento.nombre')->label('Departamento'),
                \Filament\Tables\Columns\TextColumn::make('ubicacione.nombre')->label('Ubicacione'),
                \Filament\Tables\Columns\TextColumn::make('fuente.nombre')->label('Fuente'),
                \Filament\Tables\Columns\TextColumn::make('proveedore.nombre')->label('Proveedore'),
                \Filament\Tables\Columns\TextColumn::make('personalResponsable.nombre')->label('PersonalResponsable'),
                \Filament\Tables\Columns\TextColumn::make('estadosActivo.nombre')->label('EstadosActivo'),
                \Filament\Tables\Columns\TextColumn::make('fechaAdquisicion')->label('Fechaadquisicion'),
                \Filament\Tables\Columns\TextColumn::make('valorAdquisicion')->label('Valoradquisicion'),
                \Filament\Tables\Columns\TextColumn::make('vidaUtilAnios')->label('Vidautilanios'),
                \Filament\Tables\Columns\TextColumn::make('valorResidual')->label('Valorresidual'),
                \Filament\Tables\Columns\TextColumn::make('depreciacionAcumulada')->label('Depreciacionacumulada'),
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario'),
                \Filament\Tables\Columns\TextColumn::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Tables\Columns\TextColumn::make('usuarioUltimaModificacion.nombre')->label('Idusuarioultimamodificacion'),
                \Filament\Tables\Columns\TextColumn::make('fechaUltimaModificacion')->label('Fechaultimamodificacion')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivosFijoss::route('/'),
            'create' => CreateActivosFijos::route('/create'),
            'edit' => EditActivosFijos::route('/{record}/edit'),
        ];
    }
}
