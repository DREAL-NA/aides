<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 17/01/2018
 * Time: 11:31
 */

namespace App\Traits;

trait Description
{
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = nl2br($value);
    }

    public function getDescriptionAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getDescriptionHtmlAttribute()
    {
        return nl2br($this->description);
    }
}