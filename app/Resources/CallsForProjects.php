<?php

namespace App\Resources;

use App\Beneficiary;
use App\CallForProjects;
use App\Helpers\Date;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use Illuminate\Support\Collection;

class CallsForProjects
{
    /** @var string The way to ordering results. */
    protected $orderByRaw = '-closing_date desc';

    /** @var string Return the closed calls for projects or not. */
    protected $closed = false;

    /** @var string The number of results per page for the pagination. */
    protected $perPage;

    /** @var string The parameters appended to the pagination links. */
    public $paginationAppends = [];

    /** @var string The model instance. */
    protected $instance;

    /** @var \Illuminate\Support\Collection The list of parameters to return on the controller */
    public $parameters;

    /** @var string The relationships used for the eager loading. */
    protected $with = [
        'thematic',
        'subthematic',
        'projectHolders',
        'perimeters',
        'beneficiaries',
        'media'
    ];

    public function __construct()
    {
        $this->setPerPage(config('app.pagination.perPage'));

        $this->instance = CallForProjects::with($this->with);

        $this->parameters = new Collection();
    }

    /**
     * Setter used when we determine if we get opened or closed calls for projects.
     *
     * @param bool $closed
     *
     * @return bool
     */
    public function setClosed($closed)
    {
        return $this->closed = $closed === 'clotures' ?? true;
    }

    /**
     * Set the per page pagination value.
     *
     * @param int $perPage
     */
    protected function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Set the ordering.
     *
     * @param string $orderByRaw
     */
    protected function setOrderByRaw($orderByRaw)
    {
        $this->orderByRaw = $orderByRaw;
    }


    /**
     * Set an entry for the paginationAppend array.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function setPaginationAppend($key, $value)
    {
        $this->paginationAppends[$key] = $value;
    }

    /**
     * Set the parameters for the paginated appends and initialiaze the instance we wan the results.
     */
    protected function setParametersIntanceAndPagination()
    {
        $this->parameters['perimeter'] = null;

        $request = request();

        // Check if we have perimeters
        if (!empty($paramPerims = $request->get(Perimeter::URI_NAME))) {
            $this->parameters['perimeter'] = collect($request->get(Perimeter::URI_NAME));
        }

        // Check if we have a quick search on perimeters
        if (
            !empty($paramPerimExt = $request->get(Perimeter::URI_NAME . '_ext'))
            && !is_null($perimeterExtended = Perimeter::with('parents')->whereId($paramPerimExt)->first())
        ) {
            $this->parameters['perimeter'] = collect([$perimeterExtended->id])->push($perimeterExtended->parents->pluck('id'))->flatten();
        }

        // According perimeters parameter
        if (!is_null($this->parameters['perimeter'])) {
            $this->instance->whereHas('perimeters', function ($query) {
                $query->whereIn('perimeter_id', $this->parameters['perimeter']);
            });
            $this->setPaginationAppend(Perimeter::URI_NAME, $request->get(Perimeter::URI_NAME));
        }

        // According thematics parameter
        if (!empty($request->get(Thematic::URI_NAME_THEMATIC))) {
            $this->instance->whereIn('thematic_id', $request->get(Thematic::URI_NAME_THEMATIC));
            $this->setPaginationAppend(Thematic::URI_NAME_THEMATIC, $request->get(Thematic::URI_NAME_THEMATIC));
        }

        // According subthematics parameter
        if (!empty($request->get(Thematic::URI_NAME_SUBTHEMATIC))) {
            $this->instance->whereIn('subthematic_id', $request->get(Thematic::URI_NAME_SUBTHEMATIC));
            $this->setPaginationAppend(Thematic::URI_NAME_SUBTHEMATIC, $request->get(Thematic::URI_NAME_SUBTHEMATIC));
        }

        // According project holders parameter
        if (!empty($request->get(ProjectHolder::URI_NAME))) {
            $this->instance->whereHas('projectHolders', function ($query) use ($request) {
                $query->whereIn('project_holder_id', $request->get(ProjectHolder::URI_NAME));
            });
            $this->setPaginationAppend(ProjectHolder::URI_NAME, $request->get(ProjectHolder::URI_NAME));
        }

        // According beneficiaries parameter
        if (!empty($request->get(Beneficiary::URI_NAME))) {
            $this->instance->whereHas('beneficiaries', function ($query) use ($request) {
                $query->whereIn('type', $request->get(Beneficiary::URI_NAME));
            });
            $this->setPaginationAppend(Beneficiary::URI_NAME, $request->get(Beneficiary::URI_NAME));
        }

        // According date parameter
        if (!empty($request->get('date_null')) && $request->get('date_null') === 1) {
            $this->instance->closingDateNull();
        } elseif (!empty($request->get('date')) && Date::isValid($request->get('date'))) {
            $this->instance->closingDateAfter($request->get('date'));
        }
    }

    /**
     * Determine if we get opened or closed calls for projects.
     */
    public function prepare()
    {
        if ($this->closed === false) {
            $this->instance->opened();
        } else {
            $this->instance->closed();
        }

        if (!empty(request()->all())) {
            $this->setParametersIntanceAndPagination();
        }
    }

    /**
     * Return the paginated results.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = -1)
    {
        if ($perPage !== -1) {
            $this->setPerPage($perPage);
        }

        $this->prepare();

        return $this->instance->paginate($this->perPage);
    }

    /**
     * Return the get model results.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get()
    {
        $this->prepare();

        return $this->instance->get();
    }
}