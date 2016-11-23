<?php
/**
 * job class
 * @author NamDD <namdd@seta-asia.com.vn>
 * @date 01/09/2015
 */

class Model_Mimage extends Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_image';
	protected static $_primary_key = 'm_image_id';
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
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param type $data
	 * @param type $id
	 * @return id insert
	 */
	/**
	 * insert data
	 * @param array $data
	 * @return type
	 */
	public function insert_data($data)
	{
		$data['update_at'] = date('Y-m-d H:i');
		$data['create_at'] = date('Y-m-d H:i');
		if( ! count($data))
			return array();

		foreach ($data as $key => $val)
		{
			if ( ! key_exists($key, $this->_data_default))
			{
				unset($data[$key]);
			}
		}

		Fuel\Core\DB::query('LOCK TABLES '.self::$_table_name.' READ');
		try
		{
			$check_exits = static::forge()->find_by_pk($data['m_image_id']);
			$res = true;
			if( ! count($check_exits))
			{
				$data['create_at'] = date('Y-m-d H:i');
				$obj = static::forge();
				$obj->set($data);
				$res = $obj->save();
			}
		}
		catch(\Database_exception $e)
		{
			$res = false;
			throw $e;
		}

		Fuel\Core\DB::query('UNLOCK TABLES');
		return $res;
	}

	public function insert_multi_data($data)
	{
		$res_data = array();
		$check = true;
		foreach($data as $row)
		{
			$res = $this->insert_data($row);
			if($res !== false)
			{
				$res_data[hash('SHA256',$row['content'])] = $row['alt'];
				//$res_data['alt'] = $row['alt'];
			}
			else
			{
				$check = false;
				break;
			}
		}

		if($check)
			return $res_data;

		return false;



	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param type $id
	 * @return boolean
	 */
	public function delete_data($id)
	{
		$obj = static::forge()->find_by_pk($id);
		if(count($obj))
		{
			return $obj->delete();
		}

		return false;
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

}
