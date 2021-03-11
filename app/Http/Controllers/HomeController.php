<?php

namespace App\Http\Controllers;

use App\Pear2\Net\RouterOS\SocketException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\ErrorHandler\Error\FatalError;

class HomeController extends Controller
{
    protected $router;

    public function __construct()
    {
        try {
            $this->router = new RouterController(RouterController::login(
                auth_user()->ip, auth_user()->user, auth_user()->pass, auth_user()->port
            ));
        } catch (FatalError | SocketException $exception) {
            return false;
        }
    }

    public function qrcode(Request $request)
    {
        $users = $this->router->get_users();
        foreach ($users as $user) {
            if ($user['name'] != $request->username) {
                continue;
            } else {
                $data = [
                    'username'=> $user['name'],
                    'password'=> $user['password'],
                    'limit_uptime'=> $user['limit-uptime'],
                    'limit_bytes'=> $user['limit-bytes']
                ];
            }
        }

        return view('qr-code.index', $data);
    }

    public function showIndex()
    {
        return $this->dataTables($this->router->active_user());
    }

    public function index(Request $request)
    {
        if ($request->input('cnt')) {
            return json($this->router->card_index());
        }

        if ($request->input('del_id')) {
            $return = $this->router->del_activeUser($request->del_id, $request->del_name);

            if ($return['status']) {
                return json_swal($return['message'],'Berhasil!','success');
            } else {
                return json_swal($return['message'],'Gagal!!','error', false);
            }
        }

        return view('home.index', array('quote'=> quote_list()));
    }

    public function showUsers()
    {
        return $this->dataTables($this->router->get_users());
    }

    public function users(Request $request)
    {
        if ($request->input('add_id')) {
            $return = $this->router->put_users($request->all());

            if ($return['status']) {
                return redirect()->back()->with('success', $return['message']);
            } else {
                return redirect()->back()->with('error', $return['message']);
            }
        }

        if ($request->input('del_id')) {
            $return = $this->router->del_users($request->del_id, $request->del_desc);

            if ($return['status']) {
                return json_swal($return['message'],'Berhasil!','success');
            } else {
                return json_swal($return['message'],'Gagal!!','error', false);
            }
        }

        return view('user.index', ['profile'=> $this->router->get_profile()]);
    }

    public function showPacket()
    {
        return $this->dataTables($this->router->get_packet());
    }

    public function packet(Request $request)
    {
        if ($request->input('add_id')) {
            $return = $this->router->put_packet($request->all());

            if ($return['status']) {
                return redirect()->back()->with('success', $return['message']);
            } else {
                return redirect()->back()->with('error', $return['message']);
            }
        }

        if ($request->input('del_id')) {
            $return = $this->router->del_packet($request->del_id);

            if ($return['status']) {
                return json_swal($return['message'],'Berhasil!','success');
            } else {
                return json_swal($return['message'],'Gagal!!','error', false);
            }
        }

        return view('packet.index');
    }

    public function showClient()
    {
        return $this->dataTables($this->router->get_client());
    }

    public function client(Request $request)
    {
        if ($request->input('del_id')) {
            $return = $this->router->del_client($request->del_id, $request->del_name);

            if ($return['status']) {
                return json_swal($return['message'],'Berhasil!','success');
            } else {
                return json_swal($return['message'],'Gagal!!','error', false);
            }
        }

        return view('client.index');
    }
}
