<?php
namespace job;
use Fuel\Core\Input;

class Controller_Jobup extends \Controller_Uosbo
{
	public function action_index()
	{
		$this->template->title = 'UOS求人システム';
		$data = array();
		$data['file_name'] = '';
		if(Input::method() == 'POST')
		{
		    set_time_limit(0);

			$arr_file = Input::file('csv');
			if(substr($arr_file['name'],-4) == '.csv')
			{
				$data['file_name'] = $arr_file['name'];
				$import = new \Import();
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
				$data['error'] = array('ＣＳＶのフォーマットが正しくありません');
			}
		}


		$this->template->content = \Fuel\Core\View::forge('jobup/index',$data);
	}
}
