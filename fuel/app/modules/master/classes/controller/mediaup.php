<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use ImportMedia;

/**
 * @author Namdd6566 <namdd6589@seta-asia.com.vn>
 * Class Controller_Media
 * @package Master
 */
class Controller_Mediaup extends \Controller_Uosbo
{

    public function action_index()
    {
        $import = new ImportMedia();
        $data = array();
        $data['file_name'] = '';
        if (Input::method() == 'POST') {
            $arr_file = Input::file('csv');
            if (substr($arr_file['name'], -4) == '.csv') {
                $data['file_name'] = $arr_file['name'];
                $res = $import->update_csv($arr_file['tmp_name']);
                if ($res) {
                    $data['success'] = true;

                } else {
                    $data['error'] = $import->get_errors();
                }
            } else {
                $data['error'] = array('ＣＳＶのフォーマットが正しくありません');
            }
        }
        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('mediaup', $data);
    }

}