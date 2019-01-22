<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class ProjectHolder extends Model
{
    use SoftDeletes, Description;

    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at', 'pivot'];

    const URI_NAME = 'proje';

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('project_holders')->whereNull('deleted_at')->ignore($this->id)
            ],
            'description' => 'present',
        ];
    }

    public function callsForProjects()
    {
        return $this->belongsToMany(CallForProjects::class, 'call_for_projects_project_holders', 'project_holder_id', 'call_for_project_id');
    }
}
