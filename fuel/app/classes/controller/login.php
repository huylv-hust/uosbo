<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller login
 **/
class Controller_Login extends \Fuel\Core\Controller_Template
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action login
	 */
	public function action_index()
	{
		if(\Fuel\Core\Session::get('login_info'))
			\Fuel\Core\Response::redirect(($uri = \Fuel\Core\Session::get('uri_before_login')) ? $uri : \Fuel\Core\Uri::base());

		if(\Fuel\Core\Input::post())
		{
			$login_id = \Fuel\Core\Input::post('login_id');
			$pass = \Fuel\Core\Input::post('password');

			if($user = Model_Muser::find_one_by(array('login_id' => $login_id, 'pass' => hash('SHA256',$pass))))
			{
				$login_info = array(
					'department_id' => $user['department_id'],
					'division_type' => $user['division_type'],
					'name'          => $user['name'],
					'login_id'      => $user['login_id'],
					'email'         => $user['mail'],
					'user_id'       => $user['user_id'],
					'expired'       => time() + 30 * 60,
				);
				\Fuel\Core\Session::set('login_info',$login_info);
				$url = \Fuel\Core\Uri::base();
				if($user['division_type'] == 2)
					$url = \Fuel\Core\Uri::base().'?division=2';
				if($user['division_type'] == 3)
					$url = \Fuel\Core\Uri::base().'?division=3';
				\Fuel\Core\Response::redirect(($uri = \Fuel\Core\Session::get('uri_before_login')) ? $uri : $url);
			}

			\Fuel\Core\Session::set_flash('error','ログインIDもしくはパスワードが正しくありません');
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('login/index');
	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action logout
	 */
	public function action_logout()
	{
		\Fuel\Core\Session::delete('login_info');
		\Fuel\Core\Session::delete('uri_before_login');
		\Fuel\Core\Response::redirect('/login');
	}


}