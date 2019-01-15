<?php

namespace App\Observers;

class SynchronizeCallsForProjects
{
    /**
     * Handle the "saved" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function saved($model)
    {
        $model->callsForProjects->filter(function ($item) {
            return $item->shouldBeSearchable();
        })->searchable();
    }
}
