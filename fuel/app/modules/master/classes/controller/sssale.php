<?php

/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * Copyright: SETA- Asia
 * File Class/Controler/
**/
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Sssale extends \Controller_Uosbo
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * list, create, update sssale
	 */
	public function action_index()
	{
		$data = array();
		$sssale = new \Model_Sssale();
		$data['ss_id'] = Input::get('ss_id', null);
		$ss_name = Input::get('ss_name');
		$data['ss_name'] = Input::get('ss_name') ? urldecode($ss_name) : null;
		if( ! isset($data['ss_id']) || ! isset($data['ss_name']) || ! \Model_Mss::find_by_pk($data['ss_id']))
		{
			Session::set_flash('error', '売上形態は存在しません');
			return Response::redirect('/master/sslist');
		}

		Session::set('sssale_url', Uri::current().'?ss_id='.$data['ss_id'].'&ss_name='.$ss_name);
		if(Input::method() == 'POST')
		{
			$sssale_id = Input::post('sssale_id',null);
			if($sssale_id and ! \Model_Sssale::find_by_pk($sssale_id))
			{
				Session::set_flash('error','売上形態は存在しません');
				return Response::redirect(Session::get('sssale_url'));
			}

			$fields = $sssale->set_data(Input::post());
			$check = true;
			$message = \Constants::$message_create_error;
			if( ! $sssale->check_data_null($fields))
			{
				$check = false;
				$message = '入力内容がありません。';
			}

			if($check == true && $sssale->save_data($fields))
			{
				Session::set_flash('success', \Constants::$message_create_success);
				return Response::redirect(Session::get('sssale_url'));
			}

			if( ! isset($sssale_id))
				$data['action'] = 'add';

			Session::set_flash('error-'.Input::post('panel_index'), $message);
		}

		$data['sale_type'] = \Constants::$sale_type;
		$data['hours'] = \Constants::$hours;
		$data['minutes'] = \Constants::$minutes;
		$data['sssales'] = $sssale->get_data($data['ss_id']);
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('sssale',$data);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete sssale
	 */
	public function action_delete()
	{
		if(Input::method() == 'POST')
		{
			$sssale_id = Input::post('sssale_id');
			$result = 'error-'.Input::post('panel_index');
			$message = \Constants::$message_delete_error;
			if(isset($sssale_id) && $sssale = \Model_Sssale::find_by_pk($sssale_id))
			{
				if($sssale->delete_data())
				{
					$result = 'success';
					$message = \Constants::$message_delete_success;
				}
			}

			Session::set_flash($result, $message);
		}

		$url = (Session::get('sssale_url') ? Session::get('sssale_url') : Uri::base().'master/sslist');
		return Response::redirect($url);
	}
}
