<?php

namespace App\Filament\Resources\UsuarioRol;

use App\Filament\Resources\UsuarioRol\Pages\ListUsuarioRols;
use App\Filament\Resources\UsuarioRol\Pages\CreateUsuarioRol;
use App\Filament\Resources\UsuarioRol\Pages\EditUsuarioRol;
use App\Models\UsuarioRol;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UsuarioRolResource extends Resource
{
    protected static ?string $model = UsuarioRol::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\BelongsToSelect::make('idUsuario')->relationship('usuario','nombre')->label('Usuario'),
                \Filament\Forms\Components\BelongsToSelect::make('idRol')->relationship('role','nombre')->label('Role'),
                \Filament\Forms\Components\TextInput::make('primary')->label('Primary')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('usuario.nombre')->label('Usuario'),
                \Filament\Tables\Columns\TextColumn::make('role.nombre')->label('Role'),
                \Filament\Tables\Columns\TextColumn::make('primary')->label('Primary')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsuarioRols::route('/'),
            'create' => CreateUsuarioRol::route('/create'),
            'edit' => EditUsuarioRol::route('/{record}/edit'),
        ];
    }
}
