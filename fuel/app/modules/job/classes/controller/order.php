<?php

/**
 * Input order class
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 29/05/2015
 */

namespace Job;

use Fuel\Core\Session;

class Controller_Order extends \Controller_Uosbo
{
	/*
	 * Input action
	 *
	 * @since 05/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_index()
	{
		$this->template->title = 'UOS求人システム';

		$order_id = \Input::get('order_id');
		$action = \Input::get('action');

		//presenter group settings
		$datafilter['field'] = array(
			'step'  => 3,
			'type'  => 1,
			'label' => array(
				'group'   => 'グループ',
				'partner' => '取引先(受注先)',
			),
		);

		$model_orders = new \Model_Orders();
		$model_user = new \Model_Muser();
		$data = array();
		$data['remaining_cost'] = 0;
		$data['listusers_sales'] = array();
		$data['listusers_interview'] = array();
		$data['listusers_agreement'] = array();
		$data['listusers_training'] = array();
		$data['listusers_author'] = array();

		$data['info'] = $model_orders->get_order_info($order_id);
		//user logging
		$user_login = Session::get('login_info');
		if($order_id)
		{
			if(empty($data['info']['order_id']))
			{
				\Response::redirect(\Uri::base().'job/orders?lost=true');
			}

			//permision
			/*
			if($action != 'copy' && $data['info']['status'] == 3)
			{
				\Response::redirect(\Uri::base().'job/orders?permission=false');
			}
			 *
			 */

			$datafilter['datafilter'] = \Presenter_Group_Filter::edit($datafilter['field']['step'] ,$datafilter['field']['type'], $data['info']['ss_id']);

