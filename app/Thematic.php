<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Thematic extends Model
{
    use SoftDeletes, Description;

    protected $guarded = [];
    protected $appends = ['slug'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at'];

    const URI_NAME_THEMATIC = 'thema';
    const URI_NAME_SUBTHEMATIC = 'subthema';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thematic) {
            $thematic->callForProjects()->delete();
        });
    }


    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('thematics')->where(function ($query) {
                    $query->whereNull('parent_id')
                        ->whereNull('deleted_at');
                })->ignore($this->id)
            ],
            'description' => 'present',
        ];
    }

    public function rulesSubthematic()
    {
        return [
            'name' => [
                'required',
                'min:2',
                Rule::unique('thematics')->where(function ($query) {
                    return $query->where('parent_id', request()->get('parent_id'))
                        ->whereNull('deleted_at');
                })->ignore($this->id)
            ],
            'description' => 'present',
            'parent_id' => [
                'required',
                Rule::exists('thematics', 'id')->where(function ($query) {
                    $query->whereNull('parent_id')
                        ->whereNull('deleted_at');
                }),
            ],
        ];
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function callForProjects()
    {
        return $this->hasMany(CallForProjects::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function scopePrimary($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSub($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function getSlugAttribute()
    {
        return str_slug($this->attributes['name']);
    }
}
