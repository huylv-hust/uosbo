<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\View;

/**
 * @author HuyLv6635
 * Class Controller_Password
 * @package Master
 */
class Controller_Password extends \Controller_Uosbo
{
    /**
     * @author HuyLv6635
     * action Change Password
     * @return mixed
     */
    public function action_index()
    {
        $data = array();
        $login_info = Session::get('login_info');
        if (Input::method() == 'POST') {
            $password = Input::post('password');
            $confirm = Input::post('confirm');

            if ($password != $confirm) {
                Session::set_flash('error', 'パスワードとパスワード(確認用)が一致しません ');
            } else {
                $obj = new \Model_Muser();
                if ($obj->change_password($password, $login_info['user_id'])) {
                    Session::set_flash('success', '保存しました');
                } else {
                    Session::set_flash('error', '保存失敗しました');
                }
            }
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('password', $data);
    }
}
