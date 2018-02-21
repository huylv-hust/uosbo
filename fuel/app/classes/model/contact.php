<?php
/**
 * @author Dang6591 <Dang6591@seta-asia.com.vn>
 * @package Model
 */
class Model_Contact extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'contact';
	protected static $_primary_key = 'contact_id';

	protected static $_properties = array(
		'contact_id',
		'name',
		'name_kana',
		'mobile',
		'mail',
		'content',
		'created_at',
		'status',
		'user_id',
		'update_at',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => true,
			'property'        => 'created_at',
			'overwrite'       => true,
		),
	);

	public static function _get_where($filter = array(),$keyword = array())
	{
		$query = \Fuel\Core\DB::select('*')->from(self::$_table_name)->order_by('created_at','desc');

		if(isset($filter['start_date']) and isset($filter['end_date']))
		{
			$query->where_open();
			$query->where('created_at','>=',$filter['start_date']);
			$query->where('created_at','<=',$filter['end_date']);
			$query->where_close();
		}

		if(isset($filter['start_date']) and ! isset($filter['end_date']))
		{
			$query->where('created_at','>=',$filter['start_date']);
		}

		if(isset($filter['end_date']) and ! isset($filter['start_date']))
		{
			$query->where('created_at','<=',$filter['end_date']);
		}

		if( ! empty($keyword))
		{
			$query->and_where_open();
			$query->or_where_open();
			foreach($keyword as $word)
			{
				$query->where('name','like','%'.$word.'%');
			}

			$query->or_where_close();
			$query->or_where_open();
			foreach($keyword as $word)
			{
				$query->where('name_kana','like','%'.$word.'%');
			}

			$query->or_where_close();
			$query->or_where_open();
			foreach($keyword as $word)
			{
				$query->where('mobile','like','%'.$word.'%');
			}

			$query->or_where_close();
			$query->or_where_open();
			foreach($keyword as $word)
			{
				$query->where('mail','like','%'.$word.'%');
			}

			$query->or_where_close();
			$query->and_where_close();
		}

		if(isset($filter['offset']))
		{
			$query->offset($filter['offset']);
		}

		if(isset($filter['limit']))
		{
			$query->limit($filter['limit']);
		}

		return $query;
	}

	/**
	 * @author Dangbc6591
	 * get data
	 * @param array $filters
	 */
	public function get_data($filters = array(),$keyword = array())
	{
		$query = $this->_get_where($filters,$keyword);
		return $query->execute()->as_array();
	}

	/**
	 * @author Dangbc6591
	 * get count
	 * @param array $filters
	 */
	public function count_data($filters = array(),$keyword = array())
	{
		$query = $this->_get_where($filters,$keyword);
		return count($query->execute());
	}
}