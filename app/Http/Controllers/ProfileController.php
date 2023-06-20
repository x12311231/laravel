<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProfileController extends Controller
{
//    public function index(Request $request): View
//    {
//        $profiles = Profile::all();
//
//        return view('profile.index', compact('profiles'));
//    }
//
//    public function create(Request $request): View
//    {
//        return view('profile.create');
//    }
//
//    public function store(ProfileStoreRequest $request): RedirectResponse
//    {
////        $request->merge(['user_id' => $request->user()->id]);
//        $validated = $request->validated();
//        $profile = Profile::create(array_merge($validated, ['user_id' => $request->user()->id]));
//
//        $request->session()->flash('profile.id', $profile->id);
//
////        return redirect()->route('profile.index');
//        return redirect()->route('profile.edit');
//    }

//    public function show(Request $request, Profile $profile): View
//    {
//        return view('profile.show', compact('profile'));
//    }
//
    public function edit(Request $request): View
    {
        $profile = Profile::firstOr(function () {
            return new class {
                public $webSite = '';
                public $sex = '';
            };
        });
        return view('profile.edit', compact('profile'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
//        $profile->upsert(array_merge($validated, ['user_id' => $request->user()->id]));
        Profile::upsert(array_merge($validated, ['user_id' => $request->user()->id]), ['user_id']);

//        $request->session()->flash('profile.id', $profile->id);

        Session::remove('status');
        return redirect()->route('profile.edit');

    }

//    public function destroy(Request $request, Profile $profile): RedirectResponse
//    {
//        $profile->delete();
//
//        return redirect()->route('profile.index');
//    }
}
