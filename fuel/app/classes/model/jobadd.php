<?php
/**
 * job class
 * @author NamDD <namdd@seta-asia.com.vn>
 * @date 03/09/2015
 */

class Model_Jobadd extends Fuel\Core\Model_Crud
{
	protected static $_table_name = 'job_add';
	protected static $_primary_key = 'job_add_id';
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
	protected $_data_default;
	public  function __construct()
	{
		$this->_data_default = Utility::get_default_data(self::$_table_name);
	}
	/**
	 * insert data
	 * @param array $data
	 * @return type
	 */
	public function insert_data($data,$job_obj)
	{
		if( ! count($data))
			return array();

		if( ! isset($data['job_id']))
			return array();

		$job_data = $job_obj->get_info_data($data['job_id']);
		if($job_data['job_id'] != $data['job_id'])
			return array();

		foreach ($data as $key => $val)
		{
			if ( ! key_exists($key, $this->_data_default))
			{
				unset($data[$key]);
			}
		}

		$data['created_at'] = date('Y-m-d H:i');
		$data['updated_at'] = date('Y-m-d H:i');
		$obj = static::forge();
		$obj->set($data);
		return $obj->save();
	}
	/**
	 *
	 * @param type $data
	 * @return type
	 */
	public function insert_multi_data($data,$job_obj)
	{
		$res_data = array();
		$check = true;
		foreach($data as $row)
		{
			if($row['sub_title'] == '' && $row['text'] == '')
				continue;

			$res = $this->insert_data($row,$job_obj);
			if($res != null)
			{
				$res_data[] = $res;
			}
			else
			{
				$check = false;
				break;
			}
		}

		return $check;
	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param type $id
	 * @return boolean
	 */
	public function delete_data($job_id)
	{
		$job_id = (int)$job_id;
		return \Fuel\Core\DB::query('DELETE FROM '.self::$_table_name.' WHERE job_id = '.$job_id)->execute();
	}
	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param type $config is format config['where][] = array('name_filed','oper','values')
	 * @return  array
	 */
	public function get_list_data($config)
	{
		$obj = static::forge()->find($config);
		if(count($obj))
		{
			return $obj;
		}

		return array();
	}
	public function get_info_data($id)
	{
		$obj = static::forge()->find_by_pk($id);
		if($obj !== null)
		{
			return $obj->_data;
		}

		return $this->_data_default;
	}

}
