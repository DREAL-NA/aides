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
    const TYPE_ASSOCIATION = 5;
    const TYPE_CITIZEN = 6;

    protected $guarded = [];
    protected $appends = ['name_complete'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at', 'pivot'];

    const URI_NAME = 'benef';

    public static function types()
    {
        return collect([
            self::TYPE_STATE => 'État',
            self::TYPE_ASSOCIATION => 'Association',
            self::TYPE_COLLECTIVITY => 'Collectivité',
            self::TYPE_COMPANY => 'Entreprise',
            self::TYPE_CITIZEN => 'Particulier / Citoyen',
            self::TYPE_OTHER => 'Un autre acteur du territoire',
        ]);
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(self::types()->keys()->toArray()),
            ],
            'name' => [
                'nullable',
                'min:2',
                'max:255',
                Rule::unique('beneficiaries')->where(function ($query) {
                    if (empty(request()->get('type'))) {
                        return $query;
                    }

                    return $query->where('type', request()->get('type'))->whereNull('deleted_at');
                })->ignore($this->id)
            ],
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
