<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\CallForProjects;
use App\Contact;
use App\Helpers\Date;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use App\Website;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function home()
    {
        $countCallsForProjects = CallForProjects::opened()->count();
        $thematics = Thematic::primary()->orderBy('name', 'asc')->get();
        $perimeters = Perimeter::orderBy('name', 'asc')->get();
        $callsOfTheWeek = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->ofTheWeek()->orderBy('updated_at', 'desc')->get()->groupBy('thematic_id');

        return view('front.home', compact('countCallsForProjects', 'thematics', 'perimeters', 'callsOfTheWeek'));
    }

    public function callForProjects(Request $request)
    {
        $callsForProjects = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->orderBy('updated_at', 'desc')->opened();

        $pagination_appends = [];
        if (!empty($request->get(Thematic::URI_NAME_THEMATIC))) {
            $callsForProjects->whereIn('thematic_id', $request->get(Thematic::URI_NAME_THEMATIC));
            $pagination_appends[Thematic::URI_NAME_THEMATIC] = $request->get(Thematic::URI_NAME_THEMATIC);
        }
        if (!empty($request->get(Thematic::URI_NAME_SUBTHEMATIC))) {
            $callsForProjects->whereIn('subthematic_id', $request->get(Thematic::URI_NAME_SUBTHEMATIC));
            $pagination_appends[Thematic::URI_NAME_SUBTHEMATIC] = $request->get(Thematic::URI_NAME_SUBTHEMATIC);
        }
        if (!empty($request->get(ProjectHolder::URI_NAME))) {
            $callsForProjects->whereHas('projectHolders', function ($query) use ($request) {
                $query->whereIn('project_holder_id', $request->get(ProjectHolder::URI_NAME));
            });
            $pagination_appends[ProjectHolder::URI_NAME] = $request->get(ProjectHolder::URI_NAME);
        }
        if (!empty($request->get(Perimeter::URI_NAME))) {
            $callsForProjects->whereHas('perimeters', function ($query) use ($request) {
                $query->whereIn('perimeter_id', $request->get(Perimeter::URI_NAME));
            });
            $pagination_appends[Perimeter::URI_NAME] = $request->get(Perimeter::URI_NAME);
        }
        if (!empty($request->get(Beneficiary::URI_NAME))) {
            $callsForProjects->whereHas('beneficiaries', function ($query) use ($request) {
                $query->whereIn('type', $request->get(Beneficiary::URI_NAME));
            });
            $pagination_appends[Beneficiary::URI_NAME] = $request->get(Beneficiary::URI_NAME);
        }
        if (!empty($request->get('date_null')) && $request->get('date_null') == 1) {
            $callsForProjects->closingDateNull();
        } elseif (!empty($request->get('date')) && Date::isValid($request->get('date'))) {
            $callsForProjects->closingDateAfter($request->get('date'));
        }

        $callsForProjects = $callsForProjects->paginate(20);

        $primary_thematics = Thematic::primary()->orderBy('name', 'asc')->get();
        $subthematics = Thematic::sub()->orderBy('name', 'asc')->get();
        if (!empty($subthematics)) {
            $subthematics = $subthematics->groupBy('parent_id');
        }
        $perimeters = Perimeter::orderBy('name', 'asc')->get();
        $project_holders = ProjectHolder::orderBy('name', 'asc')->get();

        return view('front.call-for-projects',
            compact('callsForProjects', 'primary_thematics', 'subthematics', 'perimeters', 'project_holders',
                'pagination_appends'));
    }

    public function callForProjectsUnique($slug, Request $request)
    {
        $callForProjects = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->where('slug', $slug)->first();

        if (empty($callForProjects)) {
            abort(404);
        }

        return view('front.call-for-projects-unique', compact('callForProjects'));
    }

    public function websites() {
        $websites = Website::with(['organizationType', 'perimeters'])->get()->sortBy('name');

        return view('front.tools.website-library', compact('websites'));
    }

    public function contactStore(Request $request)
    {
        $contact = new Contact();
        $validatedData = $request->validate($contact->rules());

        $contact->fill($validatedData);
        $contact->save();

        return redirect(route('front.contact'))->with('success',
            "Merci, votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.");
    }
}
