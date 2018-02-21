<?php

/**
 * Concierges class
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 03/11/2015
 */

namespace Support;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;

class Controller_Concierges extends \Controller_Uosbo
{
	/*
	 * Index action
	 *
	 * @since 03/11/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_index()
	{
		$this->template->title = 'UOS求人システム';
		$data = array();

		//get search value
		if($search_arr = \Input::get())
		{
			Session::set('url_filter_concierges',http_build_query(\Input::get()));
		}

		//set return url after edit
		$pagination_url = \Uri::base().'support/concierges/index';
		$return_url = \Uri::current();
		if(\Input::get())
		{
			$pagination_url = \Uri::base().'support/concierges/index'.'?'.http_build_query($_GET);
			$return_url = \Uri::current().'?'.http_build_query($_GET);
		}

		//setcookie
		\Cookie::set('register_url_search', $return_url, 60 * 60 * 24);

		//config pagination
        unset($search_arr['limit']);
		$config = array(
			'pagination_url' => $pagination_url,
			'total_items'    => count(\Model_Concierges::get_register_list(null, null, $search_arr)),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'uri_segment'    => 'page',
			'num_links'      => \Constants::$default_num_links,
			'show_last' => true,
		);

		//setup pagination
		$pagination = \Uospagination::forge('concierges-pagination', $config);

		$data['listall'] = \Model_Concierges::get_register_list($pagination->per_page, $pagination->offset, $search_arr);
		$data['concierges_autocomplete'] = \Model_Concierges::get_register_list(null, null, array());

		$this->template->content = \View::forge('concierges/index', $data);
	}

	public function action_change_status()
	{
		if($register_id = Input::post('register_id'))
		{
			$user_login = Session::get('login_info');

			$concierges = \Model_Concierges::find_by_pk($register_id);
			if(Input::post('status') == 0)
			{
				$concierges->set(array('status' => 1, 'user_id' => $user_login['user_id'], 'update_at' => date('Y-m-d H:i:s')));
			}

			if(Input::post('status') == 1)
			{
				$concierges->set(array('status' => 0, 'user_id' => null, 'update_at' => null));
			}

			$concierges->save();
			Response::redirect(Uri::base().'support/concierges?'.Session::get('url_filter_concierges'));
		}
		Response::redirect(Uri::base().'support/concierges?'.Session::get('url_filter_concierges'));
	}


}

