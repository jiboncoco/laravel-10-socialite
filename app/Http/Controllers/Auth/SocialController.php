<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use model here
use App\Models\User;

// third party
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            // Mendapatkan data pengguna dari GitHub
//            $githubUser = Socialite::driver('github')->user();

            // Mencari pengguna dengan email yang sesuai dalam basis data
            $user = User::where('email', 'fauzi.achmad12@gmail.com')->first();

            if (!$user) {
                // Jika pengguna belum terdaftar, buat akun baru
                $user = User::create([
                    'name' => $githubUser->getName(),
                    'email' => $githubUser->getEmail(),
                    'password' => null, // Tidak menyimpan kata sandi untuk autentikasi OAuth
                    // Informasi tambahan pengguna
                ]);
            }

            // Autentikasi pengguna
            Auth::login($user);

            return redirect('/dashboard');

        } catch (Exception $e) {
            // Tangani kesalahan autentikasi
            return redirect('/login')->with('error', 'Autentikasi gagal: ' . $e->getMessage());
        }
    }
}
