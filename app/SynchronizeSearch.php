<?php

namespace App;

trait SynchronizeSearch
{
    protected static function bootSynchronizeSearch()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->callsForProjects->filter(function ($item) {
                return $item->shouldBeSearchable();
            })->searchable();
        });
    }
}