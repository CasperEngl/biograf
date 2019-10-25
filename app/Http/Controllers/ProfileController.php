<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $film = (new \App\Actions\FilmActions)->pastViewedFilms(auth()->user())->first();

        return view('profile.index', compact('film'));
    }

    public function store(UpdateProfileRequest $request)
    {
        $user = \App\User::find(auth()->id());

        $user->fill($request->all());
        $user->save();

        return redirect()->back()->with('status.success', trans('profile.status.update.success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        $user = \App\User::find(auth()->id());

        $user->fill([
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        return redirect()->back()->with('status.success', trans('profile.status.update.success'));
    }
}
