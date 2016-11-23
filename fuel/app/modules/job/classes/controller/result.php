<?php
namespace Job;

use Fuel\Core\Input;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Result
 * @package Job
 */
class Controller_Result extends \Controller_Uosbo
{
	public $m_job;
	public $m_person;
	public $m_order;
	public $field = array(
		'実績区分', 'オーダーID', '同募数', 'WEB転載経由', '求人情報ID', '取引先グループ', '取引先', 'SS', '部門', '部門コード', '営業担当', '面接担当者',
		'売上形態', '申請日', '掲載日', '自他区分', '予算区分', '分類', 'WEB転載', '媒体ID', '媒体名', '版名', '掲載枠名称', '発注先', '金額', '本数(小計)', '応募',
		'面接', '不通', '辞退数', '不来', '無資格', '条件断り', '態度', '定員', '他断り', '条件辞退', '他辞退', '若年', '定年', '髪', '採用', '不採用', '登録',
	);
	public $type = array(
		'order','job','person',
	);

	public function __construct()
	{
		$this->m_job = new \Model_Job();
		$this->m_person = new \Model_Person();
		$this->m_order = new \Model_Orders();
	}

	/**
	 * get all data ss
	 * @return array
	 */
	private function _get_data_ss()
	{
		$result = array();
		$list = \Model_Mss::find_all();
		foreach ($list as $ss)
		{
			$result[$ss['ss_id']]['partner_code'] = $ss['partner_code'];
			$result[$ss['ss_id']]['ss_name'] = $ss['ss_name'];
		}

		return $result;
	}

	/**
	 * get all data sssale
	 * @return array
	 */
	private function _get_data_sssale()
	{
		$result = array();
		$list = \Model_Sssale::find_all();
		foreach ($list as $sssale)
		{
			$result[$sssale['sssale_id']]['ss_id'] = $sssale['ss_id'];
			$result[$sssale['sssale_id']]['sale_name'] = $sssale['sale_name'];
			$result[$sssale['sssale_id']]['sale_type'] = $sssale['sale_type'];
		}

		return $result;
	}

	/**
	 * get all data partner
	 * @return array
	 */
	private function _get_data_partner()
	{
		$result = array();
		$list = \Model_Mpartner::find_all();
		foreach ($list as $partner)
		{
			$result[$partner['partner_code']]['m_group_id'] = $partner['m_group_id'];
			$result[$partner['partner_code']]['branch_name'] = $partner['branch_name'];
			$result[$partner['partner_code']]['user_id'] = $partner['user_id'];
			$result[$partner['partner_code']]['department_id'] = $partner['department_id'];
		}

		return $result;
	}

	/**
	 * get all data group
	 * @return array
	 */
	private function _get_data_group()
	{
		$result = array();
		$list = \Model_Mgroups::find_all();
		foreach ($list as $group)
		{
			$result[$group['m_group_id']]['name'] = $group['name'];
		}

		return $result;
	}

	/**
	 * get all data user
	 * @return array
	 */
	private function _get_data_user()
	{
		$result = array();
		$list = \Model_Muser::find_all();
		foreach ($list as $user)
		{
			$result[$user['user_id']]['name'] = $user['name'];
			$result[$user['user_id']]['department_id'] = $user['department_id'];
		}

		return $result;
	}

	/**
	 * get all data post
	 * @return array
	 */
	private function _get_data_post()
	{
		$result = array();
		$list = \Model_Mpost::find_all();
		foreach ($list as $post)
		{
			$result[$post['post_id']]['m_media_id'] = $post['m_media_id'];
			$result[$post['post_id']]['name'] = $post['name'];
			$result[$post['post_id']]['price'] = $post['price'];
		}

		return $result;
	}

	/**
	 * get all data media
	 * @return array
	 */
	private function _get_data_media()
	{
		$result = array();
		$list = \Model_Mmedia::find_all();
		foreach ($list as $media)
		{
			$result[$media['m_media_id']]['type'] = $media['type'];
			$result[$media['m_media_id']]['budget_type'] = $media['budget_type'];
			$result[$media['m_media_id']]['classification'] = $media['classification'];
			$result[$media['m_media_id']]['is_web_reprint'] = $media['is_web_reprint'];
			$result[$media['m_media_id']]['media_name'] = $media['media_name'];
			$result[$media['m_media_id']]['media_version_name'] = $media['media_version_name'];
			$result[$media['m_media_id']]['partner_code'] = $media['partner_code'];
		}

		return $result;
	}

