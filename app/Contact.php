<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Contact extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            Mail::send(new \App\Mail\Contact($item));
        });
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'subject' => 'required|min:2',
            'email' => 'required|min:2|max:255',
            'message' => 'required|min:2',
        ];
    }
}
