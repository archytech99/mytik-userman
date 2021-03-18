<?php

namespace App\Http\Controllers;

use App\Pear2\Net\RouterOS\Client;
use App\Pear2\Net\RouterOS\Query;
use App\Pear2\Net\RouterOS\RouterErrorException;
use App\Pear2\Net\RouterOS\Util;
use Illuminate\Http\Request;

class RouterController
{
    protected $clients;
    protected $utils;

    public function __construct(Client $clients)
    {
        $this->utils = new Util(
            $this->clients = $clients
        );
    }

    public static function login($ipaddr, $username, $password, $port = 8728)
    {
        return new Client(
            $ipaddr, $username, $password, $port, false, 10
        );
    }

    public function card_index()
    {
        $this->utils->setMenu('/ip hotspot user');
        // $jml_user = $this->utils->count(Query::where('server', env('ROUTER_HOTSPOT_SERVER')));
        $jml_user = $this->utils->count();

        $this->utils->setMenu('/ip hotspot user profile');
        // $jml_user_profile = $this->utils->count(Query::where('address-list', 'userVoucher'));
        $jml_user_profile = $this->utils->count();

        $this->utils->setMenu('/ip hotspot active');
        // $jml_user_active = $this->utils->count(Query::where('server', env('ROUTER_HOTSPOT_SERVER')));
        $jml_user_active = $this->utils->count();

        $this->utils->setMenu('/ip hotspot host');
        $jml_hosts = $this->utils->count(
            /*Query::where('server', env('ROUTER_HOTSPOT_SERVER'))
                ->andWhere('bypassed', 'false')*/
            Query::Where('bypassed', 'false')
        );

        return [
            'jml_user'=> $jml_user,
            'jml_user_profile'=> $jml_user_profile,
            'jml_user_active'=> $jml_user_active,
            'jml_hosts'=> $jml_hosts
        ];
    }

    public function active_user()
    {
        $return = [];
        $this->utils->setMenu('/ip hotspot active');

        foreach ($this->utils->getAll() as $item) {
            /*if ($item->getProperty('server') != env('ROUTER_HOTSPOT_SERVER')) {
                continue;
            } else {*/
                $this->utils->setMenu('/ip dhcp-server lease');
                $leased = $this->utils->get(
                    $this->utils->find(
                        Query::where('mac-address',
                            $item->getProperty('mac-address')
                        )
                    ), 'host-name'
                );

                $return[] = [
                    'id' => [
                        'id' => $item->getProperty('.id'),
                        'mac' => $item->getProperty('mac-address'),
                        'comment' => $item->getProperty('comment')
                    ],
                    'server' => $item->getProperty('server'),
                    'user' => $item->getProperty('user'),
                    'address' => $item->getProperty('address'),
                    'mac' => $item->getProperty('mac-address'),
                    'loginby' => $item->getProperty('login-by'),
                    'uptime' => $item->getProperty('uptime'),
                    'idle' => $item->getProperty('idle-time'),
                    'keepalive' => $item->getProperty('keepalive-timeout'),
                    'leased' => $leased,
                    'comment' => $item->getProperty('comment'),
                    'bytes' => [
                        'in' => $item->getProperty('bytes-in'),
                        'out' => $item->getProperty('bytes-out')
                    ],
                    'packets' => [
                        'in' => $item->getProperty('packets-in'),
                        'out' => $item->getProperty('packets-out')
                    ]
                ];
            // }
        }

        return $return;
    }

