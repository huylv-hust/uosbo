<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_User
 * @package Master
 */
class Controller_User extends \Controller_Uosbo
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action create/edit user
	 * @return mixed
	 */
	public function action_index()
	{
		$data = array();
		$user_id = Input::get('user_id');
		if(isset($user_id))
		{
			$data['user'] = \Model_Muser::find_by_pk($user_id);
			if( ! isset($data['user']))
			{
				Session::set_flash('error', 'ユーザが存在しません');
				return Response::redirect('/master/users');
			}
		}

		if(Input::method() == 'POST')
		{
			$url = Session::get('users_url') ? Session::get('users_url') : Uri::base().'master/users';
			$user_id = Input::post('user_id', null);
			if($user_id && ! \Model_Muser::find_by_pk($user_id))
			{
				Session::set_flash('success', 'ユーザーは存在しません');
				return Response::redirect($url);
			}

			$user = new \Model_Muser();
			$fields = $user->set_data(Input::post());

			$check = $user->validate_unique_login_id($fields['login_id'], isset($fields['user_id']) ? $fields['user_id'] : null);

			if($check && $user->save_data($fields))
			{
				Session::set_flash('success', \Constants::$message_create_success);
				return Response::redirect($url);
			}

			$message = \Constants::$message_create_error;
			if( ! $check)
				$message = '入力したＩＤは既存に存在してます。';

			Session::set_flash('error', $message);
		}

		$data['department'] = \Constants::get_create_department();
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('user',$data);
	}

	/**
	* @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	* action delete user
	*/
	public function action_delete()
	{
		if(Input::method() == 'POST')
		{
			$user_id = Input::post('user_id', null);
			$result = 'error';
			if( ! \Model_Muser::find_by_pk($user_id))
			{
				$message = 'ユーザーは存在しません';
			}
			else
			{
				$message = \Constants::$message_delete_error;
				$user = new \Model_Muser();
				if($user->delete_data($user_id))
				{
					$result = 'success';
					$message = \Constants::$message_delete_success;
				}
			}

			Session::set_flash($result, $message);
		}

		$url = Session::get('users_url') ? Session::get('users_url') : Uri::base().'master/users';
		return Response::redirect($url);
	}
}