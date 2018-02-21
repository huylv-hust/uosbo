<?php

namespace Ajax;

use Fuel\Core\Controller_Template;
use Fuel\Core\Response;
use Fuel\Core\Session;

class Controller_Dmz extends Controller_Template
{
    public function get_login()
    {
        $login_info = Session::get('login_info');
        $result = [];
        if ($login_info && $login_info['expired'] >= time()) {
            $result['login'] = true;
        } else {
            $result['login'] = false;
        }

        return new Response(json_encode($result), 200, array());
    }
}
