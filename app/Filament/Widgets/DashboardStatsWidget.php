<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Activo;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Activos', Activo::count())
                ->description('Registrados en el sistema')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-cube')
                ->chart([7, 4, 8, 5, 9, 6, 10]), // mini gráfico de tendencia (opcional, bonito)

            Stat::make('En Mantenimiento', Activo::where('estado', 'mantenimiento')->count())
                ->description('Requieren atención técnica')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning')
                ->icon('heroicon-o-wrench'),

            Stat::make('Bajados', Activo::where('estado', 'baja')->count())
                ->description('Fuera de inventario')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }
}