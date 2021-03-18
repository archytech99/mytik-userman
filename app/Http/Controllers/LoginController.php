<?php

namespace App\Http\Controllers;

use App\Router;
use App\Session;
use App\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ValidatesRequests;

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
        return 'username';
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function session(Request $request)
    {
        try {
            $session = Session::query()->where('username', $request->input('session'))->firstOrFail();
            if (Auth::attempt([
                $this->username() => $session->username,
                'password' => $session->password
            ], true)) {
                Auth::login(Auth::user(), true);

                $user = User::query()->find( Auth::id())->first();
                $user->last_login = date('d-m-Y H:i:s', strtotime(now()));
                $user->save();

                $this->router([
                    'id'=> Auth::id(),
                    'hosts'=> $session->hosts,
                    'username'=> $session->username,
                    'password'=> $session->password,
                    'port'=> $session->port
                ]);

                return redirect(route('index'));
            } else {
                return redirect(route('login'))->back()->with('error', 'Login Failed!!');
            }
        } catch (\Exception $exception) {
            return redirect(route('login'))->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt([
            $this->username() => $request->input('username'),
            'password' => $request->input('password')
        ], true)) {
            Auth::login(Auth::user(), true);

            $user = User::query()->find( Auth::id())->first();
            $user->last_login = date('d-m-Y H:i:s', strtotime(now()));
            $user->save();

            $this->router([
                'id'=> Auth::id(),
                'hosts'=> $request->hosts,
                'username'=> $request->username,
                'password'=> $request->password,
                'port'=> $request->port
            ]);

            if ($request->input('session')) {
                $session = Session::query()->firstOrNew([
                    'id'=> Auth::id(),
                    'hosts'=> $request->hosts,
                    'username'=> $request->username,
                    'password'=> $request->password,
                    'port'=> $request->port
                ]);

                $session->id = Auth::id();
                $session->hosts = $request->hosts;
                $session->username = $request->username;
                $session->password = $request->password;
                $session->port = $request->port;
                $session->save();
            }

            return json_swal("Login anda berhasil dikonfirmasi.",'Login Success','success');
        } else {
            try {
                $id = generateId('S');
                RouterController::login(
                    $request->input('hosts'),
                    $request->input('username'),
                    $request->input('password'),
                    $request->input('port')
                );
                $this->router([
                    'id'=> $id,
                    'hosts'=> $request->input('hosts'),
                    'username'=> $request->input('username'),
                    'password'=> $request->input('password'),
                    'port'=> $request->input('port')
                ]);

                if ($request->input('session')) {
                    $session = new Session();
                    $session->id = $id;
                    $session->hosts = $request->hosts;
                    $session->username = $request->username;
                    $session->password = $request->password;
                    $session->port = $request->port;
                    $session->save();
                }

                $user = new User;
                $user->id = $id;
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->last_login = date('d-m-Y H:i:s', strtotime(now()));
                $user->save();

                Auth::login($user, true);
                return json_swal("Login anda berhasil dikonfirmasi.",'Login Success','success');
            } catch (\Exception $exception) {
                return json_swal($exception->getMessage(),'Internal Server Error','error', false);
            }
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
            $this->router(['id'=> Auth::id()], true);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('login'));
        } catch (\Exception $exception) {
            return redirect(route('index'));
        }
    }

    /**
     * @param array $data
     * @param bool $delete
     * @return bool
     */
    private function router(array $data = [], bool $delete = false): bool
    {
        if (! $delete) {
            try {
                $router = new Router();
                $router->id = $data['id'];
                $router->hosts = $data['hosts'];
                $router->username = $data['username'];
                $router->password = $data['password'];
                $router->port = $data['port'];
                $router->save();
                return true;
            } catch (\Exception $exception) {
                return false;
            }
        } else {
            try {
                $user = Router::query()->findOrFail($data['id'])->first();
                $user->delete();
                return true;
            } catch (\Exception $exception) {
                return false;
            }
        }
    }
}
