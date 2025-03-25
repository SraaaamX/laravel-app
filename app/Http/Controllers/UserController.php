<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function index()
    {
        try {
            $users = User::select('id', 'username', 'email')->get();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des utilisateurs'], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'bio' => 'nullable|string|max:1000',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'bio' => $request->bio
            ];

            if ($request->hasFile('profile_pic')) {
                $path = $request->file('profile_pic')->store('profile_pics', 'public');
                $data['profile_pic'] = $path;
            }

            $user = User::create($data);
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Inscription réussie',
                    'user' => $user->only(['id', 'username', 'email']),
                    'token' => $token
                ], 201);
            }

            return redirect()->route('login')->with('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => "L'inscription a échoué"
                ], 500);
            }
            return redirect()->back()->with('error', "L'inscription a échoué")->withInput();
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('username', $credentials['username'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect()
                ->back()
                ->withInput($request->except('password'))
                ->with('error', 'Ces identifiants ne correspondent pas à nos enregistrements.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Connexion réussie',
                'user' => $user->only(['id', 'username', 'email']),
                'token' => $token
            ], 200);
        }

        return redirect()
            ->intended(route('profile'))
            ->with('success', 'Connexion réussie !');
    }

    public function showPublicProfile($slug)
    {
        $user = User::where('username', $slug)->first();

        if (!$user) {
            return redirect()->route('home');
        }

        // Si l'utilisateur connecté essaie d'accéder à son propre profil via l'URL publique
        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->route('profile');
        }

        $posts = $user->posts()->latest()->paginate(3);
        return view('profile_public', compact('user', 'posts'));
    }

    public function me(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'message' => 'Non authentifié'
                ], 401);
            }

            $user = $request->user();
            return response()->json([
                'user' => $user->only(['id', 'username', 'email'])
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des données'
            ], 500);
        }
    }

    public function showProfile()
    {
        $posts = auth()->user()->posts()->latest()->paginate(3);
        return view('profile', compact('posts'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();

            $validator = \Validator::make($request->all(), [
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'bio' => 'nullable|string|max:1000',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('profile_error', 'Veuillez corriger les erreurs ci-dessous.'); // Changed to profile_error
            }

            $data = $validator->validated();

            if ($request->hasFile('profile_pic')) {
                try {
                    // Delete old profile picture if it exists
                    if ($user->profile_pic) {
                        $oldPath = $user->profile_pic;
                        if (\Storage::disk('public')->exists($oldPath)) {
                            \Storage::disk('public')->delete($oldPath);
                        }
                    }

                    // Store new profile picture
                    $data['profile_pic'] = $request->file('profile_pic')->store('profile_pics', 'public');
                } catch (\Exception $e) {
                    report($e); // Log the error
                }
            }

            $user->update($data);

            return redirect()
                ->route('profile')
                ->with('success', 'Profil mis à jour avec succès');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('profile_error', 'Erreur lors de la mise à jour du profil') // Changed to profile_error
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        }

        return redirect()
            ->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès');
    }

    public function deleteProfile(Request $request)
    {
        try {
            $user = auth()->user();

            // Suppression de la photo de profil si elle existe
            if ($user->profile_pic && \Storage::disk('public')->exists($user->profile_pic)) {
                \Storage::disk('public')->delete($user->profile_pic);
            }

            // Suppression des tokens et du compte
            $user->tokens()->delete();
            $user->delete();

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Compte supprimé avec succès'], 200);
            }

            return redirect()
                ->route('home')
                ->with('success', 'Votre compte a été supprimé avec succès');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'La suppression a échoué'], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'La suppression du compte a échoué');
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = auth()->user();

            $validator = \Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
                'new_password_confirmation' => 'required|string|min:8'
            ], [
                'current_password.required' => 'Le mot de passe actuel est requis',
                'new_password.required' => 'Le nouveau mot de passe est requis',
                'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
                'new_password.confirmed' => 'Les mots de passe ne correspondent pas',
                'new_password_confirmation.required' => 'La confirmation du mot de passe est requise',
                'new_password_confirmation.min' => 'La confirmation du mot de passe doit contenir au moins 8 caractères'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Vérifier si le mot de passe actuel est correct
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect'])
                    ->withInput()
                    ->with('error', 'Le mot de passe actuel est incorrect. Veuillez réessayer.');
            }

            // Vérifier que le nouveau mot de passe est différent de l'ancien
            if (Hash::check($request->new_password, $user->password)) {
                return back()
                    ->withErrors(['new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien'])
                    ->withInput()
                    ->with('error', 'Le nouveau mot de passe doit être différent de l\'ancien. Veuillez choisir un autre mot de passe.');
            }

            try {
                // Mettre à jour le mot de passe
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return back()
                    ->with('success', 'Mot de passe mis à jour avec succès')
                    ->with('password_updated', true); // Pour fermer le modal via JS

            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->with('error', 'Une erreur est survenue lors de la mise à jour du mot de passe.');
            }

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du mot de passe')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if (auth()->user()->id != $id) {
                return response()->json([
                    'message' => 'Non autorisé à supprimer ce compte'
                ], 403);
            }

            if ($user->profile_pic && \Storage::disk('public')->exists($user->profile_pic)) {
                \Storage::disk('public')->delete($user->profile_pic);
            }

            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'message' => 'Compte supprimé avec succès'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'La suppression a échoué'
            ], 500);
        }
    }
}