    public function del_activeUser($id, $name)
    {
        try {
            $this->utils->setMenu('/ip hotspot active');
            $this->utils->remove(Query::where('mac-address', $id));

            return [
                'status'=> true,
                'message'=> "User '{$name}' berhasil logout dari hotspot."
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }

    public function get_users()
    {
        $return = [];
        $this->utils->setMenu('/ip hotspot user');

        foreach ($this->utils->getAll() as $item) {
            /*if ($item->getProperty('server') != env('ROUTER_HOTSPOT_SERVER')) {
                continue;
            } else {*/
                $return[] = [
                    'id' => [
                        'id'=> $item->getProperty('.id'),
                        'name' => $item->getProperty('name'),
                        'comment' => $item->getProperty('comment')
                    ],
                    'name' => $item->getProperty('name'),
                    'password'=> $item->getProperty('password'),
                    'uptime' => $item->getProperty('uptime'),
                    'dynamic' => $item->getProperty('dynamic'),
                    'disabled' => $item->getProperty('disabled'),
                    'default' => $item->getProperty('default'),
                    'comment' => $item->getProperty('comment'),
                    'limit-uptime' => $item->getProperty('limit-uptime'),
                    'limit-bytes' => $item->getProperty('limit-bytes-total'),
                    'bytes' => [
                        'in' => $item->getProperty('bytes-in'),
                        'out' => $item->getProperty('bytes-out')
                    ],
                    'packets' => [
                        'in' => $item->getProperty('packets-in'),
                        'out' => $item->getProperty('packets-out')
                    ]
                ];
            // }
        }

        return $return;
    }

    public function put_users($data)
    {
        try {
            $this->utils->setMenu('/ip hotspot user');

            if (intval($data['limit-bytes-total']) > 0) {
                $limit_bytes_total = (intval($data['limit-bytes-total']) * 1024 * 1024 * 1024 );
                $this->utils->add([
                    'server' => $data['server'],
                    'name' => $data['username'],
                    'password' => $data['password'],
                    'disabled' => "no",
                    'limit-uptime' => $data['limit-uptime'],
                    'limit-bytes-total' => $limit_bytes_total,
                    'profile' => $data['profile'],
                    'comment' => $data['comment']
                ]);
            } else {
                $this->utils->add([
                    'server' => $data['server'],
                    'name' => $data['username'],
                    'password' => $data['password'],
                    'disabled' => "no",
                    'limit-uptime' => $data['limit-uptime'],
                    'profile' => $data['profile'],
                    'comment' => $data['comment']
                ]);
            }

            return [
                'status'=> true,
                'message'=> "Voucher baru berhasil disimpan!"
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }

    public function del_users($name, $comment)
    {
        $desc = ($comment) ?? $name;

        try {
            $this->utils->setMenu('/ip hotspot user');
            $this->utils->remove(Query::where('name', $name));

            return [
                'status'=> true,
                'message'=> "Voucher '{$desc}' berhasil dihapus!"
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }

    public function get_packet()
    {
        $return = [];
        $this->utils->setMenu('/ip hotspot user profile');

        foreach ($this->utils->getAll() as $item) {
            /*if ($item->getProperty('address-list') != 'userVoucher') {
                continue;
            } else {*/
                $return[] = [
                    'id'=> [
                        'id'=> $item->getProperty('.id'),
                        'name'=> $item->getProperty('name')
                    ],
                    'name'=> $item->getProperty('name'),
                    'idle'=> $item->getProperty('idle-timeout'),
                    'keepalive'=> $item->getProperty('keepalive-timeout'),
                    'autorefresh'=> $item->getProperty('status-autorefresh'),
                    'shared'=> $item->getProperty('shared-users'),
                    'rate-limit' => $item->getProperty('rate-limit'),
                    'mac-address'=> [
                        'added'=> $item->getProperty('add-mac-cookie'),
                        'timeout'=> $item->getProperty('mac-cookie-timeout')
                    ],
                    'address'=> $item->getProperty('address-list'),
                    'proxy'=> $item->getProperty('transparent-proxy'),
                    'default'=> $item->getProperty('default')
                ];
            // }
        }

        return $return;
    }

    public function put_packet($data)
    {
        try {
            $this->utils->setMenu('/ip hotspot user profile');
            $this->utils->add([
                'name' => $data['name'],
                'idle-timeout' => $data['idle-timeout'],
                'keepalive-timeout' => $data['keepalive-timeout'],
                'status-autorefresh' => $data['status-autorefresh'],
                'shared-users' => $data['shared-users'],
                'rate-limit' => $data['upload-limit'] . '/' . $data['download-limit'],
                'mac-cookie-timeout' => $data['mac-cookie-timeout'],
                'address-list' => 'userVoucher',
                'transparent-proxy' => 'yes'
            ]);

            return [
                'status'=> true,
                'message'=> "Packet baru berhasil disimpan!"
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }

    public function del_packet($name)
    {
        try {
            $this->utils->setMenu('/ip hotspot user profile');
            $this->utils->remove(Query::where('name', $name));

            return [
                'status'=> true,
                'message'=> "Packet '{$name}' berhasil dihapus!"
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }

    public function get_profile()
    {
        $return = [];
        $this->utils->setMenu('/ip hotspot user profile');

        foreach ($this->utils->getAll() as $item) {
            /*if ($item->getProperty('address-list') != 'userVoucher') {
                continue;
            } else {*/
                $return[] = [
                    'id'=> $item->getProperty('.id'),
                    'name'=> $item->getProperty('name')
                ];
            // }
        }

        return $return;
    }

    public function get_client()
    {
        $return = [];
        $this->utils->setMenu('/ip hotspot host');

        foreach ($this->utils->getAll() as $item) {
            /*if ($item->getProperty('server') != env('ROUTER_HOTSPOT_SERVER')) {
                continue;
            } else*/if ($item->getProperty('bypassed') == 'true') {
                continue;
            } else {
                if ($item->getProperty('comment')) {
                    $comment = $item->getProperty('comment');
                } else {
                    $this->utils->setMenu('/ip dhcp-server lease');
                    $comment = $this->utils->get(
                        $this->utils->find(
                            Query::where('mac-address',
                                $item->getProperty('mac-address')
                            )
                        ), 'host-name'
                    );
                }

                $return[] = [
                    'id' => [
                        'id' => $item->getProperty('.id'),
                        'mac' => $item->getProperty('mac-address'),
                        'comment' => $item->getProperty('comment')
                    ],
                    'mac' => $item->getProperty('mac-address'),
                    'address' => $item->getProperty('address'),
                    'to-address' => $item->getProperty('to-address'),
                    'server' => $item->getProperty('server'),
                    'uptime' => $item->getProperty('uptime'),
                    'idle-time' => $item->getProperty('idle-time'),
                    'keepalive-timeout' => $item->getProperty('keepalive-timeout'),
                    'host-dead-time' => $item->getProperty('host-dead-time'),
                    'found-by' => $item->getProperty('found-by'),
                    'authorized' => $item->getProperty('authorized'),
                    'bypassed' => $item->getProperty('bypassed'),
                    'comment' => $comment,
                    'bytes' => [
                        'in' => $item->getProperty('bytes-in'),
                        'out' => $item->getProperty('bytes-out')
                    ],
                    'packets' => [
                        'in' => $item->getProperty('packets-in'),
                        'out' => $item->getProperty('packets-out')
                    ]
                ];
            }
        }

        return $return;
    }

    public function del_client($id, $name)
    {
        try {
            $this->utils->setMenu('/ip hotspot active');
            $this->utils->remove(Query::where('mac-address', $id));

            $this->utils->setMenu('/ip hotspot host');
            $this->utils->remove(Query::where('mac-address', $id));

            return [
                'status'=> true,
                'message'=> "Klien '{$name}' berhasil logout dari hotspot."
            ];
        } catch (RouterErrorException $exception) {
            return [
                'status'=> false,
                'message'=> $exception->getMessage()
            ];
        }
    }
}