			$data = $model_user->get_user_info_path($data['info']['author_user_id'],'author',$data);
			//$data = $model_user->get_user_info_path($data['info']['sales_user_id'],'sales',$data);
			$data = $model_user->get_user_info_path($data['info']['interview_user_id'],'interview',$data);
			$data = $model_user->get_user_info_path($data['info']['agreement_user_id'],'agreement',$data);
			$data = $model_user->get_user_info_path($data['info']['training_user_id'],'training',$data);
		}

		//get list ss
		$model_ss = new \Model_Mss();
		$data['listss'] = $model_ss->get_list_all_ss();

		$model_group = new \Model_Mgroups();
		$data['listgroup'] = $model_group->get_all();

		$result = 'error';
		$message = '保存に失敗しました。';
		if(\Input::method() == 'POST')
		{
			if($order_id && ! \Model_Orders::find_by_pk($order_id))
			{
				\Session::set_flash($result, 'オーダーは存在しません');
				return \Response::redirect('job/orders');
			}

			$post = \Input::post();
			$check = true;
			$post['ss_list'] = isset($post['ss_list']) ? $post['ss_list'] : array();
			foreach($post['ss_list'] as $k => $v)
			{
				if($v != '' && ! \Model_Mss::find_by_pk($v))
				{
					$message = 'SSは存在しません';
					$check = false;
					break;
				}
			}

			if(! \Model_Mpost::find_by_pk($post['list_post']))
			{
				$message = '媒体は存在しません';
				$check = false;
			}

			if(! \Model_Mss::find_by_pk($post['ss_id']))
			{
				$message = 'SSは存在しません';
				$check = false;
			}

			if($check && $last = $model_orders->order_save($post, $action, $order_id))
			{
				if($order_id == null || $action == 'copy') //send mail when insert
				{
					$user_id = $user_login['user_id'];
					$user_info = $model_user->get_user_info($user_id);
					$department_id = $user_login['department_id'];
					if($user_info)
					{
						$department_id = $user_info['department_id'];
					}

					$list_emails = $model_user->get_list_email_by_departmentid($department_id, $user_id, 99);
					$maildata = array(
						'order_id'        => $last[0],
						'department_name' => isset($user_info['department_id']) ? \Constants::$department[$user_info['department_id']] : '',
						'list_emails'     => $list_emails,
					);
					$maildata['m_user_name'] = isset($user_info['name']) ? $user_info['name'] : '';
					$model_orders->sendmail(99, $maildata, $user_id);
				}

				$result = 'success';
				$message = '保存しました';
				\Session::set_flash($result, $message);
				$return_url_search = \Cookie::get('return_url_search');
				if($return_url_search)
				{
					return \Fuel\Core\Response::redirect($return_url_search);
				}

				return \Response::redirect('job/orders');
			}

			\Session::set_flash($result, $message);
		}

		$data['post_id_isset'] = false;
		if($data['info']['post_id'])
		{
			if(\Model_Mpost::find_by_pk($data['info']['post_id']))
			{
				$data['post_id_isset'] = true;
			}
		}

		$data['properties'] = $model_orders->data_default;
		$this->template->content = \View::forge('orders/input', $data);
		$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom', $datafilter);
	}

	public function action_post_date()
	{
		if(\Input::method() != 'POST')
		{
			return false;
		}

		$post_date = \Input::post('post_date');
		if( ! $post_date) $post_date = '0000-00-00';
		$order_id = \Input::post('order_id');
		$data = array('post_date' => $post_date);
		$result = 'error';
		$message = '保存に失敗しました。';
		$model_orders = new \Model_Orders();
		if($model_orders->order_update($data, $order_id))
		{
			$result = 'success';
			$message = '保存しました。';
		}
		\Session::set_flash($result, $message);

		return 'true';

	}

	public function action_get_users()
	{
		if(\Input::method() != 'POST')
		{
			return false;
		}

		$department_id = \Input::post('department_id');
		$model_user = new \Model_Muser();
		$data['list_user'] = $model_user->get_list_user_by_departmentid($department_id, false, true);

		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($data), 200, $content_type);

		return false;
	}

	public function action_remaining_cost()
	{
		if(\Input::method() != 'POST')
		{
			return false;
		}

		$user_login = \Session::get('login_info');

		$apply_date = \Input::post('apply_date');
		$post_id = \Input::post('post_id');
		$list_ss =  \Input::post('list_ss');
		$ss_id =  \Input::post('ss_id');
		$order_id = \Input::post('order_id');

		$list_ss_str = '';
		if($list_ss)
		{
			$list_ss_str = implode(',', $list_ss);
		}

		$create_id = $user_login['user_id'];
		$order_status = 0;
		if($order_id && $order_model = \Model_Orders::find_by_pk($order_id))
		{
			$create_id    = $order_model->create_id;
			$order_status = $order_model->status;
		}

		$order = array(
			'post_id'   => $post_id,
			'ss_list'   => $list_ss_str,
			'ss_id'     => $ss_id,
			'status'    => $order_status,
			'action'    => \Input::post('action'),
		);

		$remaining_cost = $this->get_remaining_cost($apply_date, $list_ss, $ss_id, $order);
		$data['remaining_cost'] = number_format(round($remaining_cost));

		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($data), 200, $content_type);

		return false;
	}

	public function get_remaining_cost($apply_date, $list_ss, $ss_id, $order = array())
	{
		//get ss_info
		$ss_info = \Model_Mss::find_by_pk($ss_id);
		//get list ss by partner_code
		$list_ss_primary = array();
		if($ss_info)
		{
			$model_mss = new \Model_Mss();
			$partner = \Model_Mpartner::find_by_pk($ss_info->partner_code);
			if($partner)
			{
				$department_id = $partner->department_id;
			}

			$list_ss_partner_code = $model_mss->get_list_all_ss(array('partner_code' => $ss_info->partner_code));
			if($list_ss_partner_code)
			{
				$list_ss_primary = array_column($list_ss_partner_code, 'ss_id');
			}
		}

		$department_id = isset($partner->department_id) ? $partner->department_id : '';

		//get price for order
		$cost_of_order = 0;
		if($order)
		{
			$check = true;
			if($order['status'] == 2)
			{
				$check = false;
			}

			if($order['status'] == 2 && $order['action'] == 'copy'){
				$check = true;
			}

			if($check == true)
			{
				$cost_of_order = \Model_Orders::cost_of_order($order, $list_ss_primary, true);
			}
		}

		//get list orders by list_ss_id
		$list_orders = \Model_Orders::get_list_order_in_listss($list_ss_primary, $apply_date);

		$total_price = 0;
		foreach($list_orders as $key => $value)
		{
			$total_price = $total_price + \Model_Orders::cost_of_order($value, $list_ss_primary, true);
		}

		//get plan job_cost
		$job_cost = \Model_Plan::get_info_by_startdate($apply_date, $department_id);

		$remaining_cost = ($job_cost - $total_price) - $cost_of_order;

		return $remaining_cost;
	}

	public function get_list_ss_by_department($list_ss)
	{
		$list_all_ss = array();
		if($list_ss)
		{
			$config['where'][] = array(
				'ss_id',
				'in',
				$list_ss,
			);
			$list_all_ss = \Model_Mss::find($config) ? \Model_Mss::find($config) : array();
		}

		$list_partner_code = array();
		foreach($list_all_ss as $ss_item)
		{
			$list_partner_code[] = $ss_item->partner_code;
		}

		$list_all_ss_id = array();
		if($list_partner_code)
		{
			$config_partner['where'][] = array(
				'partner_code',
				'in',
				$list_partner_code,
			);
			$list_all_ss_temp = \Model_Mss::find($config_partner);
			foreach($list_all_ss_temp as $temp)
			{
				$list_all_ss_id[] = $temp->ss_id;
			}
		}

		return $list_all_ss_id;
	}
}