	private function _count_person($filters,$type = 'order')
	{
		if($type == 'job')
			$persons = $this->m_job->count_person($filters);
		elseif($type == 'person')
			$persons = $this->m_person->count_person($filters);
		else
			$persons = $this->m_order->count_person($filters);

		$count_review_result_0 = 0;
		$count_review_result_2 = 0;
		$count_review_result_3 = 0;
		$count_review_result_4 = 0;
		$count_review_result_5 = 0;
		$count_review_result_6 = 0;
		$count_review_result_7 = 0;
		$count_review_result_8 = 0;
		$count_review_result_9 = 0;
		$count_review_result_10 = 0;
		$count_review_result_11 = 0;
		$count_review_result_12 = 0;
		$count_review_result_13 = 0;
		$count_contact_result_2 = 0;
		$count_adoption_result_1 = 0;
		$count_adoption_result_2 = 0;
		$count_adoption_result_3 = 0;
		foreach($persons as $person)
		{
			if($person['review_result'] > 0) $count_review_result_0++;
			if($person['review_result'] == 2) $count_review_result_2++;
			if($person['review_result'] == 3) $count_review_result_3++;
			if($person['review_result'] == 4) $count_review_result_4++;
			if($person['review_result'] == 5) $count_review_result_5++;
			if($person['review_result'] == 6) $count_review_result_6++;
			if($person['review_result'] == 7) $count_review_result_7++;
			if($person['review_result'] == 8) $count_review_result_8++;
			if($person['review_result'] == 9) $count_review_result_9++;
			if($person['review_result'] == 10) $count_review_result_10++;
			if($person['review_result'] == 11) $count_review_result_11++;
			if($person['review_result'] == 12) $count_review_result_12++;
			if($person['review_result'] == 13) $count_review_result_13++;
			if($person['contact_result'] == 2) $count_contact_result_2++;
			if($person['adoption_result'] == 1) $count_adoption_result_1++;
			if($person['adoption_result'] == 2) $count_adoption_result_2++;
			if($person['adoption_result'] == 3) $count_adoption_result_3++;
		}

		return array(
			'count_review_result_0'   => $count_review_result_0,
			'count_review_result_2'   => $count_review_result_2,
			'count_review_result_3'   => $count_review_result_3,
			'count_review_result_4'   => $count_review_result_4,
			'count_review_result_5'   => $count_review_result_5,
			'count_review_result_6'   => $count_review_result_6,
			'count_review_result_7'   => $count_review_result_7,
			'count_review_result_8'   => $count_review_result_8,
			'count_review_result_9'   => $count_review_result_9,
			'count_review_result_10'  => $count_review_result_10,
			'count_review_result_11'  => $count_review_result_11,
			'count_review_result_12'  => $count_review_result_12,
			'count_review_result_13'  => $count_review_result_13,
			'count_contact_result_2'  => $count_contact_result_2,
			'count_adoption_result_1' => $count_adoption_result_1,
			'count_adoption_result_2' => $count_adoption_result_2,
			'count_adoption_result_3' => $count_adoption_result_3,
		);
	}

	/**
	 * @param $filters
	 * @param string $type
	 */
	private function _array_person($filters, $type = 'order')
	{
		$result = array();
		if($type == 'job')
			$persons = $this->m_job->count_person_in_sssale($filters);
		elseif($type == 'person')
			$persons = $this->m_person->count_person_in_post($filters);
		else
			$persons = $this->m_order->count_person_in_ss($filters);

		foreach($persons as $person)
		{
			$result[] = $person['person_id'];
		}

		return $result;
	}

