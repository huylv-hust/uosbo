<?php
/**
 * Interview class
 * @author Dang Bui
 */

class Model_Interview extends Fuel\Core\Model_Crud
{
	protected static $_table_name = 'interview';
	protected static $_primary_key = 'interview_id';

	protected static $_properties = array(
		'interview_id',
		'person',
		'interview_date',
		'emergency_contact_name',
		'relationship',
		'mobile',
		'commuting_mean_walk',
		'commuting_mean_bicycle',
		'commuting_mean_bike',
		'commuting_mean_car',
		'commuting_mean_bus',
		'commuting_mean_bus_cost',
		'commuting_mean_train',
		'commuting_mean_train_cost',
		'work_location',
		'round_trip',
		'work_location_time',
		'health_status',
		'anamnesis',
		'medical_history',
		'surgical_history',
		'working_arrangements',
		'night_shift_allowed',
		'start_time',
		'end_time',
		'weekend',
		'weekend_is',
		'weekend_start_time',
		'weekend_end_time',
		'normal_free_time',
		'holiday_free_time',
		'work_possible_week_by_day',
		'work_possible_week_by_time',
		'length_of_service',
		'employment_date',
		'applicants_media',
		'applicants_media_des',
		'experience_request',
		'request_year_before',
		'request_year',
		'request_month',
		'request_company_name',
		'normal_license',
		'special_license',
		'other',
		'other_b',
		'mechanic_qualification',
		'PC',
		'PC_other',
		'occupation',
		'occupation_other',
		'wanted_hourly_wage',
		'employment_insurance',
		'social_insurance',
		'height',
		'weight',
		'safety_boots',
		'size',
		'the_loan',
		'notes',
		'created_at',
		'updated_at',
	);

	public static function _set($data = [])
	{
		$fields = array();
		$subtract = array();
		foreach(self::$_properties as $k => $v)
		{
			$subtract[$v] = '';
		}

		foreach ($data as $k => $v)
		{
			if(in_array($k,self::$_properties))
			{
				unset($subtract[$k]);
				$fields[$k] = ($v != '') ? $v : null;
			}
		}

		foreach($subtract as $k => $v)
		{
			$fields[$k] = null;
		}

		unset($fields['created_at']);
		unset($fields['updated_at']);

		return $fields;
	}

	public function save_data($data = [],$id_interview = null)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		if(isset($id_interview))
		{
			$interview = Model_Interview::find_by_pk($id_interview);
		}
		else
		{
			$interview = new Model_Interview();
			$data['created_at'] = date('Y-m-d H:i:s');
		}

		$interview->set($data);
		if($interview->save())
			return true;
		else
			return false;
	}

	//Convert json to array
	public static function json_convert($json_string)
	{
		return json_decode(html_entity_decode($json_string),true);
	}

	//Max key in array
	public static function maxkey_array($json_string)
	{
		return max(array_keys(self::json_convert($json_string)));
	}
}
