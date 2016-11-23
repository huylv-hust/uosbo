<?php
namespace Job;
use Fuel\Core\Input;
use Fuel\Core\Uri;
use Model\Model_Personfile;
use Model\Job;
use Fuel\Core\Session;
use Fuel\Core\Response;


/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Personfile extends \Controller_Uosbo
{
	/**
	 * @author NamNT
	 * action index
	 */
	public function action_index()
	{
		$data = array();
		$model = new \Model_Personfile();
		$person_id = \Input::get('person_id');
		if( ! $person_id)
		{
			Response::redirect('job/persons');
		}

		$img = $model->get_data_detail($person_id);
		$data_img = array();
		$k = 1;
		foreach($img as $keys => $vals)
		{
			if(isset($vals['0']))
			{
				$data_img[$k] = $vals['0'];
				$data_img[$k]['content'] = base64_encode($data_img[$k]['content']);
			}
			else
			{
				$data_img[$k]['content'] = null;
				$data_img[$k]['attr_id'] = $k;
			}

			++$k;
		}

		$data['img'] = $data_img;
		$data['person_id'] = $person_id;
		if(\Input::method() == 'POST')
		{
			$datas = array();
			$data_post = \Input::post();
			if(isset($data_post['content']))
			{
				$check = true;
				\DB::start_transaction();
				$res = $model->delete_data($person_id);
				if($res >= 0)
				{
					for($i = 1; $i < 6; ++$i)
					{
						$data['content']	= isset($data_post['content'][$i]) ? base64_decode($data_post['content'][$i]) : null;
						$data['attr_id']	= $i;
						$data['person_id'] = $person_id ;
						$data['created_at'] = date('Y-m-d H:i:s') ;
						$data['updated_at'] = date('Y-m-d H:i:s') ;
						$model = \Model_Personfile::forge();
						$model->set($data);
						if( ! $model->save())
						{
							$check = false;
							break;
						}
					}
				}

				if($res >= 0 && $check)
				{
					\DB::commit_transaction();
					Session::set_flash('success', \Constants::$message_create_success);
				}
				else
				{
					\DB::rollback_transaction();
					Session::set_flash('success', \Constants::$message_create_error);
				}

				Response::redirect('job/personfile?person_id='.$person_id);
			}
			else
			{
				$res = $model->delete_data($person_id);
				if($res >= 0)
					Session::set_flash('success', \Constants::$message_create_success);
				else
					Session::set_flash('success', \Constants::$message_create_error);

				Response::redirect('job/personfile?person_id='.$person_id);
			}
		}
		
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('personfile/index',$data);

	}

}