	/**
	 * create data order
	 * @param $filters
	 * @param $orders
	 * @param $all_ss
	 * @param $all_partner
	 * @param $all_group
	 * @param $all_user
	 * @param $all_sssale
	 * @param $all_post
	 * @param $all_media
	 * @return array
	 */
	private function _create_data_order($filters,$orders,$all_ss,$all_partner,$all_group,$all_user,$all_sssale,$all_post,$all_media)
	{
		$data = array();
		foreach($orders as $order)
		{
			$double = 1;
			$count_ss_list = (trim($order['ss_list'],',') != '') ? count(explode(',', trim($order['ss_list'],','))) : 0;
			$price = 0;
			$residuals = 0;
			if($order['post_id'] != '' && isset($all_post[$order['post_id']]))
			{
				if($all_media[$all_post[$order['post_id']]['m_media_id']]['is_web_reprint'] == 1)
					$double = 2;
				$post_price = $all_post[$order['post_id']]['price'] == '' ? 0 : $all_post[$order['post_id']]['price'];
				$price = (int)($post_price / ((1 + $count_ss_list) * $double));
				$residuals = $post_price % ((1 + $count_ss_list) * $double);
			}

			$arr_ss = ($count_ss_list > 0) ? array_merge(array($order['ss_id']), explode(',', trim($order['ss_list'],','))) : array($order['ss_id']);
			$arr_ss = $double == 2 ? array_merge($arr_ss,$arr_ss) : $arr_ss;
			foreach($arr_ss as $k => $v)
			{
				$filters['ss_id'] = $v;
				$list_sssale = \Model_Sssale::find_by('ss_id',$v,'=');
				$filters['sssale_id'] = array();
				if(isset($list_sssale))
				{
					foreach($list_sssale as $value)
					{
						$filters['sssale_id'][] = $value['sssale_id'];
					}
				}

				if($k > $count_ss_list)
					$filters['reprinted_via'] = 1;

				$filters['main'] = 0;
				if($v == $arr_ss[0])
					$filters['main'] = 1;

				$tmp[0] = 'オーダー';
				$tmp[1] = $order['order_id'];
				$tmp[2] = (trim($order['ss_list'],',') != '') ? count(explode(',', trim($order['ss_list'],','))) : 0;
				$tmp[3] = ($k > $count_ss_list) ? ($this->m_person->count_data(array('array_person' => $this->_array_person($filters), 'reprinted_via' => 1)) ? '○' : '') : '';
				$tmp[4] = '';
				$group_name = '';
				$branch_name = '';
				$ss_name = '';
				if(isset($all_ss[$v]))
				{
					$group_name = $all_group[$all_partner[$all_ss[$v]['partner_code']]['m_group_id']]['name'];
					$branch_name = $all_partner[$all_ss[$v]['partner_code']]['branch_name'];
					$ss_name = $all_ss[$v]['ss_name'];
				}

				$tmp[5] = $group_name;
				$tmp[6] = $branch_name;
				$tmp[7] = $ss_name;

				$department_text = '';
				$department_id = '';
				$username = '';
				if(isset($all_ss[$v]) && $all_partner[$all_ss[$v]['partner_code']]['user_id'] != '')
				{
					if(isset(\Constants::$department[$all_partner[$all_ss[$v]['partner_code']]['department_id']]))
					{
						$department_text = \Constants::$department[$all_partner[$all_ss[$v]['partner_code']]['department_id']];
						$department_id = $all_partner[$all_ss[$v]['partner_code']]['department_id'];
					}

					if(isset($all_user[$all_partner[$all_ss[$v]['partner_code']]['user_id']]))
						$username = $all_user[$all_partner[$all_ss[$v]['partner_code']]['user_id']]['name'];
				}

				$tmp[8] = $department_text;
				$tmp[9] = $department_id;
				$tmp[10] = $username;

				$tmp[11] = isset($all_user[$order['interview_user_id']]['name']) ? $all_user[$order['interview_user_id']]['name'] : '';
				$tmp[12] = $order['agreement_type'] != '' ? (isset($all_sssale[$order['agreement_type']]) ? \Constants::$sale_type[$all_sssale[$order['agreement_type']]['sale_type']] : '') : '';
				$tmp[13] = $order['apply_date'];
				$tmp[14] = $order['post_date'];

				$media_type_text = '';
				$media_budget_type_text = '';
				$media_classification_text = '';
				$is_web_reprint_text = '';
				$media_id = '';
				$media_name = '';
				$media_version_name = '';
				$post_name = '';
				$branch_name = '';
				$web_post = $k > $count_ss_list ? 'WEB転載' : '';
				if($order['post_id'] != '' && isset($all_post[$order['post_id']]))
				{
					$media_type_text = \Constants::$media_type[$all_media[$all_post[$order['post_id']]['m_media_id']]['type']];
					$media_budget_type_text = \Constants::$media_budget_type[$all_media[$all_post[$order['post_id']]['m_media_id']]['budget_type']];
					$media_classification_text = \Constants::$media_classification[$all_media[$all_post[$order['post_id']]['m_media_id']]['classification']];
					$is_web_reprint_text = \Constants::$is_web_reprint[$all_media[$all_post[$order['post_id']]['m_media_id']]['is_web_reprint']];
					$media_id = $all_post[$order['post_id']]['m_media_id'];
					$media_name = $all_media[$all_post[$order['post_id']]['m_media_id']]['media_name'].$web_post;
					$media_version_name = $all_media[$all_post[$order['post_id']]['m_media_id']]['media_version_name'];
					$post_name = $all_post[$order['post_id']]['name'];
					$branch_name = $all_partner[$all_media[$all_post[$order['post_id']]['m_media_id']]['partner_code']]['branch_name'];
				}

				$tmp[15] = $media_type_text;
				$tmp[16] = $media_budget_type_text;
				$tmp[17] = $media_classification_text;
				$tmp[18] = $is_web_reprint_text;
				$tmp[19] = $media_id;
				$tmp[20] = $media_name;
				$tmp[21] = $media_version_name;
				$tmp[22] = $post_name;
				$tmp[23] = $branch_name;

				$tmp[24] = ($k == 0) ? $price + $residuals : $price;
				$tmp[25] = $order['post_id'] != '' ? ($k == 0 && isset($all_post[$order['post_id']]) ? $all_post[$order['post_id']]['price'] : '') : '';
				$filters['person_id'] = $this->_array_person($filters);
				$tmp[26] = count($filters['person_id']);
				unset($filters['ss_id']);
				unset($filters['sssale_id']);
				$count_person = $this->_count_person($filters,$this->type[0]);
				$tmp[27] = $count_person['count_review_result_0'];
				$tmp[28] = $count_person['count_contact_result_2'];
				$tmp[29] = $count_person['count_review_result_3'];
				$tmp[30] = $count_person['count_review_result_2'];
				$tmp[31] = $count_person['count_review_result_5'];
				$tmp[32] = $count_person['count_review_result_4'];
				$tmp[33] = $count_person['count_review_result_6'];
				$tmp[34] = $count_person['count_review_result_7'];
				$tmp[35] = $count_person['count_review_result_8'];
				$tmp[36] = $count_person['count_review_result_9'];
				$tmp[37] = $count_person['count_review_result_10'];
				$tmp[38] = $count_person['count_review_result_11'];
				$tmp[39] = $count_person['count_review_result_12'];
				$tmp[40] = $count_person['count_review_result_13'];
				$tmp[41] = $count_person['count_adoption_result_1'];
				$tmp[42] = $count_person['count_adoption_result_2'];
				$tmp[43] = $count_person['count_adoption_result_3'];

				$data[] = $tmp;
			}
		}

		return $data;
	}

