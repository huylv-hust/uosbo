<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @param:
 **/
namespace Job;

use DateTime;
use Fuel\Core\Date;
use Fuel\Core\Input;
use Fuel\Core\Model;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Parser\View;

class Controller_Plan extends \Controller_Uosbo
{
	/**
	 * @author dangbc <dangbc6591@seta-asia.com.vn>
	 * create and edit plan
	 */
	public function action_index()
	{
		$department = \Constants::$department;

		if($data_post = Input::post())
		{
			$plan = new \Model_Plan();
			$return = 'error';
			$messege = '保存に失敗しました。';
			$filter_date = $data_post['filter_date'];
				if($plan->save_plan($filter_date,$data_post))
				{
					$return = 'success';
					$messege = '保存しました';
				}

			Session::set_flash($return,$messege);
		}

		$data['department'] = $department;
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('plan/index', $data);
	}
	/**
	 * @author dangbc <dangbc6591@seta-asia.com.vn>
	 * filter plan
	 */
	public function action_loaddata()
	{
		$year = Input::post('year');
		$plan = new \Model_Plan();
		$data_plan = $plan->data_plan($year);
		return json_encode($data_plan);
	}
}