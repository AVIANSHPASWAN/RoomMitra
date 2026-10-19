<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Owner;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'account_type' => ['required', 'in:user,owner'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $email = strtolower($validated['email']);

        $exists =
            DB::table('users')
                ->whereRaw('LOWER(email) = ?', [$email])->exists()
            || DB::table('owners')
                ->whereRaw('LOWER(email) = ?', [$email])->exists()
            || DB::table('admins')
                ->whereRaw('LOWER(email) = ?', [$email])->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'email' => 'This email is already registered.',
            ]);
        }

        if ($validated['account_type'] === 'owner') {
            $account = Owner::create([
                'name' => $validated['name'],
                'email' => $email,
                'password' => $validated['password'],
            ]);

            Auth::guard('owner')->login($account);
        } else {
            $account = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'password' => $validated['password'],
            ]);

            Auth::guard('web')->login($account);
        }

        $request->session()->regenerate();

        return redirect()->route('rooms.index');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'account_type' => ['required', 'in:user,owner,admin'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower($validated['email']);

        $models = [
            'user' => ['guard' => 'web', 'model' => User::class],
            'owner' => ['guard' => 'owner', 'model' => Owner::class],
            'admin' => ['guard' => 'admin', 'model' => Admin::class],
        ];

        $selected = $models[$validated['account_type']];

        $account = $selected['model']::whereRaw(
            'LOWER(email) = ?',
            [$email]
        )->first();

        if (
            !$account ||
            !Hash::check($validated['password'], $account->password)
        ) {
            throw ValidationException::withMessages([
                'email' => 'Account type, email or password is incorrect.',
            ]);
        }

        // Remove any previous account's active session.
        Auth::guard('web')->logout();
        Auth::guard('owner')->logout();
        Auth::guard('admin')->logout();

        Auth::guard($selected['guard'])->login(
            $account,
            $request->boolean('remember')
        );

        $request->session()->regenerate();

        return redirect()->route('rooms.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('owner')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('rooms.index');
    }
}
