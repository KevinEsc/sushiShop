<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── LOGIN ───────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresa un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', '¡Bienvenido al panel de administración!');
            }

            return redirect()->intended(route('home'))
                ->with('success', '¡Bienvenido de vuelta, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // ─── REGISTRO ────────────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'telefono' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.email'        => 'Ingresa un correo válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // El primer usuario registrado obtiene rol 'admin'
        $role = User::count() === 0 ? 'admin' : 'user';

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'role'     => $role,
        ]);

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', '¡Cuenta creada! Eres el administrador de MoniWis Sushi.');
        }

        return redirect()->route('home')
            ->with('success', '¡Registro exitoso! Bienvenido a MoniWis Sushi, ' . $user->name . '.');
    }

    // ─── LOGOUT ──────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}