	/**
	 * create data job
	 * @param $filters
	 * @param $jobs
	 * @param $all_ss
	 * @param $all_partner
	 * @param $all_group
	 * @param $all_user
	 * @param $all_sssale
	 * @return array
	 */
	private function _create_data_job($filters,$jobs,$all_ss,$all_partner,$all_group,$all_user,$all_sssale)
	{
		$data = array();
		foreach($jobs as $job)
		{
			$filters['job_id'] = $job['job_id'];
			$tmp[0] = '求人情報';
			$tmp[1] = '';
			$tmp[2] = '';
			$tmp[3] = $this->m_person->count_data(array('array_person' => $this->_array_person($filters,$this->type[1]), 'reprinted_via' => 1)) ? '○' : '';
			$tmp[4] = $job['job_id'];
			$tmp[5] = $all_group[$all_partner[$all_ss[$job['ss_id']]['partner_code']]['m_group_id']]['name'];
			$tmp[6] = $all_partner[$all_ss[$job['ss_id']]['partner_code']]['branch_name'];
			$tmp[7] = $all_ss[$job['ss_id']]['ss_name'];
			$department_text = '';
			$department_id = '';
			if(isset(\Constants::$department[$all_partner[$all_ss[$job['ss_id']]['partner_code']]['department_id']]))
			{
				$department_text = \Constants::$department[$all_partner[$all_ss[$job['ss_id']]['partner_code']]['department_id']];
				$department_id = $all_partner[$all_ss[$job['ss_id']]['partner_code']]['department_id'];
			}

			$tmp[8] = $department_text;
			$tmp[9] = $department_id;
			$tmp[10] = $all_user[$all_partner[$all_ss[$job['ss_id']]['partner_code']]['user_id']]['name'];
			$tmp[11] = '';
			$tmp[12] = \Constants::$sale_type[$all_sssale[$job['sssale_id']]['sale_type']];
			$tmp[13] = '';
			$tmp[14] = '';
			$tmp[15] = '';
			$tmp[16] = '';
			$tmp[17] = '';
			$tmp[18] = '';
			$tmp[19] = '';
			$tmp[20] = '';
			$tmp[21] = '';
			$tmp[22] = '';
			$tmp[23] = '';
			$tmp[24] = '';
			$tmp[25] = '';
			$filters['person_id'] = $this->_array_person($filters,$this->type[1]);
			$tmp[26] = count($filters['person_id']);
			unset($filters['job_id']);
			$count_person = $this->_count_person($filters,$this->type[1]);
			$tmp[27] = $count_person['count_review_result_0'];
			$tmp[28] = $count_person['count_contact_result_2'];
			$tmp[29] = $count_person['count_review_result_3'];
			$tmp[30] = $count_person['count_review_result_2'];
			$tmp[31] = $count_person['count_review_result_5'];
			$tmp[32] = $count_person['count_review_result_4'];
			$tmp[33] = $count_person['count_review_result_6'];
			$tmp[34] = $count_person['count_review_result_7'];
			$tmp[35] = $count_person['count_review_result_8'];
			$tmp[36] = $count_person['count_review_result_9'];
			$tmp[37] = $count_person['count_review_result_10'];
			$tmp[38] = $count_person['count_review_result_11'];
			$tmp[39] = $count_person['count_review_result_12'];
			$tmp[40] = $count_person['count_review_result_13'];
			$tmp[41] = $count_person['count_adoption_result_1'];
			$tmp[42] = $count_person['count_adoption_result_2'];
			$tmp[43] = $count_person['count_adoption_result_3'];

			$data[] = $tmp;
		}

		return $data;
	}

