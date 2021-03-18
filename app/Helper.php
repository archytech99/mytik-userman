<?php

/*
 * Additional helper.
 *
 * © archytech99 <archytech99@gmail.com>
 */

use App\Router;
use App\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotReadableException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

define('LENGTH_ID', 24);

if (!function_exists('quote_list')) {
    function quote_list()
    {
        $data = [
            "Dunia tak lagi sama tak selamanya memihak kita, disaat kita mau berusaha di situlah kebahagiaan akan indah pada waktunya.",
            "Hidup ini hanya sekali dan peluang itu juga sekali munculnya, keduanya tidak datang dua kali.",
            "Hidup tak semudah membalikkan telapak tangan, tetapi dengan telapak tangan kita dapat mengubah hidup kita jauh lebih baik lagi.",
            "Jadilah pribadi yang menantang masa depan, bukan pengecut yang aman di zona nyaman.",
            "Belajarlah rendah hati, rendahkan hatimu serendah-rendahnya hingga tidak ada seorang pun yang bisa merendahkanmu.",
            "Kamu lebih kuat dari yang kamu tahu. Lebih cakap dari yang pernah kamu impikan. Dan kamu dicintai lebih dari yang bisa kamu bayangkan.",
            "Jika hatimu banyak merasakan sakit, maka belajarlah dari rasa sakit itu untuk tidak memberikan rasa sakit pada orang lain.",
            "Hidup itu sederhana, kita yang membuatnya sulit.",
            "Kadang-kadang langit bisa kelihatan seperti lembar kosong. Padahal sebenarnya tidak. Bintang kamu tetap di sana. Bumi hanya sedang berputar.",
            "Jangan membenci mereka yang mengatakan hal buruk tuk menjatuhkanmu, karena merekalah yang buatmu semakin kuat setiap hari.",
            "Jangan pernah meremehkan diri sendiri. Jika kamu tak bahagia dengan hidupmu, perbaiki apa yg salah, dan teruslah melangkah.",
            "Hanya karena orang lain berbuat tidak baik kepada kita, bukan berarti kita harus membalasnya dengan cara yang sama.",
            "Sukses adalah wujud kesempurnaan hidup.",
            "Segala sesuatu memiliki kesudahan, yang sudah berakhir biarlah berlalu dan yakinlah semua akan baik-baik saja.",
            "Jangan salahkan dirimu atas keputusan yg salah. Setiap orang membuatnya. Jadikan mereka pelajaran tuk keputusanmu selanjutnya.",
            "Bukan bahagia yang menjadikan kita bersyukur, tetapi dengan bersyukurlah yang akan menjadikan hidup kita bahagia.",
            "Yang keren itu bukan anak muda yang banyak gaya, tapi anak muda yang banyak karya.",
            "Janganlah pernah menyerah ketika kamu masih mampu berusaha lagi. Tidak ada kata berakhir sampai kamu berhenti mencoba.",
            "Pengusaha itu bukan orang yang pintar tetapi mereka pintar mencari orang pintar."
        ];
        return $data[array_rand($data)];
    }
}

if (!function_exists('json')) {
    /**
     * Create a new JSON response instance.
     *
     * @param mixed $data
     * @param bool $status
     * @param string $message
     * @param Response $code
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    function json($data, $status = true, $message = "Sukses.", $code = 200, array $headers = [], $options = 0)
    {
        return response()->json([
            'status'=> $status,
            'message'=> $message,
            'data'=> $data ?? []
        ], $code, $headers, $options);
    }
}

if (!function_exists('json_swal')) {
    /**
     * Create a new JSON feedback instance for JQuery.
     *
     * @param $text
     * @param $title
     * @param $icon
     * @param bool $status
     * @return JsonResponse
     */
    function json_swal($text, $title, $icon, $status = true)
    {
        return response()->json([
            'status'=> $status,
            'title'=> $title ?? 'Sukses',
            'icon'=> $icon ?? 'success',
            'text'=> $text ?? 'Sukses!'
        ]);
    }
}

if (!function_exists('dump_json')) {
    /**
     * @param mixed $data
     */
    function dump_json($data = '')
    {
        dump(response()->json($data)->getData());
        exit(1);
    }
}

if (!function_exists('vd')) {
    /**
     * @param mixed $data
     */
    function vd($data = '')
    {
        var_dump($data);
        exit(1);
    }
}

if (!function_exists('get_router_info')) {
    function get_router_info()
    {
        try {
            $router = Router::all()->first();

            if ($router) {
                return (object)[
                    'host' => $router->hosts,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port,
                ];
            } else {
                return false;
            }
        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('session_route')) {
    function session_route()
    {
        $data = false;

        try {
            $session = Session::all();

            if ($session) {
                foreach ($session as $item) {
                    $data[$item->hosts] = $item->username;
                }
            }

            return $data;
        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('url_hotspot')) {
    function url_hotspot($user, $pass)
    {
        return env('ROUTER_HOTSPOT_DNS') . "/login?username={$user}&password={$pass}";
    }
}

if (!function_exists('simple_qrcode')) {
    /**
     * @param string $value value to be generate
     * @param int $size 100/125/150/xxx
     * @param string $src qrserver/google
     * @return array|string|bool
     */
    function simple_qrcode($value = 'qrcode', $size = 100, $src = 'qrserver')
    {
        if (! $value) {
            return false;
        } elseif (empty($value)) {
            return false;
        } else {
            switch ($src) {
                case 'qrserver':
                    $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$value}&size={$size}x{$size}&charset-source=UTF-8&ecc=M&margin=9";
                    break;
                case 'google':
                    $qrcode = "https://chart.googleapis.com/chart?cht=qr&chl={$value}&chs={$size}x{$size}&chld=M|1";
                    break;
                default :
                    $qrcode = asset('assets/images/MIhvZ397d.png');
            }
        }

        try {
            return Image::make($qrcode)->response();
        } catch (NotReadableException | Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('generateId')) {
    /**
     * @param string $set select id generator ramsey or str [r/s]
     * @param int $length max length is 24
     * @return string
     */
    function generateId(string $set, int $length = LENGTH_ID)
    {
        switch (strtolower($set)) {
            case 'r':
                $code = Uuid::uuid4();
                break;
            case 's':
                $code = Str::random(LENGTH_ID);
                break;
            default:
                $code = null;
        }

        return $code;
    }
}
