<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $contact = new Contact();
        $validatedData = $request->validate($contact->rules());

        $contact->fill($validatedData);
        $contact->save();

        return redirect(route('front.contact'))
            ->with('success', "Merci, votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.");
    }
}
