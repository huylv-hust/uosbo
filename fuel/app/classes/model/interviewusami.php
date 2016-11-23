<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Mss
 * @package Model
 */
class Model_Interviewusami extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'interviewusami';
	protected static $_primary_key = 'id';
	protected static $_properties = array(
		'id',
		'interview_day',
		'parental_authority',
		'commuting_means',
		'commuting_means_bus',
		'commuting_means_train',
		'ss_match',
		'ss_match_other',
		'work_location_hope1',
		'work_location_hope1_time',
		'work_location_hope2',
		'work_location_hope2_time',
		'work_location_remarks',
		'working_arrangements1',
		'working_arrangements1_start_time',
		'working_arrangements1_end_time',
		'working_arrangements2',
		'working_arrangements2_start_time',
		'working_arrangements2_end_time',
		'working_arrangements3',
		'working_arrangements3_start_time',
		'working_arrangements3_end_time',
		'working_arrangements4',
		'working_arrangements4_start_time',
		'working_arrangements4_end_time',
		'working_arrangements5',
		'working_arrangements5_start_time',
		'working_arrangements5_end_time',
		'working_arrangements6',
		'working_arrangements6_start_time',
		'working_arrangements6_end_time',
		'working_arrangements7',
		'working_arrangements7_start_time',
		'working_arrangements7_end_time',
		'working_arrangements1_check',
		'working_arrangements2_check',
		'working_arrangements3_check',
		'working_arrangements4_check',
		'working_arrangements5_check',
		'working_arrangements6_check',
		'working_arrangements7_check',
		'work_day_week_min',
		'work_day_week_max',
		'work_day_month_min',
		'work_day_month_max',
		'work_holiday',
		'month_wage',
		'month_wage_other',
		'time_of_service',
		'employment_month',
		'employment_day',
		'employment_possible',
		'media_app',
		'media_app_other',
		'experience',
		'experience_year_position_before',
		'experience_year',
		'experience_month',
		'experience_other',
		'driver_license',
		'qualification',
		'qualification_b',
		'qualification_mechanic',
		'pc_skills',
		'pc_skin_other',
		'occupation',
		'occupation_company_name',
		'occupation_student_year',
		'occupation_student_grade',
		'health_status',
		'anamnesis',
		'disease_name',
		'insurance_employment',
		'insurance_social',
		'partner',
		'partner_dependents_person',
		'uniform_rental_h',
		'uniform_rental_shoe_size',
		'uniform_rental_up',
		'uniform_rental_under',
		'salary_hour_wage',
		'salary_role_wage',
		'salary_evaluation_wage',
		'salary_special_wage',
		'adoption_rank',
		'adoption_person_des',
		'adoption_person_type',
		'uos_person',
		'confirmation_shop_name',
		'confirmation_shop_date',
		'working_arrangements_shift_free',
		'location_ss',
		'work_starttime',
		'income_tax',
		'withholding',
		'withholding_slip',
		'part_type',
		'commute_dis',
		'created_at',
		'updated_at',
		'person_id',
		'driver_license_date1',
		'driver_license_date2',
		'driver_license_date3',
		'driver_license_date4',
		'driver_license_date5',
		'driver_license_date6',
		'driver_license_date7',
		'qualification_date1',
		'qualification_date2',
		'qualification_date3',
		'qualification_date4',
		'qualification_mechanic_date1',
		'qualification_mechanic_date2',
		'qualification_mechanic_date3',
		'qualification_mechanic_date4',
		'qualification_mechanic_date5',
		'qualification_mechanic_date6',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => true,
			'property'        => 'created_at',
			'overwrite'       => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events'          => array('after_update'),
			'mysql_timestamp' => true,
			'property'        => 'updated_at',
			'overwrite'       => true,
		),
	);

	private $fields;


	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update
	 * @param array $data
	 * @return array
	 */
	public function set_data($data = array())
	{
		//$data['emergency_contact_zipcode'] = $data['zipcode_1'].$data['zipcode_2'];
		for($i = 1; $i < 8; $i++)
		{
			if(isset($data['working_arrangements'.$i.'_check']) || isset($data['working_arrangements_shift_free'])) // check
			{
				$data['start_hour'.$i] = '00';
				$data['start_minute'.$i] = '00';
				$data['end_hour'.$i] = '00';
				$data['end_minute'.$i] = '00';
				$data['working_arrangements'.$i.'_start_time'] = '';
				$data['working_arrangements'.$i.'_end_time'] = '';
				$data['working_arrangements'.$i] = '';
				if(isset($data['working_arrangements_shift_free']))
				{
					$data['working_arrangements'.$i.'_check'] = '';
				}
				else
				{
					$data['working_arrangements'.$i.'_check'] = 1;
				}
			}
			else
			{
				$data['start_hour'.$i] = isset($data['start_hour'.$i]) ? (strlen($data['start_hour'.$i]) == 1 ? '0'.$data['start_hour'.$i] : $data['start_hour'.$i]) : '';
				$data['start_minute'.$i] = isset($data['start_minute'.$i]) ? (strlen($data['start_minute'.$i]) == 1 ? '0'.$data['start_minute'.$i] : $data['start_minute'.$i]) : '';
				$data['end_hour'.$i] = isset($data['end_hour'.$i]) ? (strlen($data['end_hour'.$i]) == 1 ? '0'.$data['end_hour'.$i] : $data['end_hour'.$i]) : '';
				$data['end_minute'.$i] = isset($data['end_minute'.$i]) ? (strlen($data['end_minute'.$i]) == 1 ? '0'.$data['end_minute'.$i] : $data['end_minute'.$i]) : '';
				$data['working_arrangements'.$i.'_start_time'] = $data['start_hour'.$i].':'.$data['start_minute'.$i];
				$data['working_arrangements'.$i.'_end_time'] = $data['end_hour'.$i].':'.$data['end_minute'.$i];
				$data['working_arrangements'.$i.'_check'] = '';
			}
		}

		if( ! isset($data['working_arrangements_shift_free'])) $data['working_arrangements_shift_free'] = '';
		if($data['work_starttime_date'] == '')
		{
				$data['work_starttime'] = '';
		}
		else
		{
			$data['work_starttime_hour'] = $data['work_starttime_hour'] == '' ? '00' : (strlen($data['work_starttime_hour']) == 1 ? '0'.$data['work_starttime_hour'] : $data['work_starttime_hour']);
			$data['work_starttime_minute'] = $data['work_starttime_minute'] == '' ? '00' : (strlen($data['work_starttime_minute']) == 1 ? '0'.$data['work_starttime_minute'] : $data['work_starttime_minute']);
			$data['work_starttime'] = $data['work_starttime_date'].' '.$data['work_starttime_hour'].':'.$data['work_starttime_minute'].':00';
		}

		if(isset($data['commuting_means']))
		{
			$tmp = ',';
			foreach($data['commuting_means'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['commuting_means'] = trim($tmp, ',') == '' ? '' : $tmp;
		}

		if(isset($data['ss_match']))
		{
			$tmp = ',';
			foreach($data['ss_match'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['ss_match'] = trim($tmp, ',') == '' ? '' : $tmp;
		}

		$data['employment_possible'] = isset($data['employment_possible']) ? $data['employment_possible'] : '';
		if(isset($data['driver_license']))
		{
			$tmp = ',';
			foreach($data['driver_license'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['driver_license'] = trim($tmp, ',') == '' ? '' : $tmp;
		}

		if(isset($data['qualification']))
		{
			$tmp = ',';
			foreach($data['qualification'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['qualification'] = trim($tmp, ',') == '' ? '' : $tmp;
		}

		if(isset($data['qualification_mechanic']))
		{
			$tmp = ',';
			foreach($data['qualification_mechanic'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['qualification_mechanic'] = trim($tmp, ',') == '' ? '' : $tmp;
		}

		if(isset($data['pc_skills']))
		{
			$tmp = ',';
			foreach($data['pc_skills'] as $k => $v)
			{
				$tmp .= $v.',';
			}

			$data['pc_skills'] = trim($tmp, ',') == '' ? : $tmp;
		}

		//default data checkbox
		$data['commuting_means'] = isset($data['commuting_means']) ? $data['commuting_means'] : '';
		$data['ss_match'] = isset($data['ss_match']) ? $data['ss_match'] : '';
		$data['employment_possible'] = isset($data['employment_possible']) ? $data['employment_possible'] : '';
		$data['driver_license'] = isset($data['driver_license']) ? $data['driver_license'] : '';
		$data['qualification'] = isset($data['qualification']) ? $data['qualification'] : '';
		$data['qualification_mechanic'] = isset($data['qualification_mechanic']) ? $data['qualification_mechanic'] : '';
		$data['pc_skill'] = isset($data['pc_skill']) ? $data['pc_skill'] : '';
		$data['withholding'] = isset($data['withholding']) ? $data['withholding'] : '';

		foreach($data as $k => $v)
		{
			$data[$k] = trim($v) != '' ? trim($v) : null;
		}

		$this->fields = $data;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>+
	 * @return bool
	 * @throws Exception
	 */
	public function save_data()
	{
		$data = $this->fields;
		if(empty($data))
			return false;

		$data['updated_at'] = date('Y-m-d H:i:s', time());
		if( ! isset($data['id']))
		{
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$inteview_usami = static::forge();
		}
		else
		{
			$inteview_usami = static::find_by_pk($data['id']);
			if( ! isset($inteview_usami))
				return false;

			$inteview_usami->is_new(false);
		}

		$inteview_usami->set($data);
		if($inteview_usami->save())
			return true;

		return false;
	}
	public function get_data($person_id)
	{
		$select = DB::select('*')->from(self::$_table_name)->where('person_id','=',$person_id);
		return $select->execute()->as_array();
	}
}