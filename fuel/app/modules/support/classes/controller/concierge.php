<?php

/**
 * Concierge class
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 03/11/2015
 */

namespace Support;

class Controller_Concierge extends \Controller_Uosbo
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

		$register_id = \Input::get('register_id');
		$model = \Model_Concierges::find_by_pk($register_id);
		if( ! $model)
		{
			\Response::redirect(\Uri::base().'support/concierges');
		}

		$data['model'] = $model;

		$this->template->content = \View::forge('concierges/detail', $data);
	}
}

