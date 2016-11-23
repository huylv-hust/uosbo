<?php

class Model_Udivision
{
	public function get_division_3()
	{
		$data = array(
			'sssale_list'     => array(),
			'person_list'     => array(),
			'employment_list' => array(),
		);
		$user_info = \Fuel\Core\Session::get('login_info');
		$order_obj = new Model_Orders();
		$partner_obj = new Model_Mpartner();
		$mss_obj = new Model_Mss();
		$person_obj = new Model_Person();
		$employment_obj = new Model_Employment();
		$sssale_obj = new Model_Sssale();

		$list_person_id = array();
		$list_sssale_id = array();
		$order_list = $order_obj->get_list_oders_login($user_info['user_id']);
		/*where 1*/
		if(count($order_list))
		{
			foreach($order_list as $row)
			{
				$list_person_id[] = $row['person_id'];
			}
		}
		/*where 2*/
		$list_partner_code = array();
		$list_ss_id = array();
		$partner_list = $partner_obj->get_list_partner_login($user_info['user_id']);

		if(count($partner_list))
		{
			foreach($partner_list as $row)
			{
				$list_partner_code[] = $row['partner_code'];
			}
		}

		if(count($list_partner_code))
		{
			$mss_list = $mss_obj->get_all_ss_by_list_partner_code($list_partner_code);
			$mss_list_id = '';
			$sssale_array = array();
			if(count($mss_list))
			{
				foreach($mss_list as $row)
				{
					$mss_list_id .= $row['ss_id'].',';
					$ss_array_list[$row['ss_id']] = $row['ss_name'];
				}


				$sssale_list = $sssale_obj->get_list_sssale('ss_id IN ('.trim($mss_list_id,',').')');
				foreach($sssale_list as $row)
				{
					$list_sssale_id[] = $row['sssale_id'];
				}
			}
		}

		$person_list = $person_obj->get_person_division_3($list_sssale_id, $list_person_id);

		$list_person_id = array();

		if(count($person_list))
		{
			$list_sssale_id = array();
			foreach($person_list as $row)
			{
				$list_person_id[] = $row['person_id'];
				$list_sssale_id[] = (int)$row['sssale_id'];
			}


			$list_employment = $employment_obj->get_list_data($list_person_id);
			$list_sssale_of_person = $sssale_obj->get_list_sssale('sssale_id IN ('.implode(',',$list_sssale_id).')');
			$list_employment_array = array();
			$list_sssale = array();
			foreach($list_employment as $row)
			{
				$list_employment_array[$row['person_id']] = $row;
			}

			$list_ss_id = array();
			$list_sssale_of_ss = array();
			foreach($list_sssale_of_person as $row)
			{
				$list_ss_id[] = (int)$row['ss_id'];
				$list_sssale_of_ss[$row['sssale_id']] = (int)$row['ss_id'];

			}

			$list_ss_of_person = $mss_obj->get_list_ss('ss_id IN ('.implode(',',$list_ss_id).')');
			$list_ss_name = array();
			foreach($list_ss_of_person as $row)
			{
				$list_ss_name[$row['ss_id']] = $row['ss_name'];
			}

			$list_person_ss_name = array();
			foreach($list_sssale_of_ss as $sssale_id => $ss_id)
			{
				$list_person_ss_name[$sssale_id] = $list_ss_name[$ss_id];
			}


			$data['person_list'] = $person_list;
			$data['sssale_list'] = $list_person_ss_name;
			$data['employment_list'] = $list_employment_array;
		}

		return $data;
	}
}
