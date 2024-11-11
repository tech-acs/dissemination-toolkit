<?php

namespace Uneca\DisseminationToolkit\Actions;

use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Indicator;
use Illuminate\Support\Collection;

class BuildDatasetAction
{
    private Collection $dimensionNameLookups;
    private Collection $dimensionValueLookups;
    private Collection $indicatorNameLookups;
    private Collection $areaLookups;

    public function __construct(public Dataset $dataset) {
        $this->dimensionNameLookups = $this->dataset->dimensions->pluck('name', 'foreign_key');
        $this->indicatorNameLookups = Indicator::pluck('name', 'id');
        $this->areaLookups = Area::pluck('name', 'id');
        $this->dimensionValueLookups = $this->dataset->dimensions
            ->mapWithKeys(fn ($dimension) => [$dimension->foreign_key => $dimension->values()->pluck('name', 'id')]);
    }

    public function handle()
    {
        return $this->dataset
            ->observations()
            ->map(function ($row) {
                $row->key = collect((array) $row)
                    ->except(['value', 'indicator_id'])
                    ->join('.');
                return $row;
            })
            ->groupBy('key')
            ->map(function ($group) {
                return $group
                    ->map(function ($obs) {
                        $newIndicatorKey = $this->indicatorNameLookups[$obs->indicator_id];
                        $obs->{$newIndicatorKey} = $obs->value;
                        unset($obs->indicator_id, $obs->key, $obs->value);
                        collect(get_object_vars($obs))
                            ->keys()
                            ->filter(fn($key) => str($key)->endsWith('_id') && $key !== 'area_id')
                            ->each(function ($key) use ($obs) {
                                $obs->{$this->dimensionNameLookups[$key]} = $this->dimensionValueLookups[$key][$obs->{$key}];
                                unset($obs->{$key});
                                return $obs;
                            });
                        $obs->Area = $this->areaLookups[$obs->area_id] ?? null;
                        unset($obs->area_id);
                        return $obs;
                    })
                    ->reduce(function ($carry, $obs) {
                        return array_merge($carry, (array) $obs);
                    }, []);
            })
            ->values();
    }
}
