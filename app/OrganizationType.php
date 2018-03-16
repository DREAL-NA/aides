<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class OrganizationType extends Model
{
    use SoftDeletes, Description;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($organization) {
            $organization->websites()->delete();
        });
    }


    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('organization_types')->ignore($this->id)
            ],
            'description' => 'present',
        ];
    }

    public function websites()
    {
        return $this->hasMany(Website::class);
    }
}
