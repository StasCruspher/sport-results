<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Показати сторінку логіну.
     */
    public function create()
    {
        return view('auth.login'); // створимо цю сторінку далі
    }

    /**
     * Обробити спробу входу.
     */
    public function store(Request $request)
        {
            $request->validate([
                'password' => 'required|string',
            ]);

            $inputPassword = $request->password;
            $matchedUser = null;

            // Ітеруємо cursor() — не завантажуємо всю таблицю в пам'ять
            foreach (User::cursor() as $user) {
                if ($user->password && Hash::check($inputPassword, $user->password)) {
                    $matchedUser = $user;
                    break;
                }
            }

            if ($matchedUser) {
                Auth::login($matchedUser);

                // Безпека: регенеруємо сесію після логіну
                $request->session()->regenerate();

                return redirect()->intended('/');
            }

            return back()->withErrors(['password' => 'Невірний пароль.']);
        }

    /**
     * Вихід із системи.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
