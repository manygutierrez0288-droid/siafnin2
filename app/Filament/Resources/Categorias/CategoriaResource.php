<?php

namespace App\Filament\Resources\Categorias;

use App\Filament\Resources\Categorias\Pages\ListCategoriass;
use App\Filament\Resources\Categorias\Pages\CreateCategorias;
use App\Filament\Resources\Categorias\Pages\EditCategorias;
use App\Models\Categoria;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;

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
            'index' => ListCategoriass::route('/'),
            'create' => CreateCategorias::route('/create'),
            'edit' => EditCategorias::route('/{record}/edit'),
        ];
    }
}
