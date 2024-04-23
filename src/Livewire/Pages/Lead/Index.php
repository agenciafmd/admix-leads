<?php

namespace Agenciafmd\Leads\Livewire\Pages\Lead;

use Agenciafmd\Admix\Livewire\Pages\Base\Index as BaseIndex;
use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateTimeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class Index extends BaseIndex
{
    protected $model = Lead::class;

    protected string $indexRoute = 'admix.leads.index';

    protected string $trashRoute = 'admix.leads.trash';

    protected string $creteRoute = 'admix.leads.create';

    protected string $editRoute = 'admix.leads.edit';

    public function configure(): void
    {
        $this->packageName = __(config('admix-leads.name'));

        parent::configure();
    }

    public function filters(): array
    {
        $strongTableFromBuilder = $this->builder()
            ->getModel()
            ->getTable();

        $this->setAdditionalFilters([
            TextFilter::make(__('admix-leads::fields.email'), 'email')
                ->filter(static function (Builder $builder, string $value) use ($strongTableFromBuilder) {
                    $builder->where("{$strongTableFromBuilder}.email", 'LIKE', "%{$value}%");
                }),
            DateTimeFilter::make(__('admix::fields.initial_date'), 'initial_date')
                ->filter(static function (Builder $builder, string $value) use ($strongTableFromBuilder) {
                    $builder->where("{$strongTableFromBuilder}.created_at", '>=', Carbon::parse($value)
                        ->format('Y-m-d H:i:s'));
                }),
            DateTimeFilter::make(__('admix::fields.end_date'), 'end_date')
                ->filter(static function (Builder $builder, string $value) use ($strongTableFromBuilder) {
                    $builder->where("{$strongTableFromBuilder}.created_at", '<=', Carbon::parse($value)
                        ->format('Y-m-d H:i:s'));
                }),
        ]);

        return parent::filters();
    }

    public function columns(): array
    {
        $this->setAdditionalColumns([
            Column::make(__('admix-leads::fields.email'), 'email')
                ->sortable()
                ->searchable(),
            Column::make(__('admix-leads::fields.created_at'), 'created_at')
                ->sortable()
                ->searchable()
                ->format(static function ($value) {
                    return $value->format(config('admix.timestamp.format'));
                }),
        ]);

        return parent::columns();
    }
}
