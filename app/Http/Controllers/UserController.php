<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /** Password given to newly created teachers; they change it after first login. */
    public const DEFAULT_PASSWORD = '123456789';

    public function index()
    {
        $user = User::whereIn('role', ['teacher', 'admin'])->orderBy('name')->get();

        return view('user.index')->with('user', $user);
    }

    public function create()
    {
        $banks = Bank::orderBy('name')->get();

        return view('user.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['role'] = 'teacher';
        $data['password'] = Hash::make(self::DEFAULT_PASSWORD);

        User::create($data);

        return redirect()->route('user.index')
            ->with('success', __('Teacher added. Default password: :password', ['password' => self::DEFAULT_PASSWORD]));
    }

    public function edit(User $user)
    {
        $banks = Bank::orderBy('name')->get();

        return view('user.create', compact('user', 'banks'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validated($request, $user));

        return redirect()->route('user.index')->with('success', __('Teacher saved.'));
    }

    public function destroy(User $user)
    {
        if ($user->is(Auth::user()) || $user->role === 'superadmin') {
            return redirect()->route('user.index')->with('error', __('This account cannot be deleted.'));
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', __('Teacher deleted.'));
    }

    public function change_password()
    {
        return view('user.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', __('Current password does not match!'));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->withSuccess(__('Password Changed!'));
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'shortname' => ['nullable', 'string', 'max:50'],
            'ic' => ['nullable', 'string', 'max:50'],
            'contact' => ['nullable', 'string', 'max:50'],
            'basic_salary' => ['nullable', 'numeric', 'min:0'],
            'no_of_annual_leave' => ['nullable', 'integer', 'min:0', 'max:365'],
            'no_of_sick_leave' => ['nullable', 'integer', 'min:0', 'max:365'],
            'bank_id' => ['nullable', 'exists:banks,id'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'is_active' => ['required', 'boolean'],
        ];

        // Username is set once on create and shown read-only afterwards.
        if (! $user) {
            $rules['username'] = ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')];
        }

        return $request->validate($rules);
    }
}
