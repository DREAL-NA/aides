<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Perimeter extends Model
{
    use SoftDeletes, Description;

    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at', 'pivot'];

    const URI_NAME = 'perim';

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('perimeters')->whereNull('deleted_at')->ignore($this->id)
            ],
            'description' => 'nullable',
            'parents' => ['array'],
            'parents.*' => [Rule::exists('perimeters', 'id')->whereNull('deleted_at')->whereNot('id', $this->id)]
        ];
    }

    public function parents()
    {
        return $this->belongsToMany(self::class, 'perimeters_parents', 'child_id', 'parent_id');
    }
}
