<?php

class Controller_Uosbo extends \Controller_Template
{
	public $template = 'template';
	public function __construct()
	{
		if( ! \Fuel\Core\Input::is_ajax())
		{
			$protocol = strtolower(substr(\Fuel\Core\Input::server('SERVER_PROTOCOL'),0,5)) == 'https' ? 'https://' : 'http://';
			$uri_current = $protocol.\Fuel\Core\Input::server('HTTP_HOST').\Fuel\Core\Input::server('REQUEST_URI');
			if(!Input::get('export',false))
			{
				\Fuel\Core\Session::set('uri_before_login',$uri_current);
			}
		}
	}
	public function before()
	{
		parent::before();
		if($login_info = \Fuel\Core\Session::get('login_info') and $login_info['expired'] < time())
			\Fuel\Core\Session::delete('login_info');

		if($login_info = \Fuel\Core\Session::get('login_info'))
		{
			$login_info['expired'] = time() + 30 * 60;
			\Fuel\Core\Session::set('login_info', $login_info);
		}

		if( ! \Fuel\Core\Session::get('login_info'))
			\Fuel\Core\Response::redirect('login');

		if( ! $this->_check_permission())
			\Fuel\Core\Response::redirect('access_denied');
	}

	private function _check_permission()
	{
		$user_info = \Fuel\Core\Session::get('login_info');
		$group = $user_info['division_type'];
		$controller = \Fuel\Core\Request::active()->controller;
		$action = \Fuel\Core\Request::active()->action;
		if($group == 1 || $controller == 'Controller_Default')
			return true;

		$accept_controller = MyAuth::$roles[$group];
		$accept_action = (isset($accept_controller[$controller])) ? ($accept_controller[$controller] != '*' ? explode(',', $accept_controller[$controller]) : '*') : '';
		if( ! isset($accept_controller[$controller]) || ! in_array($controller, array_keys($accept_controller)) || ($accept_action != '*' && ! in_array($action, $accept_action)))
			return false;

		return true;
	}
}