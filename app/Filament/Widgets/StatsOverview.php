<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Job;
use App\Models\Tender;
use App\Models\Training;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jobs', Job::Available()->count()),
            Stat::make('Trainings', Training::Available()->count()),
            Stat::make('Tenders', Tender::Available()->count()),
            Stat::make('Companies', Company::count()),
        ];
    }
}
