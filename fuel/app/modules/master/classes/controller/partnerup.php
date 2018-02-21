<?php
/**
 * @author huylv6635
 * Date: 12/6/2016
 * Time: 11:45 AM
 */

namespace Master;

use Fuel\Core\Input;
use Fuel\Core\View;

class Controller_Partnerup extends \Controller_Uosbo
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
                $import = new \Importpartner();
                $res = $import->update_csv($arr_file['tmp_name']);
                $data['no_update'] = $import->no_update;
                if($res)
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
                $data['format'] = array('ＣＳＶのフォーマットが正しくありません');
            }
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('partnerup', $data);
    }
}