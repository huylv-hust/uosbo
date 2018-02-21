<?php
/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * Copyright: SETA- Asia
 * File Class/Controler/Model
 **/
class Model_Plan extends Orm\Model
{
	protected static $_table_name = 'plan';
	protected static $_primary_key = array(
		'area_id',
		'start_date',
	);
	protected static $_properties = array(
		'start_date',
		'area_id',
		'job_cost',
		'expenses',
		'created_at',
		'updated_at',
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

	public function current_year()
	{
		$year = date('Y');
		$month = date('m');
		if($month < \Constants::$plan_between_date['month'])
			$current_year = $year - 1;
		return $current_year;
	}
	/**
	 * @author dangbc <dangbc6591@seta-asia.com.vn>
	 * get data plan
	 */
	public function data_plan($current_date)
	{
		$data_plan['have_data'] = false;
		$current_year = $current_date;
		$data = \Fuel\Core\DB::select('*')->from('plan')->where('start_date','=',$current_year)->execute()->as_array();
		if( ! empty($data))
			$data_plan['have_data'] = true;

		$data_plan['data_plan'] = $data;
		return $data_plan;
	}
	/**
	 * @author dangbc <dangbc6591@seta-asia.com.vn>
	 * save data plan
	 */
	public function save_plan($current_date, $data_post = array())
	{
		try{
				\Fuel\Core\DB::start_transaction();
				$delete = \Fuel\Core\DB::query('DELETE FROM plan where start_date = :start_date')->bind('start_date', $current_date)->execute();
				$plan = \Fuel\Core\DB::insert(self::$_table_name)
					->columns(array('start_date', 'area_id', 'job_cost', 'expenses', 'created_at', 'updated_at'));
				foreach($data_post['area_id'] as $k => $v)
				{
					$plan->values(array($current_date, $k, ($data_post['job_cost'][$k] == '') ? 0 : $data_post['job_cost'][$k], ($data_post['expenses'][$k] == '') ? 0 : $data_post['expenses'][$k], date('Y-m-d h:s'), date('Y-m-d h:s')));
				}

				if( ! $plan->execute())
				{
					\Fuel\Core\DB::rollback_transaction();
					return false;
				}

				\Fuel\Core\DB::commit_transaction();
				return true;
		}catch (Exception $ex){
			\Fuel\Core\DB::rollback_transaction();
			return false;
		}
	}

	/*
	 * Get info by start_date
	 *
	 * @since 21/10/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function get_info_by_startdate($start_date, $area_id)
	{
		$start_month = date('m', strtotime($start_date));
		$start_year  = date('Y', strtotime($start_date));

		$last_year = $start_year - 1;
		$next_year = $start_year + 1;

		$startdate = $start_year.'-10-01';
		if($start_month < 10)
		{
			$startdate = $last_year.'-10-01';
		}

		$query = DB::select('*')
				->from(self::$_table_name)
				->where('area_id', $area_id)
				->where(DB::expr("date_format(start_date, '%Y-%m-%d')"), '=', sprintf('%04d-%02d-%02d', date('Y', strtotime($startdate)), date('m', strtotime($startdate)), date('d', strtotime($startdate))))
				->execute()
				->as_array();
		if($query)
		{
			return $query[0]['job_cost'];
		}

		return 0;
	}
}
