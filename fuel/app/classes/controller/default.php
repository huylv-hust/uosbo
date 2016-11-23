<?php

/**
 * Default class
 *
 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
 * @date 03/09/2015
 */

class Controller_Default extends \Controller_Uosbo
{
	/*
	 * Index action
	 *
	 * @since 07/05/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function action_index()
	{
		$data = array();
		$model_par = new \Model_Mpartner();
		$model_ss = new \Model_Mss();
		$model_job = new \Model_Job();
		$model_or = new \Model_Orders();
		$m_user = new Model_Muser();
		$m_person = new Model_Person();

		$user_info = \Fuel\Core\Session::get('login_info');
		$division = $user_info['division_type'];
		$department_id = $user_info['department_id'];
		$this->template->title = 'UOS求人システム';
		if($division == 4)
		{
			$this->template->content = View::forge('default/division4');
		}

		elseif($division == 1)
		{
			$data['m_partner'] = $model_par->count_data(array('status' => 1 ));
			$data['m_ss'] = $model_ss->count_data(array('status' => '0' ));
			$data['job'] = $model_job->count_data();
			$data['or'] = count($model_or->get_all_order_list(null, null, array('unapproved' => '0')));
			$data['person_inactive'] = $m_person->count_data(array('status' => '0'));
			$this->template->content = View::forge('default/top',$data);
		}

		elseif($division == 2)
		{
			$data['count_partner'] = $model_par->count_data(array('department_id' => $department_id, 'status' => '1'));
			$data['count_ss'] = $model_ss->count_data(array('department_id' => $department_id, 'status' => '0'));
			$data['count_job'] = $model_job->count_job_department_id(array('department_id' => $department_id, 'status' => '0'));
			$data['count_order'] = count($model_or->get_all_order_list(null, null, array('department_id' => $department_id, 'unapproved' => '0')));
			$data['list_user'] = $m_user->get_data(array('department_id' => $department_id, 'order_by_time' => 1));
			$data['person_inactive'] = $m_person->count_data(array('status' => '0', 'department' => $department_id, 'user_id' => ''));

			$data['link_partner'] = \Fuel\Core\Uri::base().'master/partners?department_id='.$department_id.'&status=1';
			$data['link_ss'] = \Fuel\Core\Uri::base().'master/sslist?department_id='.$department_id.'&status=0';
			$data['link_job'] = \Fuel\Core\Uri::base().'job/jobs?department_id='.$department_id.'&status=0';
			$data['link_order'] = \Fuel\Core\Uri::base().'job/orders?department_id='.$department_id.'&unapproved=0&flag=1';
			$data['link_person'] = \Fuel\Core\Uri::base().'job/persons?department='.$department_id.'&user_id=&status=0';
			$array_user = array();
			foreach($data['list_user'] as $user)
			{
				$array_user[] = $user->user_id;
			}

			$list_person = $m_person->get_person_division_2($array_user);

			foreach($list_person as $person)
			{
				foreach($array_user as $k => $v)
				{
					if($person['interview_user_id'] == $v || $person['agreement_user_id'] == $v || $person['training_user_id'] == $v || $person['partner_user_id'] == $v)
					{
						if($person['contact_result'] == 0)
							$data['count'][$v]['contact_result'] = isset($data['count'][$v]['contact_result']) ? $data['count'][$v]['contact_result'] + 1 : 1;
						if($person['review_date'] == '')
							$data['count'][$v]['review_date'] = isset($data['count'][$v]['review_date']) ? $data['count'][$v]['review_date'] + 1 : 1;
						if($person['review_result'] == 0)
							$data['count'][$v]['review_result'] = isset($data['count'][$v]['review_result']) ? $data['count'][$v]['review_result'] + 1 : 1;
						if($person['adoption_result'] == 0)
							$data['count'][$v]['adoption_result'] = isset($data['count'][$v]['adoption_result']) ? $data['count'][$v]['adoption_result'] + 1 : 1;
						if($person['contract_date'] == '')
							$data['count'][$v]['contract_date'] = isset($data['count'][$v]['contract_date']) ? $data['count'][$v]['contract_date'] + 1 : 1;
						if($person['contract_result'] == 0)
							$data['count'][$v]['contract_result'] = isset($data['count'][$v]['contract_result']) ? $data['count'][$v]['contract_result'] + 1 : 1;
						if($person['hire_date'] == '')
							$data['count'][$v]['hire_date'] = isset($data['count'][$v]['hire_date']) ? $data['count'][$v]['hire_date'] + 1 : 1;
						if($person['employee_code'] == '')
							$data['count'][$v]['employee_code'] = isset($data['count'][$v]['employee_code']) ? $data['count'][$v]['employee_code'] + 1 : 1;
						if($person['work_confirmation'] == 0)
							$data['count'][$v]['work_confirmation'] = isset($data['count'][$v]['work_confirmation']) ? $data['count'][$v]['work_confirmation'] + 1 : 1;
					}
				}
			}

			$data['pagination'] = \Uospagination::forge('pagination', array(
				'pagination_url' => Uri::base().'?division=2',
				'total_items'    => count($data['list_user']),
				'per_page'       => \Constants::$default_limit_pagination,
				'num_links'      => \Constants::$default_num_links,
				'uri_segment'    => 'page',
				'show_last'      => true,
			));

			$this->template->content = View::forge('default/division2', $data);
		}

		elseif($division == 3)
		{
			$this->division3();
		}

		else
		{
			$this->template->content = View::forge('default/top',$data);
		}
	}

	public function	division3()
	{
		$division_obj = new Model_Udivision();
		$data = $division_obj->get_division_3();
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('default/division3', $data);
	}

	public function action_access_denied()
	{
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('default/access_denied');
	}
}
