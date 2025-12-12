<?php

namespace App\Filament\Resources\Tecnicos;

use App\Filament\Resources\Tecnicos\Pages\ListTecnicoss;
use App\Filament\Resources\Tecnicos\Pages\CreateTecnicos;
use App\Filament\Resources\Tecnicos\Pages\EditTecnicos;
use App\Models\Tecnico;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TecnicoResource extends Resource
{
    protected static ?string $model = Tecnico::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\TextInput::make('nombre')->label('Nombre')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTecnicoss::route('/'),
            'create' => CreateTecnicos::route('/create'),
            'edit' => EditTecnicos::route('/{record}/edit'),
        ];
    }
}
