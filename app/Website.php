<?php

namespace App;

use App\Rules\UrlTextarea;
use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Website extends Model implements HasMedia
{
    use SoftDeletes, Description, HasMediaTrait;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    const MEDIA_COLLECTION = 'websites';

    public function rules()
    {
        return [
//            'organization_type_id' => 'required|exists:organization_types,id',
            'themes' => 'nullable',
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('websites')->whereNull('deleted_at')->ignore($this->id)
            ],
            'perimeters' => 'nullable|array',
            'perimeter_comments' => 'nullable',
            'delay' => 'nullable',
            'allocated_budget' => 'nullable',
            'beneficiaries' => 'nullable',
            'website_url' => ['nullable', new UrlTextarea],
            'description' => 'nullable',
            'logo' => 'image',
        ];
    }

//    public function organizationType()
//    {
//        return $this->belongsTo(OrganizationType::class);
//    }

    public function perimeters()
    {
        return $this->belongsToMany(Perimeter::class, 'perimeters_websites', 'website_id', 'perimeter_id');
    }

    public function addLogo()
    {
        $this->clearMediaCollection(static::MEDIA_COLLECTION);
        $this->addMediaFromRequest('logo')->toMediaCollection(static::MEDIA_COLLECTION);
    }

    public function getLogo()
    {
        if (empty($logo = $this->getFirstMedia(static::MEDIA_COLLECTION))) {
            return null;
        }

//        return $logo->getUrl();
        
        // Init path: https://dreal.loc/storage/1/400.jpg
        // Final path returned: /storage/1/400.jpg

        return substr($logo->getUrl(), strpos($logo->getUrl(), config('app.domain')) + strlen(config('app.domain')));
    }

    // Attributes casting
    public function setThemesAttribute($value)
    {
        $this->attributes['themes'] = nl2br($value);
    }

    public function getThemesAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getThemesHtmlAttribute()
    {
        return nl2br($this->themes);
    }

    public function setPerimeterCommentsAttribute($value)
    {
        $this->attributes['perimeter_comments'] = nl2br($value);
    }

    public function getPerimeterCommentsAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getPerimeterCommentsHtmlAttribute()
    {
        return nl2br($this->perimeter_comments);
    }

    public function setDelayAttribute($value)
    {
        $this->attributes['delay'] = nl2br($value);
    }

    public function getDelayAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getDelayHtmlAttribute()
    {
        return nl2br($this->delay);
    }

    public function setAllocatedBudgetAttribute($value)
    {
        $this->attributes['allocated_budget'] = nl2br($value);
    }

    public function getAllocatedBudgetAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getAllocatedBudgetHtmlAttribute()
    {
        return nl2br($this->allocated_budget);
    }

    public function setBeneficiariesAttribute($value)
    {
        $this->attributes['beneficiaries'] = nl2br($value);
    }

    public function getBeneficiariesAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function getBeneficiariesHtmlAttribute()
    {
        return nl2br($this->beneficiaries);
    }

    public function getUrlArrayAttribute()
    {
        return explode(PHP_EOL, $this->attributes['website_url']);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
//    public function toSearchableArray()
//    {
//        $this->load(['organizationType', 'perimeters']);
//
//        $this->makeHidden([
//            'created_at',
//            'deleted_at',
//            'updated_at',
//        ]);
//
//        $array = $this->toArray();
//
//        if (!empty($this->organizationType->name)) {
//            $array['organization_type'] = $this->organizationType->name;
//        }
//
//        $array['perimeters'] = $this->perimeters->pluck('name')->implode(' , ');
//
//        return $array;
//    }
}