	private function _create_data_person($filters,$persons,$all_ss,$all_partner,$all_group,$all_user,$all_sssale,$all_post,$all_media)
	{
		$data = array();
		foreach($persons as $person)
		{
			$filters['m_media_id'] = $person['m_media_id'];
			$tmp[0] = 'その他';
			$tmp[1] = '';
			$tmp[2] = '';
			$tmp[3] = $this->m_person->count_data(array('array_person' => $this->_array_person($filters,$this->type[2]), 'reprinted_via' => 1)) ? '○' : '';
			$tmp[4] = '';
			$tmp[5] = $all_group[$all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['m_group_id']]['name'];
			$tmp[6] = $all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['branch_name'];
			$tmp[7] = $all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['ss_name'];
			$department_text = '';
			$department_id = '';
			if(isset(\Constants::$department[$all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['department_id']]))
			{
				$department_text = \Constants::$department[$all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['department_id']];
				$department_id = $all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['department_id'];
			}

			$tmp[8] = $department_text;
			$tmp[9] = $department_id;
			$tmp[10] = $all_user[$all_partner[$all_ss[$all_sssale[$person['sssale_id']]['ss_id']]['partner_code']]['user_id']]['name'];
			$tmp[11] = '';
			$tmp[12] = '';
			$tmp[13] = '';
			$tmp[14] = '';
			$tmp[15] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? \Constants::$media_type[$all_media[$all_post[$person['post_id']]['m_media_id']]['type']] : '';
			$tmp[16] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? \Constants::$media_budget_type[$all_media[$all_post[$person['post_id']]['m_media_id']]['budget_type']] : '';
			$tmp[17] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? \Constants::$media_classification[$all_media[$all_post[$person['post_id']]['m_media_id']]['classification']] : '';
			$tmp[18] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? \Constants::$is_web_reprint[$all_media[$all_post[$person['post_id']]['m_media_id']]['is_web_reprint']] : '';
			$tmp[19] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? $all_post[$person['post_id']]['m_media_id'] : '';
			$tmp[20] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? $all_media[$all_post[$person['post_id']]['m_media_id']]['media_name'] : '';
			$tmp[21] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? $all_media[$all_post[$person['post_id']]['m_media_id']]['media_version_name'] : '';
			$tmp[22] = '';
			$tmp[23] = $person['post_id'] != '' && isset($all_post[$person['post_id']]) ? $all_partner[$all_media[$all_post[$person['post_id']]['m_media_id']]['partner_code']]['branch_name'] : '';
			$tmp[24] = '';
			$tmp[25] = '';
			$filters['person_id'] = $this->_array_person($filters,$this->type[2]);
			$tmp[26] = count($filters['person_id']);
			$count_person = $this->_count_person($filters,$this->type[2]);
			$tmp[27] = $count_person['count_review_result_0'];
			$tmp[28] = $count_person['count_contact_result_2'];
			$tmp[29] = $count_person['count_review_result_3'];
			$tmp[30] = $count_person['count_review_result_2'];
			$tmp[31] = $count_person['count_review_result_5'];
			$tmp[32] = $count_person['count_review_result_4'];
			$tmp[33] = $count_person['count_review_result_6'];
			$tmp[34] = $count_person['count_review_result_7'];
			$tmp[35] = $count_person['count_review_result_8'];
			$tmp[36] = $count_person['count_review_result_9'];
			$tmp[37] = $count_person['count_review_result_10'];
			$tmp[38] = $count_person['count_review_result_11'];
			$tmp[39] = $count_person['count_review_result_12'];
			$tmp[40] = $count_person['count_review_result_13'];
			$tmp[41] = $count_person['count_adoption_result_1'];
			$tmp[42] = $count_person['count_adoption_result_2'];
			$tmp[43] = $count_person['count_adoption_result_3'];

			$data[] = $tmp;
		}

		return $data;
	}

