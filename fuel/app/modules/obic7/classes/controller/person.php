<?php

namespace Obic7;


use Fuel\Core\Input;
use Fuel\Core\View;

class Controller_Person extends \Controller_Uosbo
{
	public function action_index()
	{
		if (Input::get('person_id'))
		{
			$data = array();

			$person = new \Model_Person();
			$sssale = new \Model_Sssale();
			$ss = new \Model_Mss();
			$partner = new \Model_Mpartner();
			$group = new \Model_Mgroups();
			$user = new \Model_Muser();
			$employment = new \Model_Employment();

			$info =  $person->find(Input::get('person_id'));
			if(isset($info))
			{
				$data['info'] = $info->to_array();
				$data['info']['obic7_date'] = '';
				if ($employment->find(Input::get('person_id')))
				{
					$data['info']['obic7_date'] = $employment->find(Input::get('person_id'))->obic7_date;
				}

				$ss_code = $sssale->find_by_pk($data['info']['sssale_id'])->ss_id;
				$data['info']['ss_name'] = $ss->find_by_pk($ss_code)->ss_name;
				$partner_code = $ss->find_by_pk($ss_code)->partner_code;
				$data['info']['branch_name'] = $partner->find_by_pk($partner_code)->branch_name;
				$group_id = $partner->find_by_pk($partner_code)->m_group_id;
				$data['info']['group_name'] = $group->find_by_pk($group_id)->name;

				$data['info']['business_user'] = '';
				$data['info']['business_department'] = '';
				$data['info']['interview_user'] = '';
				$data['info']['interview_department'] = '';
				$data['info']['agreement_user'] = '';
				$data['info']['agreement_department'] = '';
				$data['info']['training_user'] = '';
				$data['info']['training_department'] = '';

				if ($data['info']['business_user_id'])
				{
					$data['info']['business_user'] = $user->find_by_pk($data['info']['business_user_id'])->name;
					$data['info']['business_department'] = $user->find_by_pk($data['info']['business_user_id'])->department_id;
				}

				if ($data['info']['interview_user_id'])
				{
					$data['info']['interview_user'] = $user->find_by_pk($data['info']['interview_user_id'])->name;
					$data['info']['interview_department'] = $user->find_by_pk($data['info']['interview_user_id'])->department_id;
				}

				if ($data['info']['agreement_user_id'])
				{
					$data['info']['agreement_user'] = $user->find_by_pk($data['info']['agreement_user_id'])->name;
					$data['info']['agreement_department'] = $user->find_by_pk($data['info']['agreement_user_id'])->department_id;
				}

				if ($data['info']['training_user_id'])
				{
					$data['info']['training_user'] = $user->find_by_pk($data['info']['training_user_id'])->name;
					$data['info']['training_department'] = $user->find_by_pk($data['info']['training_user_id'])->department_id;
				}

				$this->template->title = 'UOS求人システム';
				$this->template->content = View::forge('person', $data);
			}
			else
			{
				\Fuel\Core\Response::redirect (\Fuel\Core\Uri::base ().'obic7/persons');
			}
		}
	}
}