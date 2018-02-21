<?php
/**
 * @author Bui Cong Dang
 */
namespace job;
use Fuel\Core\Input;
use Fuel\Core\Model;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;

class Controller_Interview extends \Controller_Uosbo
{
	private function convertarraytostring($array)
	{
		return implode(',',array_values($array));
	}
	private function merge_hh_mm($hh = null,$mm = null)
	{
		if($hh != '' and $mm != '')
			return $hh.':'.$mm;
		if($hh != '')
			return $hh.':00';
		if($mm != '')
			return '00:'.$mm;
		if($hh == '' and $mm == '')
			return '';
	}
	private function remove_value_empty($array,$values_unset = null)
	{
		foreach($array as $k => $v)
		{
			if (isset($values_unset))
			{
				$check_null = true;
				foreach ($values_unset as $k1 => $v1)
				{
					if($array[$k][$v1] != '')
					{
						$check_null = false;
						break;
					}
				}

				if($check_null)
				unset($array[$k]);
			}
			else
			{
				if($v == '')
				{
					unset($array[$k]);
				}
			}
		}

		return $array;
	}

	/**
	 *
	 * @return boolean is true str1!=str2
	 */
	public function action_index()
	{
		$data_interview = array();
		if ( ! $person_id = Input::get('person_id') or ! \Model_Person::find($person_id))
		{
			Response::redirect(Uri::base().'job/persons');
		}

		if ($data = Input::post())
		{
			if (isset($data['anamnesis']))
				$data['anamnesis'] = json_encode($this->remove_value_empty($data['anamnesis']));

			if (isset($data['medical_history']))
				$data['medical_history'] = json_encode($this->remove_value_empty($data['medical_history'],array('name','year')));

			if (isset($data['surgical_history']))
				$data['surgical_history'] = json_encode($this->remove_value_empty($data['surgical_history'],array('name','year')));

			if (isset($data['working_arrangements']))
				$data['working_arrangements'] = $this->convertarraytostring($data['working_arrangements']);

			if (isset($data['weekend']))
				$data['weekend'] = $this->convertarraytostring($data['weekend']);

			if (isset($data['special_license']))
				$data['special_license'] = $this->convertarraytostring($data['special_license']);

			if (isset($data['other']))
				$data['other'] = $this->convertarraytostring($data['other']);

			if (isset($data['mechanic_qualification']))
				$data['mechanic_qualification'] = $this->convertarraytostring($data['mechanic_qualification']);

			if (isset($data['PC']))
				$data['PC'] = $this->convertarraytostring($data['PC']);

			if (isset($data['start_time_hh']) or isset($data['start_time_mm']))
				$data['start_time'] = $this->merge_hh_mm($data['start_time_hh'], $data['start_time_mm']);

			if (isset($data['end_time_hh']) or isset($data['end_time_mm']))
				$data['end_time'] = $this->merge_hh_mm($data['end_time_hh'], $data['end_time_mm']);

			if (isset($data['weekend_start_time_hh']) or isset($data['weekend_start_time_mm']))
				$data['weekend_start_time'] = $this->merge_hh_mm($data['weekend_start_time_hh'], $data['weekend_start_time_mm']);

			if (isset($data['weekend_end_time_hh']) or isset($data['weekend_end_time_mm']))
				$data['weekend_end_time'] = $this->merge_hh_mm($data['weekend_end_time_hh'], $data['weekend_end_time_mm']);

			$data['person'] = $person_id;

			$data = \Model_Interview::_set($data);

			$interview_id = null;
			if(isset($data['interview_id']) and $data['interview_id'] != '')
			{
				$interview_id = $data['interview_id'];
				unset($data['interview_id']);
			}

			$interview = new \Model_Interview();
			if ($interview->save_data($data,$interview_id))
			{
				Session::set_flash('success', \Constants::$message_create_success);
			}
			else
			{
				Session::set_flash('error', \Constants::$message_create_error);
			}
		}

		if ($interview_data = \Model_Interview::find_one_by('person',$person_id))
		{
			$data_interview['interviews'] = $interview_data;
		}


		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('interview/index',$data_interview);
	}

}

