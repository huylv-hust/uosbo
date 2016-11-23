<?php

/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * Copyright: SETA- Asia
 * File Class/Controler/Model
**/

class Model_Sssale extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'sssale';
	protected static $_primary_key = 'sssale_id';
	protected static $_properties = array(
		'sssale_id',
		'sale_type',
		'sale_name',
		'free_hourly_wage',
		'free_recruit_attr',
		'free_start_time',
		'free_end_time',
		'constraint_hourly_wage',
		'constraint_recruit_attr',
		'constraint_start_time',
		'constraint_end_time',
		'minor_hourly_wage',
		'minor_recruit_attr',
		'minor_start_time',
		'minor_end_time',
		'night_hourly_wage',
		'night_recruit_attr',
		'night_start_time',
		'night_end_time',
		'apply_start_date',
		'apply_end_date',
		'created_at',
		'updated_at',
		'ss_id',
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

	public function get_sssale_info($sssale_id)
	{
		$query = DB::select('*')
				->from(self::$_table_name)
				->where('sssale_id', $sssale_id)
				->execute()
				->as_array();
		if($query)
		{
			return $query[0];
		}

		return array();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete sssale by ss_id
	 * @param $ss_id
	 * @return mixed
	 */
	public function delete_by_ss($ss_id)
	{
		$delete = DB::query('DELETE FROM sssale WHERE ss_id = :ss_id')->bind('ss_id', $ss_id)->execute();
		return $delete;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update sssale
	 * @param array $data
	 * @return array
	 */
	public function set_data($data = array())
	{
		$fields = array();
		foreach($data as $k => $v)
		{
			if(in_array($k, self::$_properties))
			{
				$fields[$k] = trim($v) != '' ? trim($v) : null;
			}
		}

		$fields['free_start_time'] = ( ! $data['free_start_time_hour'] && ! $data['free_start_time_minute']) ? '' : $data['free_start_time_hour'].':'.$data['free_start_time_minute'];
		$fields['free_end_time'] = ( ! $data['free_end_time_hour'] && ! $data['free_end_time_minute']) ? '' : $data['free_end_time_hour'].':'.$data['free_end_time_minute'];

		$fields['constraint_start_time'] = ( ! $data['constraint_start_time_hour'] && ! $data['constraint_start_time_minute']) ? '' : $data['constraint_start_time_hour'].':'.$data['constraint_start_time_minute'];
		$fields['constraint_end_time'] = ( ! $data['constraint_end_time_hour'] && ! $data['constraint_end_time_minute']) ? '' : $data['constraint_end_time_hour'].':'.$data['constraint_end_time_minute'];

		$fields['minor_start_time'] = ( ! $data['minor_start_time_hour'] && ! $data['minor_start_time_minute']) ? '' : $data['minor_start_time_hour'].':'.$data['minor_start_time_minute'];
		$fields['minor_end_time'] = ( ! $data['minor_end_time_hour'] && ! $data['minor_end_time_minute']) ? '' : $data['minor_end_time_hour'].':'.$data['minor_end_time_minute'];

		$fields['night_start_time'] = ( ! $data['night_start_time_hour'] && ! $data['night_start_time_minute']) ? '' : $data['night_start_time_hour'].':'.$data['night_start_time_minute'];
		$fields['night_end_time'] = ( ! $data['night_end_time_hour'] && ! $data['night_end_time_minute']) ? '' : $data['night_end_time_hour'].':'.$data['night_end_time_minute'];
		return $fields;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * check all fields are ''/null
	 * @param $fields
	 * @return bool
	 */
	public function check_data_null($fields)
	{
		if(isset($fields['sssale_id'])) unset($fields['sssale_id']);
		if(isset($fields['ss_id'])) unset($fields['ss_id']);
		return strlen(implode($fields)) == '' ? false : true;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * create/update sssale
	 * @param array $data
	 * @return bool
	 * @throws Exception
	 */
	public function save_data($data = array())
	{
		if(empty($data))
			return false;

		$data['updated_at'] = date('Y-m-d H:i:s', time());
		if( ! isset($data['sssale_id']))
		{
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$sssale = Model_Sssale::forge();
		}
		else
		{
			$sssale = Model_Sssale::find_by_pk($data['sssale_id']);
		}

		if( ! isset($sssale))
			return false;

		$sssale->set($data);
		if($sssale->save())
			return true;

		return false;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get sssale current time
	 * @param $ss_id
	 * @return mixed
	 */
	public function get_data($ss_id)
	{
		$query = DB::query('SELECT * FROM `sssale` WHERE ss_id = :ss_id')->bind('ss_id',$ss_id);
		return $query->as_object()->execute();
	}

	 /*@buicongdang code presenter*/
	public function get_sssale_ss($ss_id)
	{
	    $query = DB::query('SELECT * FROM sssale WHERE ss_id = :ss_id')->bind('ss_id',$ss_id);
	    return $query->execute()->as_array();
	}

	public function get_all_sssale()
	{
	    $query = DB::query('SELECT sssale_id,sale_name FROM sssale');
	    return $query->execute()->as_array();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete sssale
	 * @return bool|mixed
	 */
	public function delete_data()
	{
		try
		{
			return self::delete();
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param $where
	 * @return object
	 */
	public function get_list_sssale($where)
	{

		$sql = 'SELECT * FROM sssale WHERE '.$where;

		if($where == '')
			$sql = 'SELECT * FROM sssale';

		return Fuel\Core\DB::query($sql)->execute();
	}
}