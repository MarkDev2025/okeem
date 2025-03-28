<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    // Connexion utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
    }

    // Déconnexion utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

// class AuthController extends Controller
// {
//     /**
//      * Handle user login and return a Sanctum token.
//      */
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if (!$user || !Hash::check($request->password, $user->password)) {
//             throw ValidationException::withMessages([
//                 'email' => ['Les identifiants fournis sont incorrects.'],
//             ]);
//         }

//         return response()->json([
//             'token' => $user->createToken('api-token')->plainTextToken,
//             'user' => $user
//         ]);
//     }

//     /**
//      * Handle user logout by revoking tokens.
//      */
//     public function logout(Request $request)
//     {
//         $request->user()->tokens()->delete();

//         return response()->json(['message' => 'Déconnexion réussie']);
//     }

//     /**
//      * Register a new user.
//      */
//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:users',
//             'password' => 'required|min:6',
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         return response()->json([
//             'message' => 'Utilisateur créé avec succès',
//             'user' => $user,
//         ], 201);
//     }

//     /**
//      * Get authenticated user details.
//      */
//     public function user(Request $request)
//     {
//         return response()->json($request->user());
//     }
// }
