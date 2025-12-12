<?php

namespace App\Filament\Resources\Departamentos;

use App\Filament\Resources\Departamentos\Pages\ListDepartamentoss;
use App\Filament\Resources\Departamentos\Pages\CreateDepartamentos;
use App\Filament\Resources\Departamentos\Pages\EditDepartamentos;
use App\Models\Departamento;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DepartamentoResource extends Resource
{
    protected static ?string $model = Departamento::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre'),
                \Filament\Forms\Components\TextInput::make('activo')->label('Activo')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                \Filament\Tables\Columns\TextColumn::make('activo')->label('Activo')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartamentoss::route('/'),
            'create' => CreateDepartamentos::route('/create'),
            'edit' => EditDepartamentos::route('/{record}/edit'),
        ];
    }
}
