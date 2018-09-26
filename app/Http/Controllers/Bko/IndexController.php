<?php

namespace App\Http\Controllers\Bko;

use App\Beneficiary;
use App\CallForProjects;
use App\Http\Controllers\Controller;
use App\NewsletterSubscriber;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use App\Website;

class IndexController extends Controller
{
    public function index()
    {
        $countLastCallsForProjects__7days = CallForProjects::withinLastDays(7)->count();
        $countLastCallsForProjects__1month = CallForProjects::withinLastMonths(1)->count();
        $countLastCallsForProjects__6months = CallForProjects::withinLastMonths(6)->count();

        $countBeneficiaries = Beneficiary::count();
        $countPerimeters = Perimeter::count();
        $countThematics = Thematic::primary()->count();
        $countSubthematics = Thematic::sub()->count();
        $countProjectHolders = ProjectHolder::count();
        $countWebsites = Website::count();

        $newsletterSubscribers = NewsletterSubscriber::all();

        $countNewsletterSubscribers__subscribed = $newsletterSubscribers->filter->isSubscribed()->count();
        $countNewsletterSubscribers__unsubscribed = $newsletterSubscribers->filter->isUnsubscribed()->count();

        return view('bko.home', compact(
            'countLastCallsForProjects__7days',
            'countLastCallsForProjects__1month',
            'countLastCallsForProjects__6months',
            'countBeneficiaries',
            'countPerimeters',
            'countThematics',
            'countSubthematics',
            'countProjectHolders',
            'countWebsites',
            'countNewsletterSubscribers__subscribed',
            'countNewsletterSubscribers__unsubscribed'
        ));
    }
}
