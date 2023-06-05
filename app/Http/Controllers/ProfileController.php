<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $profiles = Profile::all();

        return view('profile.index', compact('profiles'));
    }

    public function create(Request $request): View
    {
        return view('profile.create');
    }

    public function store(ProfileStoreRequest $request): RedirectResponse
    {
        $profile = Profile::create($request->validated());

        $request->session()->flash('profile.id', $profile->id);

        return redirect()->route('profile.index');
    }

    public function show(Request $request, Profile $profile): View
    {
        return view('profile.show', compact('profile'));
    }

    public function edit(Request $request, Profile $profile): View
    {
        return view('profile.edit', compact('profile'));
    }

    public function update(ProfileUpdateRequest $request, Profile $profile): RedirectResponse
    {
        $profile->update($request->validated());

        $request->session()->flash('profile.id', $profile->id);

        return redirect()->route('profile.index');
    }

    public function destroy(Request $request, Profile $profile): RedirectResponse
    {
        $profile->delete();

        return redirect()->route('profile.index');
    }
}
