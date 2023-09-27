<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Column::macro('sortableMany', function () {
            /** @var Column $this */
            return $this->sortable(query: function (Builder $query, string $direction, $column): Builder {
                [$table, $field] = explode('.', $column->getName());

                return $query->withAggregate($table, $field)
                    ->orderBy(implode('_', [$table, $field]), $direction);
            });
        });

        Model::unguard();

        Carbon::macro('formattedCustom', static function () {
            return Carbon::this()->format('Y-m-d, H:i');
        });
    }
}
