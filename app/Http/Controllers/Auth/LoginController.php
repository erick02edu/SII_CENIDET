<?php
// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Inertia\Inertia;

class LoginController extends AuthenticatedSessionController
{

    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended(config('fortify.home'));
        }
        return inertia::render('Auth/Login',[
            'status'=>true
        ]);
    }

}
