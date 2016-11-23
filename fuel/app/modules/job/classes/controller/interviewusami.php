<?php
namespace Job;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Interviewusami extends \Controller_Uosbo
{
	/**
	 * @author Thuanth6589
	 * action index
	 */
	public function action_index()
	{
		$data['person_id'] = Input::get('person_id', '');
		$inteview_usami = new \Model_Interviewusami();
		if($data['person_id'] == '' || ! \Model_Person::find($data['person_id']))
			return Response::redirect(Uri::base().'job/persons');

		$data['inteview_usami'] = \Model_Interviewusami::find_one_by('person_id', $data['person_id']);
		if(Input::method() == 'POST')
		{
			$fields = Input::post('data');
			$inteview_usami->set_data($fields);
			if($inteview_usami->save_data())
			{
				Session::set_flash('success', \Constants::$message_create_success);
				return Response::redirect(Uri::base().'job/interviewusami?person_id='.$data['person_id']);
			}

			Session::set_flash('error', \Constants::$message_create_error);
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('interviewusami/index', $data);
	}

}