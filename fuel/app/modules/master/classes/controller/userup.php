<?php
/**
 * @author huylv6635
 * Date: 16/6/2017
 * Time: 15:00 PM
 */

namespace Master;

use Fuel\Core\Input;
use Fuel\Core\View;

class Controller_Userup extends \Controller_Uosbo
{

    /**
     * @author huylv6635
     * @throws \Exception
     */
    public function action_index()
    {
        $data = array();
        $data['file_name'] = '';
        if(Input::method() == 'POST')
        {
            $arr_file = Input::file('csv');
            if(substr($arr_file['name'],-4) == '.csv')
            {
                $data['file_name'] = $arr_file['name'];
                $import = new \Importuser();
                $result = $import->update_csv($arr_file['tmp_name']);
                $data['no_update'] = $import->no_update;
                if($result)
                {
                    $data['success'] = true;
                }
                else
                {
                    $data['error'] = $import->get_errors();
                }
            }
            else
            {
                $data['format'] = array('ＣＳＶのフォーマットが正しくありません。');
            }
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('userup', $data);
    }
}
