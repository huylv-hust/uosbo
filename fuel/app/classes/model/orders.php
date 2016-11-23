<?php

class Model_Orders extends \Fuel\Core\Model_Crud
{
	protected static $_primary_key = 'order_id';
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events'          => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'orders';
	public $data_default;

	public function __construct()
	{
		$this->data_default = Utility::get_default_data(self::$_table_name);
	}

	/*
	 * List all
	 *
	 * @since 04/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public static function get_all_order_list($limit = null, $offset = null, $search)
	{
		$model_ss = new \Model_Mss();
		$model_partner = new Model_Mpartner();
		$model_user = new \Model_Muser();
		$query = DB::select(DB::expr('*,(SELECT name FROM m_user WHERE m_user.user_id = orders.author_user_id) as user_name'))
				->from(self::$_table_name);

		if(isset($search['order_user_id']) && $search['order_user_id'] != '')
		{
			$query->and_where('order_user_id', '=', $search['order_user_id']);
		}
		else if(isset($search['order_department']) && $search['order_department'] != null)
		{
			$list_order_user_id = array(-1);
			$list_users = $model_user->get_list_user_by_departmentid($search['order_department']);
			foreach($list_users as $key => $val)
			{
				$list_order_user_id[] = $val['user_id'];
			}

			$query->and_where('order_user_id', 'IN', $list_order_user_id);
		}

		if(isset($search['ssid']) && $search['ssid'] != null)
		{
			$query->and_where('ss_id', $search['ssid']);
		}

		if (isset($search['group']) && $search['group'] != null)
		{
			$sql = 'select m_ss.ss_id from m_ss
				inner join m_partner on (m_ss.partner_code = m_partner.partner_code)
				where m_partner.m_group_id = :group_id';
			$group_id = Fuel\Core\Input::get('group_search');
			$_array = Fuel\Core\DB::query($sql)->bind('group_id', $search['group'])->execute()->as_array();
			if (count($_array) == 0)
			{
				return array();
			}

			$query->and_where('ss_id', 'in', array_column($_array, 'ss_id'));
		}

		elseif(isset($search['partner']) && $search['partner'] != null)
		{
			$list_ss_id_partner = array();
			$list_ss = $model_ss->get_data(array('partner_code' => $search['partner']));

			foreach($list_ss as $key => $val)
			{
				$list_ss_id_partner[] = $val->ss_id;
			}

			if(count($list_ss_id_partner) <= 0)
			{
				return array();
			}
			else
			{
				$query->and_where('ss_id' ,'in' ,$list_ss_id_partner);
			}
		}

		elseif(isset($search['addr1']) && $search['addr1'] != null)
		{
			$list_ss_id_addr1 = array();
			$list_partner_code = array();

			$list_partner = $model_partner->get_filter_partner(array('addr1' => $search['addr1']));

			foreach($list_partner as $key => $value)
			{
				$list_partner_code[] = $value['partner_code'];
			}

			$config['where'][] = array(
				'partner_code',
				'IN',
				$list_partner_code,
			);
			if(count($list_partner_code) <= 0)
			{
				return array();
			}
			else
			{
				$list_ss = \Model_Mss::forge()->find($config);
				if($list_ss)
				{
					foreach($list_ss as $key => $val)
					{
						$list_ss_id_addr1[] = $val->ss_id;
					}
				}

				if(count($list_ss_id_addr1) <= 0)
				{
					return array();
				}
				else
				{
					$query->and_where('ss_id' ,'in' ,$list_ss_id_addr1);
				}
			}
		}

		if(isset($search['apply_date']) && $search['apply_date'] != null)
		{
			$query->where(DB::expr("DATE_FORMAT(apply_date,'%Y-%m-%d') >= '".$search['apply_date']."'"));
		}

		if(isset($search['post_date']) && $search['post_date'] != null)
		{
			$query->where(DB::expr("DATE_FORMAT(apply_date,'%Y-%m-%d') <= '".$search['post_date']."'"));
		}

		if(isset($search['media_id']) && $search['media_id'] != null)
		{
			$model_post = new Model_Mpost();
			$list_post = $model_post->get_list_by_media($search['media_id']);
			if($list_post)
			{
				$list_post_id = array_column($list_post, 'post_id');
				$query->and_where('post_id' ,'in' ,$list_post_id);
			}
		}

		if(isset($search['maddr2']) && $search['maddr2'] != null)
		{
			$list_ss_id_add2 = array();
			$listss = $model_ss->get_list_all_ss(array('addr2' => $search['maddr2']));
			foreach($listss as $key => $val)
			{
				$list_ss_id_add2[] = $val['ss_id'];
			}

			if(count($list_ss_id_add2))
			{
				$query->and_where('ss_id' ,'in' ,$list_ss_id_add2);
			}
		}

		//get follow author_user_id
		if(isset($search['user_id']) && $search['user_id'] != null)
		{
			$list_ss_id_user_temp[] = -1;
			$list_ss_id_user = self::find_ss_list($search['user_id']);
			if($list_ss_id_user)
			{
				$query->and_where('ss_id', 'IN', $list_ss_id_user);
			}
			else
			{
				$query->and_where('ss_id', 'IN', $list_ss_id_user_temp);
			}
		}


		elseif(isset($search['department']) && $search['department'] != null)
		{
			$list_user_id = array();
			$list_users = $model_user->get_list_user_by_departmentid($search['department']);
			foreach($list_users as $key => $val)
			{
				$list_user_id[] = $val['user_id'];
			}

			$list_partner_code = array();
			if($list_user_id)
			{
				$config_partner['where'][] = array(
					'user_id',
					'IN',
					$list_user_id,
				);
				$list_user_partner = \Model_Mpartner::forge()->find($config_partner);
				if($list_user_partner)
				{
					foreach($list_user_partner as $partner)
					{
						$list_partner_code[] = $partner['partner_code'];
					}
				}
			}

			$list_ss_id_partner[] = -1;
			if($list_partner_code)
			{
				$config_partner_ss['where'][] = array(
					'partner_code',
					'IN',
					$list_partner_code,
				);
				$list_ss_partner = \Model_Mss::forge()->find($config_partner_ss);
				if($list_ss_partner)
				{
					foreach($list_ss_partner as $ss_id)
					{
						$list_ss_id_partner[] = $ss_id['ss_id'];
					}
				}
			}

			$query->and_where('ss_id', 'IN', $list_ss_id_partner);
		}

		if(isset($search['department_id']) && $search['department_id'] != null)
		{
			$list_partnercode_department = array();
			$list_partner_department = $model_partner->get_partnercode_department($search['department_id']);
			foreach($list_partner_department as $key => $val)
			{
				$list_partnercode_department[] = $val['partner_code'];
			}

			$list_ss_id_deparment[] = -1;
			if($list_partnercode_department)
			{
				$config_partner_department['where'][] = array(
					'partner_code',
					'IN',
					$list_partnercode_department,
				);
				$list_ss_deparment = \Model_Mss::forge()->find($config_partner_department);
				if($list_ss_deparment)
				{
					foreach($list_ss_deparment as $ss_id)
					{
						$list_ss_id_deparment[] = $ss_id['ss_id'];
					}
				}
			}

			$query->and_where('ss_id', 'IN', $list_ss_id_deparment);
		}

		$or_where = null;
		$flag = 0;
		if(isset($search['unapproved']) && $search['unapproved'] == 0)
		{
			$or_where .= 'status = 0';
			$flag += 1;
		}

		if(isset($search['approved']) && $search['approved'] == 1)
		{
			$or_where .= $flag > 0 ? ' OR status = 1' : 'status = 1';
			$flag += 1;
		}

		if(isset($search['confirmed']) && $search['confirmed'] == 2)
		{
			$or_where .= $flag > 0 ? ' OR status = 2' : 'status = 2';
			$flag += 1;
		}

		if(isset($search['nonapproved']) && $search['nonapproved'] == -1)
		{
			$or_where .= $flag > 0 ? ' OR status = -1' : 'status = -1';
			$flag += 1;
		}

		if(isset($search['stop']) && $search['stop'] == 3)
		{
			$or_where .= $flag > 0 ? ' OR status = 3' : 'status = 3';
			$flag += 1;
		}

		if($or_where)
		{
			$query->and_where(DB::expr('('.$or_where.')'));
		}

		if(isset($search['order_id']) && $search['order_id'])
		{
			$query->and_where('order_id' ,'=' ,$search['order_id']);
		}

		if(isset($search['start_date']) && $search['start_date'])
		{
			$query->where('post_date', '>=', $search['start_date']);
		}

		if(isset($search['end_date']) && $search['end_date'])
		{
			$query->where('post_date', '<=', $search['end_date']);
		}

		if(isset($search['keyword']) && $search['keyword'])
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($search['keyword'])));
			$sql = 'select orders.order_id from orders
				inner join m_ss on (orders.ss_id = m_ss.ss_id)
				inner join m_partner on (m_ss.partner_code = m_partner.partner_code)
				inner join sssale on (orders.agreement_type = sssale.sssale_id)
				left join m_post on (m_post.post_id = orders.post_id)
				left join m_media on (m_media.m_media_id = m_post.m_media_id)';

			$where = ' WHERE ';
			foreach($arr_keyword as $k => $v)
			{
				$where .= " CONCAT(m_ss.ss_name, m_partner.branch_name, IF(sssale.sale_name IS NULL,'' ,sssale.sale_name), IF(m_media.media_name IS NULL,'' ,m_media.media_name)) like '%$v%' AND";
			}

			$where = trim($where, 'AND');
			$sql = $sql.$where;
			$rs = \Fuel\Core\DB::query($sql)->execute();
			$order_id = [-1];
			foreach($rs as $item)
			{
				$order_id[] = $item['order_id'];
			}

			$query->where('order_id', 'in', $order_id);
		}

		if(isset($search['sale_type']) && $search['sale_type'])
		{
			$sql = 'select sssale_id from sssale where sale_type = '.$search['sale_type'];
			$rs = \Fuel\Core\DB::query($sql)->execute();
			$sssale_id = [-1];
			foreach($rs as $item)
			{
				$sssale_id[] = $item['sssale_id'];
			}

			$query->where('agreement_type', 'in', $sssale_id);
		}

		if($limit)
		{
			$query->limit($limit);
		}

		if($offset)
		{
			$query->offset($offset);
		}

		$query->order_by('order_id', 'desc');

		return $query->as_object('Model_Orders')->execute();

	}

	/*
	 * Get cost of order
	 *
	 * @since 21/10/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public static function cost_of_order($order, $list_ss_id = array(), $check = false)
	{
		$order_ss_list = trim($order['ss_list'] ,',');
		if($order['post_id'])
		{
			$price_media = \Model_Mpost::get_sum_price($order['post_id']);
		}
		else
		{
			return 0;
		}

		if($order_ss_list && $check == true)
		{
			$ss_list = explode(',', $order_ss_list);
			$total_ss = count($ss_list) + 1;
			$total = $price_media / $total_ss;
			$base_cost = (int)$total;
			$total_round = $base_cost;
			$balance = $price_media % $total_ss;

			$num = 0;
			if(in_array($order['ss_id'], $list_ss_id))
			{
				$total_round = $total_round + $balance; // is login + %
				$num = 1;
			}

			//if ss in department logging
			foreach($ss_list as $key => $val)
			{
				if(in_array($val, $list_ss_id))
				{
					if($num > 0)
					{
						$total_round = $total_round + $base_cost;
					}

					$num++;
				}
			}

			$total_price = $total_round;
		}
		else
		{
			$total_price = $price_media;
		}

		return $total_price;
	}

	/*
	 * Get orders in list ss_id
	 *
	 * @since 20/10/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function get_list_order_in_listss($list_ss_primary, $apply_date)
	{
		if(empty($list_ss_primary))
		{
			return array();
		}

		$list_ss_str = implode(',', $list_ss_primary);
		$or_where = null;
		$i = 0;
		foreach($list_ss_primary as $key => $value)
		{
			//$value = ','.$value.',';
			if($i > 0)
			{
				$or_where .= ' OR Find_in_set('.$value.',ss_list) > 0';
			}
			else
			{
				$or_where .= 'Find_in_set('.$value.',ss_list) > 0';
			}

			$i++;
		}

		$where = null;
		if($or_where)
		{
			$where = ' OR ('.$or_where.')';
		}

		$apply_month = date('m', strtotime($apply_date));
		$apply_year  = date('Y', strtotime($apply_date));

		$last_year = $apply_year - 1;
		$next_year = $apply_year + 1;
		if($apply_month < 10)
		{
			$start_date = $last_year.'-10-01';
			$end_date   = $apply_year.'-09-30';
		}
		else
		{
			$start_date = $apply_year.'-10-01';
			$end_date   = $next_year.'-09-30';
		}

		return DB::select('*')
				->from(self::$_table_name)
				->where('status', 2)
				->where(DB::expr('(apply_date >= "'.$start_date.'" AND apply_date <= "'.$end_date.'")'))
				->where(DB::expr('(ss_id IN ('.$list_ss_str.')'.$where.')'))
				->execute()
				->as_array();
	}

	public static function find_ss_list($object, $flag = false)
	{
		$model_ss = new Model_Mss();
		$model_partner = new Model_Mpartner();
		$list_partner_code = array();
		if($flag)
		{
			$list_partner = \Model_Mpartner::forge()->find($object);
		}
		else
		{
			$list_partner = $model_partner->get_info_by_userid($object);
		}

		$list_ss_id = array();
		foreach($list_partner as $item)
		{
			$list_partner_code[] = $item['partner_code'];
		}

		if($list_partner_code)
		{
			$config_partner['where'][] = array(
				'partner_code',
				'IN',
				$list_partner_code,
			);

			$list_ss = \Model_Mss::forge()->find($config_partner);
			if($list_ss)
			{
				foreach($list_ss as $key => $val)
				{
					$list_ss_id[] = $val->ss_id;
				}
			}
		}

		return $list_ss_id;
	}

	/*
	 * Get order info by order_id
	 *
	 * @since 04/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function get_order_info($order_id)
	{
		$result = DB::select('*')
				->from(self::$_table_name)
				->where('order_id', $order_id)
				->execute()
				->as_array();
		if($result)
		{
			return $result[0];
		}

		return $this->data_default;
	}

	/*
	 * Update status
	 *
	 * @since 25/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function order_update($data, $order_id)
	{
		return DB::update(self::$_table_name)
				->set($data)
				->where('order_id',$order_id)
				->execute();
	}

	/*
	 * Save data
	 *
	 * @since 11/05/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function order_save($postarr, $action, $order_id = null)
	{
		if(empty($postarr))
		{
			return false;
		}

		$post = Utility::set_null_data($postarr);

		$data = array(
			'apply_date'         => $post['apply_date'],
			'ss_id'              => $post['ss_id'],
			'location'           => $post['location'],
			'access'             => $post['access'],
			'request_date'       => $post['request_date'],
			'apply_reason'       => $post['apply_reason'],
			'apply_detail'       => $post['apply_detail'],
			'request_people_num' => $post['request_people_num'],
			'work_date'          => $post['work_date'],
			'work_time_of_month' => $post['work_time_of_month'],
			'is_insurance'       => $post['is_insurance'],
			'holiday_work'       => $post['holiday_work'],
			'require_des'        => $post['require_des'] != null ? $post['require_des'] : null,
			'require_experience' => $post['require_experience'],
			'require_other'      => $post['require_other'],
			'require_age'        => $post['require_age'],
			'require_gender'     => $post['require_gender'],
			'require_w'          => $post['require_w'],
		);

		if(isset($post['post_date']))
		{
			$data['post_date'] = $post['post_date'];
		}

		$data['agreement_type'] = null;
		if(isset($post['agreement_type']))
		{
			$data['agreement_type'] = $post['agreement_type'];
		}

		$data['work_type'] = null;
		if(isset($post['work_type']))
		{
			$data['work_type'] = ','.implode(',', $post['work_type']).',';
		}

		$data['post_id'] = null;
		if(isset($post['list_post']) && $post['list_post'] != null)
		{
			$data['post_id'] = $post['list_post'];
		}

		$data['ss_list'] = null;
		if(isset($post['ss_list']) && $post['ss_list'] != null)
		{
			$data['ss_list'] = ','.implode(',', $post['ss_list']).',';
		}

		$data['notes']             = $post['notes'];
		$data['author_user_id']    = $post['author_user_id'];
		$data['interview_user_id'] = $post['interview_user_id'];
		$data['agreement_user_id'] = $post['agreement_user_id'];
		$data['training_user_id']  = $post['training_user_id'];
		$data['updated_at']        = date('Y-m-d H:i:s', time());

		if($order_id && $action != 'copy') //update
		{
			return DB::update(self::$_table_name)->set($data)->where('order_id', $order_id)->execute();
		}
		else //insert
		{
			//copy image
			if($order_id)
			{
				$order = self::find_by_pk($order_id);
				$data['image_content'] = $order->image_content;
				$data['width']         = $order->width;
				$data['height']        = $order->height;
				$data['mine_type']     = $order->mine_type;
			}

			$data['status'] = 0;
			$user_login         = \Fuel\Core\Session::get('login_info');
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$data['create_id']  = $user_login['user_id'];
			return DB::insert(self::$_table_name)->set($data)->execute();
		}
	}

	/*
	 * Send mail confirm
	 *
	 * @since 28/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function sendmail($status, $data, $user_id)
	{
		//status = 99 create order
		//status = 1 order approved
		//status = -1 order noapproved
		$mailto = array();
		if($user_id)
		{
			$user_info = Model_Muser::find_by_pk($user_id);
			if($user_info)
			{
				$mailto[] = $user_info->mail;
			}
		}

		if($data['list_emails'])
		{
			foreach($data['list_emails'] as $email)
			{
				if($email['mail'])
				{
					$mailto[] = $email['mail'];
				}
			}
		}

		//remove duplicate email
		if($mailto)
		{
			array_unique($mailto);
		}

		$subject = null;
		if($status == 99)
		{
			$subject = '媒体掲載オーダーが登録されました';
		}

		if($status == 1)
		{
			$subject = '媒体掲載オーダーが承認されました';
		}

		if($status == -1)
		{
			$subject = '媒体掲載オーダーが非承認になりました';
		}

		$data['status'] = $status;

		return \Utility::sendmail($mailto, $subject, $data, 'email/order');
	}

	public function get_order_id_list($post_id_list)
	{
		$is_where = DB::select('order_id')->from('orders');
		$is_where->where('post_id' ,'in' ,$post_id_list);

		return Fuel\Core\DB::query($is_where)->execute()->as_array();
	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count person for export result csv
	 * @param $filters
	 * @return mixed
	 */
	public function count_person($filters)
	{
		$query = \Fuel\Core\DB::select('employment.review_result', 'employment.contact_result', 'employment.adoption_result')->from('orders');
		$query->join('person','left')->on('orders.order_id', '=', 'person.order_id');
		$query->join('employment','left')->on('person.person_id', '=', 'employment.person_id');

		if(isset($filters['person_id']))
		{
			$filters['person_id'] = empty($filters['person_id']) ? array(0) : $filters['person_id'];
			$query->where('person.person_id', 'in', $filters['person_id']);
		}

		return $query->execute();
	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count person for export result csv
	 * @param $filters
	 * @return int
	 */
	public function count_person_in_ss($filters)
	{
		$query = \Fuel\Core\DB::select('person.person_id')->from('orders');
		$query->join('person','left')->on('orders.order_id', '=', 'person.order_id')->and_on('orders.post_id', '=', 'person.post_id');

		if(isset($filters['ss_id']))
		{
			if(isset($filters['main']) && $filters['main'])
				$query->where('orders.ss_id', '=', $filters['ss_id']);
			else
				$query->where('orders.ss_list', 'like', '%,'.$filters['ss_id'].',%');
		}

		if(isset($filters['sssale_id']) && is_array($filters['sssale_id']))
		{
			$filters['sssale_id'] = (empty($filters['sssale_id'])) ? array(0) : $filters['sssale_id'];
			$query->where('person.sssale_id', 'in', $filters['sssale_id']);
		}

		if(isset($filters['reprinted_via']) && $filters['reprinted_via'])
		{
			$query->where('person.reprinted_via', '=', $filters['reprinted_via']);
		}
		else
		{
			$query->where('person.reprinted_via', 'is', null);
		}

		return $query->execute();
	}

	public function get_list_data($config)
	{
		$obj = static::forge()->find($config);
		if(count($obj))
		{
			return $obj;
		}

		return array();
	}

	public function csv_process($list_orders)
	{
		if(empty($list_orders))
		{
			return array();
		}

		$csv_all_data = array();
		$stt = 0;
		foreach($list_orders as $order)
		{
			$csv_data = array();
			$total_price = 0;
			$order_ss_list = trim($order['ss_list'], ',');
			$ss_list = explode(',', $order_ss_list);
			//get media info
			$price_int = $price_blance = '';
			if($order['post_id'])
			{
				$post = \Model_Mpost::find_by_pk($order['post_id']);
				if($post)
				{
					$media = \Model_Mmedia::find_by_pk($post->m_media_id);
					if($media)
					{
						if($media->type == 1)
						{
							$type = '自力';
						}

						if($media->type == 2)
						{
							$type = '他力';
						}

						if($media->budget_type == 1)
						{
							$budget_type = '求人費';
						}

						if($media->budget_type == 2)
						{
							$budget_type = '販促費';
						}

						if($media->is_web_reprint == 1)
						{
							$is_web_reprint = 'あり';
						}

						if($media->is_web_reprint == 0)
						{
							$is_web_reprint = 'なし';
						}

						$classification = isset(\Constants::$media_classification[$media->classification]) ? \Constants::$media_classification[$media->classification] : '';
						$partner = \Model_Mpartner::find_by_pk($media->partner_code);
						$media_name = $media->media_name;

						$total_ss = 1 + count($ss_list);
						if($media->is_web_reprint == 1)
						{
							$total_ss = (1 + (count($ss_list))) * 2;
						}

						$post_price = $post->price != null ? $post->price : 0;
						$price = $post_price / $total_ss;
						$price_int = (int)$price;
						$price_blance = $price_int + ($post_price % $total_ss);
					}
				}
			}

			//get partner and group by ss_id
			$data_ss = $this->get_ss_info($order['ss_id']);

			//ss_sale info
			if($order['agreement_type'])
			{
				$ss_sale = \Model_Sssale::find_by_pk($order['agreement_type']);
				if($ss_sale)
				{
					$sale_name = $ss_sale->sale_name;
					if($ss_sale->sale_name == null)
					{
						$sale_name = isset(\Constants::$sale_type[$ss_sale->sale_type]) ? \Constants::$sale_type[$ss_sale->sale_type] : '';
					}
				}
			}

			$csv_data[$order['order_id']][] = array(
				$order['order_id'],
				$data_ss['group_info_name'],
				$data_ss['ss_partner_name'],
				$data_ss['ss_info_ss_name'],
				$data_ss['department_name'],
				$data_ss['department_id'],
				$data_ss['user_info_name'],
				isset($sale_name) ? $sale_name : '',
				$order['request_date'] != null ? date('Y/m/d', strtotime($order['request_date'])) : '',
				$order['post_date'] != null ? date('Y/m/d', strtotime($order['post_date'])) : '',
				isset($type) ? $type : '',
				isset($budget_type) ? $budget_type : '',
				isset($classification) ? $classification : '',
				isset($is_web_reprint) ? $is_web_reprint : '',
				isset($media->m_media_id) ? $media->m_media_id : '',
				'media_name' => isset($media_name) ? $media_name : '',
				isset($media->media_version_name) ? $media->media_version_name : '',
				isset($post->name) ? $post->name : '',
				isset($partner->branch_name) ? $partner->branch_name : '',
				'price' => $stt == 0 ? $price_blance : $price_int,
				isset($post_price) ? $post_price : 0,
				$order['notes'],
			);

			//if ss_list
			if($order['ss_list'])
			{
				$order_ss_list = trim($order['ss_list'], ',');
				$ss_list = explode(',', $order_ss_list);
				foreach($ss_list as $ss_key => $ss_item_id)
				{
					$data_ss_id = $this->get_ss_info($ss_item_id);
					$csv_data[$order['order_id']][] = array(
						$order['order_id'],
						$data_ss_id['group_info_name'],
						$data_ss_id['ss_partner_name'],
						$data_ss_id['ss_info_ss_name'],
						$data_ss_id['department_name'],
						$data_ss_id['department_id'],
						$data_ss_id['user_info_name'],
						isset($sale_name) ? $sale_name : '',
						$order['request_date'] != null ? date('Y/m/d', strtotime($order['request_date'])) : '',
						$order['post_date'] != null ? date('Y/m/d', strtotime($order['post_date'])) : '',
						isset($type) ? $type : '',
						isset($budget_type) ? $budget_type : '',
						isset($classification) ? $classification : '',
						isset($is_web_reprint) ? $is_web_reprint : '',
						isset($media->m_media_id) ? $media->m_media_id : '',
						'media_name' => isset($media_name) ? $media_name : '',
						isset($media->media_version_name) ? $media->media_version_name : '',
						isset($post->name) ? $post->name : '',
						isset($partner->branch_name) ? $partner->branch_name : '',
						'price' => isset($price_int) ? $price_int : '',
						isset($post_price) ? $post_price : 0,
						$order['notes'],
					);
				}
			}

			if(isset($media->is_web_reprint) && $media->is_web_reprint == 1)
			{
				foreach($csv_data as $key => $val)
				{
					foreach($val as $k => $v)
					{
						$v['media_name'] = $v['media_name'].'(WEB転載)';
						$csv_data[$key][] = $v;
					}
				}

				foreach($csv_data as $key => $val)
				{
					$blance_2 = (count($val) / 2);
					$csv_data[$key][$blance_2]['price'] = $price_int;
				}
			}

			$csv_all_data[$order['order_id']] = $csv_data;
			$stt++;
		}

		return $csv_all_data;
	}



	/*
	 * Export to csv
	 *
	 * @since 07/12/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function export($csv_data)
	{
		$csv_data_title = array(
			\Constants::$order_title,
		);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=order_list_'.date('Ymd').'.csv');
		$contents = array();
		$title = array();
		$fp = fopen('php://output', 'w');
		fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		fputcsv($fp, $csv_data_title['0']);
		$k = 1;
		foreach($csv_data as $order_ids => $order_id)
		{
			foreach($order_id as $key => $val)
			{
				foreach($val as $v)
				{
					$title[$k] = $v;
					fputcsv($fp, $title[$k]);
					++$k;
				}
			}
		}

		fclose($fp);
		exit();
	}

	public function get_ss_info($ss_id, $get_partner = false)
	{
		//get partner and group by ss_id
		$ss_info = \Model_Mss::find_by_pk($ss_id);
		if($ss_info)
		{
			$ss_partner = \Model_Mpartner::find_by_pk($ss_info->partner_code);
			if($ss_partner)
			{
				$group_info = \Model_Mgroups::find_by_pk($ss_partner->m_group_id);
				$user_info = \Model_Muser::find_by_pk($ss_partner->user_id);
				$department = isset(\Constants::$department[$ss_partner->department_id]) ? \Constants::$department[$ss_partner->department_id] : '';
				if($get_partner)
				{
					return $ss_partner;
				}
			}
		}

		return array(
			'group_info_name' => isset($group_info->name) ? $group_info->name : '',
			'ss_partner_name' => isset($ss_partner->branch_name) ? $ss_partner->branch_name : '',
			'ss_info_ss_name' => isset($ss_info->ss_name) ? $ss_info->ss_name : '',
			'department_name' => isset($department) ? $department : '',
			'department_id'   => isset($ss_partner->department_id) ? $ss_partner->department_id : '',
			'user_info_name'  => isset($user_info->name) ? $user_info->name : '',
		);
	}

	public function get_list_oders_login($user_id)
	{
		$sql = 'SELECT person_id FROM person WHERE  interview_user_id = '.$user_id.' OR business_user_id = '.$user_id.' OR training_user_id ='.$user_id.' OR agreement_user_id ='.$user_id;
		$result = Fuel\Core\DB::query($sql)->execute();
		return $result;
	}
	public function count_data()
	{
		$result = DB::select('*')->from(self::$_table_name)->execute();
		return count($result);
	}
}
