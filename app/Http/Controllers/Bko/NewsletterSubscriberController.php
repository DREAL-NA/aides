<?php

namespace App\Http\Controllers\Bko;

use App\Http\Controllers\Controller;
use App\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = NewsletterSubscriber::all();

        return view('bko.newsletter.subscriber.index', compact('subscribers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscriber = new NewsletterSubscriber();

        return view('bko.newsletter.subscriber.create', compact('subscriber'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('newsletter_subscribers', 'email')],
            'firstname' => ['max:255'],
            'lastname' => ['max:255'],
        ]);

        // Save the new subscriber
        $subscriber = (new NewsletterSubscriber)->fill($validatedData);

        // Subscribe him to the newsletter
        $subscriber->subscribe();

        // If we get a Mailchimp error => subscription is cancelled
        if (!empty($subscriber->mailchimp_error)) {
            return redirect(route('bko.subscriber.create'))
                ->withErrors("Mailchimp Error: " . $subscriber->mailchimp_error)
                ->withInput();
        }

        if ($request->wantsJson()) {
            return response($subscriber, 201);
        }

        return redirect(route('bko.subscriber.edit', $subscriber))
            ->with('success', "L'abonné a bien été ajouté.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\NewsletterSubscriber $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsletterSubscriber $subscriber)
    {
        return view('bko.newsletter.subscriber.edit', compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\NewsletterSubscriber $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsletterSubscriber $subscriber)
    {
        $validatedData = $request->validate([
            'firstname' => ['max:255'],
            'lastname' => ['max:255'],
        ]);

        $subscriber = $subscriber->fill($validatedData);

        $subscriber->subscribe();

        // If we get a Mailchimp error => subscription is cancelled
        if (!empty($subscriber->mailchimp_error)) {
            return redirect(route('bko.subscriber.edit', $subscriber))
                ->withErrors("Mailchimp Error: " . $subscriber->mailchimp_error)
                ->withInput();
        }

        if ($request->wantsJson()) {
            return response($subscriber, 201);
        }

        return redirect(route('bko.subscriber.edit', $subscriber))
            ->with('success', "L'abonné a bien été modifié.");
    }

    /**
     * Subscribe a member
     *
     * @param \App\NewsletterSubscriber $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->subscribe();

        return response($subscriber->toDatatableFormat(), 200);
    }

    /**
     * Unsubscribe a member
     *
     * @param \App\NewsletterSubscriber $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->unsubscribe();

        return response($subscriber->toDatatableFormat(), 200);
    }
}
