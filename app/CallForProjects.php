<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CallForProjects extends Model implements Feedable, HasMedia
{
    use SoftDeletes, HasSlug, Searchable, HasMediaTrait;

    protected $guarded = [];
    protected $dates = ['deleted_at', 'closing_date'];
    protected $casts = [
        'is_news' => 'boolean',
        'allocation_global' => 'boolean',
        'allocation_per_project' => 'boolean',
    ];

    protected $table = 'calls_for_projects';

    protected $hidden = ['is_news', 'deleted_at', 'editor_id'];

    protected $touches = ['perimeters', 'beneficiaries', 'projectHolders', 'thematic', 'subthematic'];

    const MEDIA_COLLECTION = 'calls_for_projects';

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

            if (Auth::check()) {
                $item->editor_id = Auth::user()->id;
            }
        });

        static::saved(function ($model) {
            $model->projectHolders()->sync(request()->get('project_holders'));
            $model->perimeters()->sync(request()->get('perimeters'));
            $model->beneficiaries()->sync(request()->get('beneficiaries'));
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
                    $query->whereNull('parent_id')->whereNull('deleted_at');
                }),
            ],
            'subthematic_id' => [
                'nullable',
                Rule::exists('thematics', 'id')->where(function ($query) {
                    $query->whereNotNull('parent_id')->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('calls_for_projects')->where(function ($query) {
                    if (empty(request()->get('thematic_id')) && empty(request()->get('subthematic_id'))) {
                        return $query;
                    }

                    if (!empty(request()->get('thematic_id'))) {
                        $query = $query->where('thematic_id', request()->get('thematic_id'));
                    }
                    if (!empty(request()->get('subthematic_id'))) {
                        $query = $query->where('subthematic_id', request()->get('subthematic_id'));
                    }

                    return $query->whereNull('deleted_at');
                })->ignore($this->id)
            ],
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
            // Max file size : 5MB
            'file' => 'file|max:5120',
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
        return $this->belongsToMany(Perimeter::class, 'call_for_projects_perimeters', 'call_for_project_id', 'perimeter_id');
    }

    public function beneficiaries()
    {
        return $this->belongsToMany(Beneficiary::class, 'beneficiaries_call_for_projects', 'call_for_project_id', 'beneficiary_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class);
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

    public function scopeOfTheWeek($query, $start_date = null, $end_date = null)
    {
        if (is_null($start_date)) {
            $start_date = Carbon::now()->startOfWeek();
        }

        if (is_null($end_date)) {
            $end_date = Carbon::now()->endOfWeek();
        }

        return $query
            ->where('is_news', 1)
            ->whereBetween('updated_at', [$start_date->format('Y-m-d 00:00:00'), $end_date->format('Y-m-d 23:59:59')]);
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

    public function scopeWithinLastDays($query, $nbDays)
    {
        return $query->whereDate('updated_at', '>=', now()->startOfDay()->subDays($nbDays));
    }

    public function scopeWithinLastMonths($query, $nbMonths)
    {
        return $query->whereDate('updated_at', '>=', now()->startOfDay()->subMonths($nbMonths));
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

    public function isOpened()
    {
        return is_null($this->closing_date) || $this->closing_date >= date('Y-m-d 00:00:00');
    }

    public function isClosed()
    {
        return !$this->isOpened();
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

    public function normalizeFilename()
    {
        if (!request()->has('file')) {
            throw new FileNotFoundException('No input file.');
        }

        return str_slug($this->name) . '.' . request()->file('file')->getClientOriginalExtension();
    }

    public function addFile()
    {
        $this->clearMediaCollection(static::MEDIA_COLLECTION);
        $this->addMediaFromRequest('file')
             ->usingFileName($this->normalizeFilename())
             ->toMediaCollection(static::MEDIA_COLLECTION);
    }

    public function getFile()
    {
        if (empty($file = $this->getFirstMedia(static::MEDIA_COLLECTION))) {
            return null;
        }

        return $file->getUrl();
    }


    /**
     * Method used for the RSS feed
     *
     * @return array|\Spatie\Feed\FeedItem|void
     */
    public function toFeedItem()
    {
        return FeedItem::create()
                       ->id($this->slug)
                       ->title($this->name)
                       ->summary($this->objectives)
                       ->updated($this->updated_at)
                       ->link(route('front.dispositifs.unique', ['slug' => $this->slug]))
                       ->author(config('feed.author'));
    }

    public static function getFeedItems()
    {
        return self::latest('updated_at')->opened()->take(config('feed.itemsPerFeed'))->get();
    }

    public static function getFeedItemsByThematic($id)
    {
        return self::where('thematic_id', $id)->opened()->latest('updated_at')->take(config('feed.itemsPerFeed'))->get();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $this->load(['thematic', 'subthematic', 'projectHolders', 'beneficiaries', 'perimeters']);

        $this->makeHidden([
            'created_at',
            'deleted_at',
            'updated_at',
            'closing_date',
            'is_news',
            'editor_id',
        ]);

        $array = $this->toArray();

        // Call for project is opened or closed
        $array['is_closed'] = (integer)$this->isClosed();

        $array = $this->transform($array);

        $array['thematic'] = $this->thematic->only(['id', 'name', 'description']);

        if (!empty($this->subthematic->id)) {
            $array['subthematic'] = $this->subthematic->only(['id', 'name', 'description']);;
        }

        $array['project_holders'] = $this->projectHolders->map(function ($item) {
            return $item->only(['id', 'name', 'description']);
        });

        $array['beneficiaries'] = $this->beneficiaries->map(function ($item) {
            return $item->only(['id', 'name', 'description', 'type', 'type_label']);
        });

        $array['perimeters'] = $this->perimeters->map(function ($item) {
            return $item->only(['id', 'name', 'description']);
        });

        $array['perimeters'] = $this->perimeters->map(function ($item) {
            return $item->only(['id', 'name', 'description']);
        });

        return $array;
    }
}
