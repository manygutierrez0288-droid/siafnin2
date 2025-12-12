<?php

namespace App\Filament\Resources\Usuarios;

use App\Filament\Resources\Usuarios\Pages\ListUsuarioss;
use App\Filament\Resources\Usuarios\Pages\CreateUsuarios;
use App\Filament\Resources\Usuarios\Pages\EditUsuarios;
use App\Models\Usuario;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UsuarioResource extends Resource
{
    protected static ?string $model = Usuario::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\TextInput::make('email')->label('Email'),
                \Filament\Forms\Components\TextInput::make('password_hash')->label('Password Hash'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuarioCreacion')->relationship('usuarioCreacion','nombre')->label('Idusuariocreacion'),
                \Filament\Forms\Components\TextInput::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Forms\Components\BelongsToSelect::make('idUsuarioUltimaModificacion')->relationship('usuarioUltimaModificacion','nombre')->label('Idusuarioultimamodificacion'),
                \Filament\Forms\Components\TextInput::make('fechaUltimaModificacion')->label('Fechaultimamodificacion'),
                \Filament\Forms\Components\TextInput::make('activo')->label('Activo')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('email')->label('Email'),
                \Filament\Tables\Columns\TextColumn::make('password_hash')->label('Password Hash'),
                \Filament\Tables\Columns\TextColumn::make('usuarioCreacion.nombre')->label('Idusuariocreacion'),
                \Filament\Tables\Columns\TextColumn::make('fechaCreacion')->label('Fechacreacion'),
                \Filament\Tables\Columns\TextColumn::make('usuarioUltimaModificacion.nombre')->label('Idusuarioultimamodificacion'),
                \Filament\Tables\Columns\TextColumn::make('fechaUltimaModificacion')->label('Fechaultimamodificacion'),
                \Filament\Tables\Columns\TextColumn::make('activo')->label('Activo')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsuarioss::route('/'),
            'create' => CreateUsuarios::route('/create'),
            'edit' => EditUsuarios::route('/{record}/edit'),
        ];
    }
}
