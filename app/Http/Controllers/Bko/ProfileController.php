<?php

namespace App\Http\Controllers\Bko;

use App\Http\Controllers\Controller;
use App\Rules\CurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getAuthUser()
    {
        return auth()->user();
    }

    public function edit()
    {
        return view('bko.profile.edit', ['user' => $this->getAuthUser()]);
    }

    public function update(Request $request)
    {
        $user = $this->getAuthUser();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);


        $user->name = $validatedData['name'];
        $user->save();

        if (request()->wantsJson()) {
            return response()->json($user, 201);
        }

        return redirect(route('bko.profile.edit'))
            ->with('success', "Votre profil a bien été mis à jour.");
    }

    public function updatePassword(Request $request)
    {
        $user = $this->getAuthUser();

        $validator = Validator::make($request->all(), [
            'old_password' => [
                'required',
                new CurrentPassword()
            ],
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'errors_password');
        }


        $user->password = Hash::make($request->password);
        $user->save();

        if (request()->wantsJson()) {
            return response()->json($user, 201);
        }

        return redirect(route('bko.profile.edit'))
            ->with('success_password', "Votre mot de passe a bien été mis à jour.");
    }
}
