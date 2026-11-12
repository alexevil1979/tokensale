<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route("admin.index");
        }
        return view("admin.login");
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (!Auth::attempt($data, $request->boolean("remember"))) {
            return back()->withErrors(["email" => "Неверный email или пароль."])->onlyInput("email");
        }

        $request->session()->regenerate();

        if (!Auth::user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(["email" => "Этот аккаунт не является администратором."])->onlyInput("email");
        }

        return redirect()->intended(route("admin.index"));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("admin.login");
    }
}
