<?php

namespace App\Resources;

use App\Beneficiary;
use App\CallForProjects;
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
    protected $relations = [
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

//        $this->instance = CallForProjects::with($this->with);
        $this->instance = CallForProjects::search(request()->get('query'));

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
//            $this->parameters['perimeter'] = collect($paramPerims);

            $this->parameters['perimeter_init'] = collect($paramPerims);

            // get perimeters with their parents
            $perimeters = Perimeter::has('parents')->with('parents:id')->whereIn('id', $this->parameters['perimeter_init'])->get(['id']);

            // Perimeters will have the fitlered ones and their parents
            $this->parameters['perimeter'] = collect($paramPerims)
                ->push(
                // The parents are pushed here
                    $perimeters->map(function ($perimeter) {
                        return $perimeter->parents->pluck('id')->flatten();
                    })
                )
                ->flatten()->unique()->filter();

            if (!empty($this->parameters['perimeter'])) {
                $this->instance->whereIn('perimeters.id', $this->parameters['perimeter']->toArray());

                $this->setPaginationAppend(Perimeter::URI_NAME, $this->parameters['perimeter']->all());
            }

        }

        // According perimeters parameter


        // According thematics parameter
        if (!empty($paramThema = $request->get(Thematic::URI_NAME_THEMATIC))) {
            $this->instance->whereIn('thematic_id', array_filter($paramThema));

            $this->setPaginationAppend(Thematic::URI_NAME_THEMATIC, $paramThema);
        }

        // According subthematics parameter ---
//        if (!empty($request->get(Thematic::URI_NAME_SUBTHEMATIC))) {
//            $this->instance->whereIn('subthematic_id', $request->get(Thematic::URI_NAME_SUBTHEMATIC));
//            $this->setPaginationAppend(Thematic::URI_NAME_SUBTHEMATIC, $request->get(Thematic::URI_NAME_SUBTHEMATIC));
//        }

        // According project holders parameter
        if (!empty($paramProjHold = $request->get(ProjectHolder::URI_NAME))) {
            $this->instance->whereIn('project_holders.id', array_filter($paramProjHold));

            $this->setPaginationAppend(ProjectHolder::URI_NAME, $paramProjHold);
        }

        // According beneficiaries parameter
        if (!empty($paramBenef = $request->get(Beneficiary::URI_NAME))) {
            $this->instance->whereIn('beneficiaries.type', array_filter($paramBenef));

            $this->setPaginationAppend(Beneficiary::URI_NAME, $paramBenef);
        }

        // According date parameter ---
//        if (!empty($request->get('date_null')) && $request->get('date_null') === 1) {
//            $this->instance->closingDateNull();
//        } elseif (!empty($request->get('date')) && Date::isValid($request->get('date'))) {
//            $this->instance->closingDateAfter($request->get('date'));
//        }
    }

    /**
     * Determine if we get opened or closed calls for projects.
     */
    public function prepare()
    {
        $this->instance->where('is_closed', (integer)$this->closed);

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

        $result = $this->instance->paginate($this->perPage);

        $result->load($this->relations);

        return $result;
    }

    /**
     * Return the get model results.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        $this->prepare();

        $result = $this->instance->get();

        $result->load($this->relations);

        return $result;
    }
}