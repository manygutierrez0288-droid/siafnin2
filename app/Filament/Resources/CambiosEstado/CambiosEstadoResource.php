<?php

namespace App\Filament\Resources\CambiosEstado;

use App\Filament\Resources\CambiosEstado\Pages;
use App\Filament\Resources\CambiosEstado\RelationManagers;
use App\Models\CambiosEstado; // Asegúrate de que este modelo exista
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CambiosEstadoResource extends Resource
{
    protected static ?string $model = CambiosEstado::class;

    // Navegation group: usar el mismo tipo que la clase base (string|UnitEnum|null)
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión de Activos';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Cambio de Estado';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cambios de Estado';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
                \Filament\Forms\Components\Select::make('activo_id')
                    ->relationship('activo', 'codigo') // Asegúrate de tener la relación 'activo' en el modelo
                    ->required()
                    ->searchable()
                    ->preload(),

                \Filament\Forms\Components\Select::make('estado_anterior_id')
                    ->relationship('estadoAnterior', 'nombre')
                    ->searchable()
                    ->preload(),

                \Filament\Forms\Components\Select::make('estado_nuevo_id')
                    ->relationship('estadoNuevo', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),

                \Filament\Forms\Components\Textarea::make('motivo')
                    ->label('Motivo del cambio')
                    ->required()
                    ->maxLength(500),

                \Filament\Forms\Components\DatePicker::make('fecha_cambio')
                    ->label('Fecha del cambio')
                    ->required()
                    ->default(now()),

                \Filament\Forms\Components\TextInput::make('usuario')
                    ->default(auth()->user()?->name)
                    ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('activo.codigo')
                    ->label('Activo')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('estadoAnterior.nombre')
                    ->label('De')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('estadoNuevo.nombre')
                    ->label('A')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50),

                Tables\Columns\TextColumn::make('fecha_cambio')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('usuario')
                    ->label('Registrado por')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('activo_id')
                    ->relationship('activo', 'codigo'),
                Tables\Filters\SelectFilter::make('estado_nuevo_id')
                    ->relationship('estadoNuevo', 'nombre'),
                Tables\Filters\Filter::make('fecha_cambio')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde'),
                        Forms\Components\DatePicker::make('fecha_hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn (Builder $q, $date) => $q->whereDate('fecha_cambio', '>=', $date)
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn (Builder $q, $date) => $q->whereDate('fecha_cambio', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCambiosEstados::route('/'),
            'create' => Pages\CreateCambiosEstado::route('/create'),
            'edit' => Pages\EditCambiosEstado::route('/{record}/edit'),
        ];
    }
}