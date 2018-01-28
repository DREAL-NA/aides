<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Beneficiary extends Model
{
    use SoftDeletes, Description;

    const TYPE_STATE = 1;
    const TYPE_COLLECTIVITY = 2;
    const TYPE_COMPANY = 3;
    const TYPE_OTHER = 4;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    const URI_NAME = 'benef';

    public static function types()
    {
        return collect([
            self::TYPE_STATE => 'État',
            self::TYPE_COLLECTIVITY => 'Collectivité',
            self::TYPE_COMPANY => 'Entreprise',
            self::TYPE_OTHER => 'Autre',
        ]);
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(self::types()->keys()->toArray()),
            ],
            'name' => 'nullable|min:2',
            'description' => 'present',
        ];
    }

    public function getTypeLabelAttribute()
    {
        return self::types()[$this->attributes['type']];
    }

    public function getNameCompleteAttribute()
    {
        return self::types()[$this->attributes['type']] . (empty($this->attributes['name']) ? '' : ' | ' . $this->attributes['name']);
    }
}
