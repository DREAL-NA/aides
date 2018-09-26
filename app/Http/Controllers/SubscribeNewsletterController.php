<?php

namespace App\Http\Controllers;

use App\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Newsletter;

class SubscribeNewsletterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

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
            return response(['errors' => ['mc' => ["Une erreur est survenue. Merci de contacter l'administrateur."]]], 422);
        }

        return response("Merci pour votre inscription !", 201);
    }
}
