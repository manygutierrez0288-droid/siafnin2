<?php

namespace App\Filament\Resources\Proveedors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ProveedorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('email')->label('Email')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('telefono')->label('Teléfono'),
                \Filament\Tables\Columns\TextColumn::make('numero_ruc')->label('RUC'),
                \Filament\Tables\Columns\TextColumn::make('direccion')->label('Dirección'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
