<?php

namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\View;

/**
 * author thuanth6589
 * Class Controller_Groupup
 * @package Master
 */
class Controller_Groupup extends \Controller_Uosbo
{
    /**
     * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
     * show form import
     */
    public function action_index()
    {
        if(Input::method() == 'POST')
        {
            $arr_file = Input::file('csv');
            if (substr($arr_file['name'], -4) == '.csv') {
                $obj = new \Model_Mgroups();
                $file = \Import::convert_utf8($arr_file['tmp_name']);
                $result = $obj->save_import($file);
                $error = $result['error'];
            } else {
                $error[] = 'ＣＳＶのフォーマットが正しくありません';
            }
            if (empty($error) && $result['import']) {
                Session::set_flash('success', '更新完了しました。');
            } else {
                Session::set_flash('error', $error);
            }
        }
        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('groupup');
    }
}