	public function action_index()
	{
		$filters = Input::get();
		if(isset($filters['export']) && $filters['export'])
		{
			$all_ss = $this->_get_data_ss();
			$all_sssale = $this->_get_data_sssale();
			$all_partner = $this->_get_data_partner();
			$all_group = $this->_get_data_group();
			$all_user = $this->_get_data_user();
			$all_post = $this->_get_data_post();
			$all_media = $this->_get_data_media();
			$data_export[0] = $this->field;

			$orders = $this->m_order->get_all_order_list(null,null,$filters);
			$data_export_orders = $this->_create_data_order($filters,$orders,$all_ss,$all_partner,$all_group,$all_user,$all_sssale,$all_post,$all_media);

			$jobs = $this->m_job->get_job_for_result_csv($filters);
			$data_export_jobs = $this->_create_data_job($filters,$jobs,$all_ss,$all_partner,$all_group,$all_user,$all_sssale,$all_post,$all_media);

			$persons = $this->m_person->get_person_for_result_csv($filters);
			$data_export_persons = $this->_create_data_person($filters,$persons,$all_ss,$all_partner,$all_group,$all_user,$all_sssale,$all_post,$all_media);

			$data_export = array_merge($data_export,$data_export_orders,$data_export_jobs,$data_export_persons);
			$this->_export($data_export);
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = \Fuel\Core\View::forge('result/index');
	}



	private function _export($data)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=result_'.date('Ymd').'.csv');
		$fp = fopen('php://output', 'w');
		fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		foreach($data as $k => $v)
		{
			fputcsv($fp, $v);
		}

		fclose($fp);
		exit();
	}
}