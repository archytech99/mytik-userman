<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }

    /**
     * Get the key login username/email to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        /*$value = request()->input('username');
        $key = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$key => $value]);*/

        return 'username';// $key;
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        // $this->loginValidated($request);

        try {
            RouterController::login(
                $request->input('ip_addr'),
                $request->input('username'),
                $request->input('password'),
                $request->input('port')
            );

            try {
                $user = User::query();
                $user->where('username', $request->username)->firstOrFail();
                $user->delete();
            } catch (\Exception $exception) {
            }

            $user = new User;
            $user->ip_addr = $request->ip_addr;
            $user->username = $request->username;
            // $user->password = Hash::make($request->password);
            $user->password = $request->password;
            $user->port = $request->port;
            $user->last_login = date('d-m-Y H:i:s', strtotime(now()));
            $user->save();

            Auth::login($user, true);
            return json_swal("Login anda berhasil dikonfirmasi.",'Login Success','success');
        } catch (\Exception $exception) {
            return json_swal($exception->getMessage(),'Internal Server Error','error', false);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $user = User::query();
            $user->where('username', $request->username)->firstOrFail();
            $user->delete();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('login'));
        } catch (\Exception $exception) {
            return redirect(route('index'));
        }
    }

    /**
     * Validation for login method
     *
     * @param Request $request
     */
    private function loginValidated(Request $request)
    {
        $rule_user = ($this->username() == 'email') ? 'required|email|exists:users|max:50' : 'required|string|exists:users|min:5|max:30';
        $rules = [
            $this->username() => $rule_user,
            'password' => 'required|string|min:4|max:50',
            'g-recaptcha-response' => 'required|captcha',
        ];

        $messages = [
            $this->username().'.exists' => 'Pastikan username anda sudah benar.',
            'g-recaptcha-response.required' => 'Harap validasi terlebih dahulu sebelum dilanjutkan!',
            'g-recaptcha-response.captcha' => 'Silahkan lakukan validasi!',
        ];

        $request->validate($rules, $messages);
    }
}
