<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CallForProjects extends Model
{
    use SoftDeletes, HasSlug;

    protected $guarded = [];
    protected $dates = ['deleted_at', 'closing_date'];
    protected $casts = [
        'is_news' => 'boolean',
        'allocation_global' => 'boolean',
        'allocation_per_project' => 'boolean',
    ];

    protected $table = 'calls_for_projects';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
//            if (empty(request()->get('allocation_global'))) {
//                $item->allocation_global = 0;
//            }
//            if (empty(request()->get('allocation_per_project'))) {
//                $item->allocation_per_project = 0;
//            }

            $item->editor_id = Auth::user()->id;
        });

        static::saved(function ($item) {
            $item->projectHolders()->sync(request()->get('project_holders'));
            $item->perimeters()->sync(request()->get('perimeters'));
            $item->beneficiaries()->sync(request()->get('beneficiaries'));
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(200)
            ->usingLanguage('fr');
    }

    public function rules()
    {
        return [
            'thematic_id' => [
                'required',
                Rule::exists('thematics', 'id')->where(function ($query) {
                    $query->whereNull('parent_id');
                }),
            ],
            'subthematic_id' => [
                'nullable',
                Rule::exists('thematics', 'id')->where(function ($query) {
                    $query->whereNotNull('parent_id');
                }),
            ],
            'name' => 'required|min:2|max:255',
            'closing_date' => 'nullable|date_format:Y-m-d',
            'project_holders' => 'nullable|exists:project_holders,id',
            'project_holder_contact' => 'nullable',
            'perimeters' => 'nullable|exists:perimeters,id',
            'objectives' => 'nullable|min:2',
            'beneficiaries' => 'nullable|exists:beneficiaries,id',
            'beneficiary_comments' => 'nullable',
//			'allocation_global'      => 'required_without:allocation_per_project|in:1',
//			'allocation_per_project' => 'required_without:allocation_global|in:1',
            'allocation_global' => 'in:1',
            'allocation_per_project' => 'in:1',
            'allocation_amount' => 'nullable',
            'allocation_comments' => 'nullable',
            'technical_relay' => 'nullable',
            'website_url' => 'nullable|url',
            'is_news' => 'required|in:0,1',
        ];
    }

    public function thematic()
    {
        return $this->belongsTo(Thematic::class);
    }

    public function subthematic()
    {
        return $this->belongsTo(Thematic::class);
    }

    public function projectHolders()
    {
        return $this->belongsToMany(ProjectHolder::class, 'call_for_projects_project_holders', 'call_for_project_id',
            'project_holder_id');
    }

    public function perimeters()
    {
        return $this->belongsToMany(Perimeter::class, 'call_for_projects_perimeters', 'call_for_project_id',
            'perimeter_id');
    }

    public function beneficiaries()
    {
        return $this->belongsToMany(Beneficiary::class, 'beneficiaries_call_for_projects', 'call_for_project_id',
            'beneficiary_id');
    }

    public function scopeClosed($query)
    {
        return $query->whereDate('closing_date', '<', date('Y-m-d 00:00:00'));
    }

    public function scopeOpened($query)
    {
        //		return $query->whereDate('closing_date', '>=', date('Y-m-d 00:00:00'))->orWhereRaw('closing_date is null', []);
        return $query->whereDate('closing_date', '>=', date('Y-m-d 00:00:00'))->orWhereNull('closing_date');
    }

    public function scopeOfTheWeek($query)
    {
        $start_date = Carbon::now()->startOfWeek();
        $end_date = Carbon::now()->endOfWeek();

        return $query
            ->where('is_news', 1)
            ->whereBetween('created_at', [$start_date->format('Y-m-d 00:00:00'), $end_date->format('Y-m-d 23:59:59')]);
    }

    public function scopeClosingDateNull($query)
    {
        return $query->whereNull('closing_date');
    }

    public function scopeClosingDateNotNull($query)
    {
        return $query->whereNotNull('closing_date');
    }

    public function scopeClosingDateAfter($query, $date)
    {
        if (!$date instanceof Carbon) {
            $date = Carbon::createFromFormat('d/m/Y', $date);
        }
        return $query->whereDate('closing_date', '>=', $date->format('Y-m-d 00:00:00'));
    }

    // retrieve relationships data with call for projects
    public static function filterDataById($items, $data_id_name)
    {
        return $items->reject(function ($item) use ($data_id_name) {
            return is_null($item->{$data_id_name});
        })->map(function ($item) use ($data_id_name) {
            return $item->{$data_id_name};
        })->unique()->values();
    }

    public static function getRelationshipData($class, $items, $data_id_name)
    {
        $ids = self::filterDataById($items, $data_id_name);

        if ($ids->isEmpty()) {
            return collect();
        }

        return $class::whereIn('id', $ids)->get();
    }

    public static function filterCallsOfTheWeek($items)
    {
        return $items->filter(function ($item) {
            return $item->isOfTheWeek();
        });
    }

    public function isOfTheWeek()
    {
        $start_date = Carbon::now()->startOfWeek();
        $end_date = Carbon::now()->endOfWeek();

        return $this->is_news && $this->created_at >= $start_date && $this->created_at <= $end_date;
    }

    // Attributes casting
    public function setObjectivesAttribute($value)
    {
        $this->attributes['objectives'] = nl2br($value);
    }

    public function getObjectivesAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function setProjectHolderContactAttribute($value)
    {
        $this->attributes['project_holder_contact'] = nl2br($value);
    }

    public function getProjectHolderContactAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function setBeneficiaryCommentsAttribute($value)
    {
        $this->attributes['beneficiary_comments'] = nl2br($value);
    }

    public function getBeneficiaryCommentsAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function setAllocationCommentsAttribute($value)
    {
        $this->attributes['allocation_comments'] = nl2br($value);
    }

    public function getAllocationCommentsAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }

    public function setTechnicalRelayAttribute($value)
    {
        $this->attributes['technical_relay'] = nl2br($value);
    }

    public function getTechnicalRelayAttribute($value)
    {
        return preg_replace('#<br\s*/?>#i', "", $value);
    }
}
