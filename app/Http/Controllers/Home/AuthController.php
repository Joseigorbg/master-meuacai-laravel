<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $this->registerOrLoginUser($user);
        
            return redirect()->route('auth.profile');
        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('auth.profile')->withErrors(['msg' => 'Falha ao autenticar com Google']);
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();

            $this->registerOrLoginUser($user);

            return redirect()->route('auth.profile');
        } catch (\Exception $e) {
            Log::error('Facebook Auth Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('auth.register-login')->withErrors(['msg' => 'Falha ao autenticar com Facebook']);
        }
    }

    protected function registerOrLoginUser($data)
    {
        Log::info('User Data:', ['email' => $data->email, 'name' => $data->name]);

        $user = User::where('email', $data->email)->first();

        if (!$user) {
            Log::info('Creating new user');
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'provider_id' => $data->id,
                'profile_picture' => $data->avatar,
                'password' => bcrypt('password') // Defina um password padrão ou gere um aleatório
            ]);
        } else {
            Log::info('User already exists');
            if ($user->profile_picture === null) {
                $user->profile_picture = $data->avatar;
                $user->save();
            }
        }

        Auth::login($user);
    }
}
