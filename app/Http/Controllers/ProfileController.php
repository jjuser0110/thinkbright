<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'contact' => ['nullable', 'string', 'max:50'],
            'ic' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', __('Profile updated.'));
    }
}
