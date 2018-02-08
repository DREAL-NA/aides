<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectHolder extends Model
{
    use SoftDeletes, Description;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    const URI_NAME = 'proje';

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'description' => 'present',
        ];
    }
}
