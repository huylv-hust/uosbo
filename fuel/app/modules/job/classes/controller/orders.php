<?php

/**
 * Order class
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 29/05/2015
 */

namespace Job;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Uri;

class Controller_Orders extends \Controller_Uosbo
{
	/*
	 * List orders
	 *
	 * @since 29/05/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_index()
	{
		$export = \Input::get('export', false);

		//set cookie order
		\Fuel\Core\Cookie::set('person_url',Uri::base().'job/orders');

		$this->template->title = 'UOS求人システム';

		//get search value
        if (Input::get('start_id')) {
            $_GET['start_id'] = mb_convert_kana($_GET['start_id'], 'n', 'utf-8');
        }
        if (Input::get('end_id')) {
            $_GET['end_id'] = mb_convert_kana($_GET['end_id'], 'n', 'utf-8');
        }
		$search_arr = \Input::get();

		//set return url after edit
		$pagination_url = \Uri::base().'job/orders/index';
		$return_url = \Uri::current();
		if(\Input::get('flag') != null)
		{
			$pagination_url = \Uri::base().'job/orders/index'.'?'.http_build_query($_GET);
			$return_url = \Uri::current().'?'.http_build_query($_GET);
		}

		//config pagination
        unset($search_arr['limit']);
		$config = array(
			'pagination_url' => $pagination_url,
			'total_items'    => \Model_Orders::countFilter($search_arr),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'uri_segment'    => 'page',
			'num_links'      => \Constants::$default_num_links,
			'show_last'      => true,
		);

		if($export)
		{
			$config['per_page'] = 100000;
		}
		else
		{
			//setcookie
			\Cookie::set('return_url_search', $return_url, 60 * 60 * 24);
		}

		//setup pagination
		$pagination = \Uospagination::forge('orders-pagination', $config);

		$model_group = new \Model_Mgroups();
		$data['listgroup'] = $model_group->get_type(1);

		//get list media
		$model_media = new \Model_Mmedia();
        $data['listmedias'] = [];
		foreach ($model_media->get_list_all_media() as $row) {
            $data['listmedias'][$row['m_media_id']] = $row['media_name'];
        }

		//get all orders
		$model_order = new \Model_Orders();
		$data['listorders'] = \Model_Orders::filter($search_arr, $pagination->per_page, $pagination->offset);

		if($export)
		{
			$csv_data = $model_order->csv_process($data['listorders']);
			\Model_Orders::export($csv_data);
		}

		foreach($data['listorders'] as $key => $value)
		{
			$data['listorders'][$key]['image_content'] = base64_encode($data['listorders'][$key]['image_content']);
		}

		$data['orders_autocomplete'] = $model_order->get_data_for_autocomplete();

		$this->template->content = \View::forge('orders/index', $data);

        $rUri = \Fuel\Core\Input::server('REQUEST_URI');
        $this->template->content->set('requestUri', $rUri, false);
        $this->template->content->set(
            'requestUriLost',
            $rUri . (strpos($rUri, '?') ? '&' : '?') . 'lost=true',
            false
        );
	}

	/*
	 * Get partner ajax
	 *
	 * @since 28/05/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_get_partner()
	{
		$address1 = \Input::post('addr1');

		//model partner
		$data = array();
		$model_partner = new \Model_Mpartner();
		$config = array('type' => 1);
		if($address1)
		{
			$config = array(
				'addr1' => $address1,
				'type'  => 1,
			);
		}

		$data['list_partner'] = $model_partner->get_filter_partner($config);

		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($data), 200, $content_type);

		return false;
	}

	/*
	 * Update status ajax
	 *
	 * @since 29/05/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_update_status()
	{
		if(\Input::method() == 'POST')
		{
			$status = \Input::post('status');
			$order_id = \Input::post('order_id');
			$reason = \Input::post('reason', null);

			$result = 'error';
			$message = '保存に失敗しました。';
			$model_orders = new \Model_Orders();
			$order_info = \Model_Orders::find_by_pk($order_id);
			if( ! $order_info)
			{
				return 'failed';
			}

			if($status == 2)
			{
				if($user_login = Session::get('login_info'))
				{
					$model_orders->order_update(array('order_user_id' => $user_login['user_id']),$order_id);
				}
			}

			$db_status = array('status' => $status);

			if($model_orders->order_update($db_status, $order_id))
			{
				if($status == 1 || $status == -1)
				{
					//get list media
					$model_media = new \Model_Mmedia();
					$listmedias = $model_media->get_list_all_media();
					$media_name = null;
					if($order_info->post_id && $listmedias != null)
					{
						$listmedias = array_column($listmedias, 'media_name', 'm_media_id');
						$post_info = \Model_Mpost::find_by_pk($order_info->post_id);
						if($post_info)
						{
							$media_id = $post_info->m_media_id;
							$media_name = isset($listmedias[$media_id]) ? $listmedias[$media_id] : null;
						}
					}

					//get list ss
					$model_ss = new \Model_Mss();
					$listss = $model_ss->get_list_all_ss();
					$ssitem = null;
					if($order_info->ss_list && $listss != null)
					{
						$listss_name = array_column($listss, 'ss_name', 'ss_id');
						$ss_list_item = explode(',', trim($order_info->ss_list ,','));
						foreach($ss_list_item as $key => $value)
						{
							if(array_key_exists($value, $listss_name))
							{
								$ssitem .= $listss_name[$value].',';
							}
						}
					}

					$ssitem = trim($ssitem, ',');
					$agreement_type = null;
					if($order_info->agreement_type)
					{
						$agreement = \Model_Sssale::find_by_pk($order_info->agreement_type);
					}

					$agreement_type = isset($agreement->sale_name) ? $agreement->sale_name : null;
					if($order_info->ss_id)
					{
						$ss_info = \Model_Mss::find_by_pk($order_info->ss_id);
						$ss_name = isset($ss_info->ss_name) ? $ss_info->ss_name : null;
					}

					$model_user = new \Model_Muser();
					//user logging
					$user_login = \Session::get('login_info');
					$user_id = $user_login['user_id'];
					$user_info = $model_user->get_user_info($user_id);
					$department_id = $user_login['department_id'];
					if($user_info)
					{
						$department_id = $user_info['department_id'];
					}

					$list_emails = $model_user->get_list_email_by_departmentid($department_id, $user_id, 1);

					$maildata = array(
						'order_id'        => $order_id,
						'list_media_name' => $media_name,
						'agreement_type'  => $agreement_type,
						'ss_name'         => $ss_name,
						'ss_list_name'    => $ssitem,
						'reason'          => $reason,
						'list_emails'     => $list_emails,
					);
					$model_orders->sendmail($status, $maildata, $order_info->create_id);
				}

				$result = 'success';
				switch($status)
				{
				    case -1:
						$message = '非承認しました';
				    break;

				    case 1:
						$message = '承認しました';
				    break;

				    case 2:
						$message = '確定しました。';
				    break;

				    case 3:
						$message = '停止しました。';
				    break;

				    default:
						$message = '非承認しました';
				    break;
				}
			}

			\Session::set_flash($result, $message);

			return 'true';
		}
	}

	public function action_del_order()
	{
		$order_id = \Input::get('order_id');
		$model = \Model_Orders::find_by_pk($order_id);
		if( ! $model)
		{
			\Response::redirect('job/orders?lost=true');
		}

		$result = 'error';
		$message = '削除に失敗しました。';
		if($model->delete())
		{
			$result = 'success';
			$message = '削除しました。';
		}

		\Session::set_flash($result, $message);

		$return_url_search = \Cookie::get('return_url_search');
		if($return_url_search)
		{
			return \Fuel\Core\Response::redirect($return_url_search);
		}

		return \Response::redirect('job/orders');
	}
}

