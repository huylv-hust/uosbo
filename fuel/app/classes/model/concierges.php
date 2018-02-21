<?php

class Model_Concierges extends \Fuel\Core\Model_Crud
{
	protected static $_primary_key = 'register_id';
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
	protected static $_table_name = 'register';

	/*
	 * List all
	 *
	 * @since 03/11/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public static function get_register_list($limit = null, $offset = null, $search)
	{
		$query = DB::select('*')
				->from(self::$_table_name);
		if(isset($search['start_date']) && $search['start_date'] != null)
		{
			$query->where(DB::expr("DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$search['start_date']."'"));
		}

		if(isset($search['end_date']) && $search['end_date'] != null)
		{
			$query->where(DB::expr("DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$search['end_date']."'"));
		}

		if(isset($search['addr1']) && $search['addr1'] != null)
		{
			$query->where('addr1', $search['addr1']);
		}

		if(isset($search['keyword']) && $search['keyword'] != null)
		{
			$arr_keyword = explode(' ', trim($search['keyword']));
			$query->and_where_open();
			$query->and_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('mobile', 'like', '%'.$v.'%');
			}

			$query->and_where_close();

			$query->or_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('mobile_home', 'like', '%'.$v.'%');
			}

			$query->or_where_close();

			$query->or_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('name', 'like', '%'.$v.'%');
			}

			$query->or_where_close();
			$query->or_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('name_kana', 'like', '%'.$v.'%');
			}

			$query->and_where_close();
			$query->or_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('mail', 'like', '%'.$v.'%');
			}

			$query->or_where_close();

			$query->or_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where('mail2', 'like', '%'.$v.'%');
			}

			$query->or_where_close();
			$query->or_where_close();
		}

		if($limit)
		{
			$query->limit($limit);
		}

		if($offset)
		{
			$query->offset($offset);
		}

		$query->order_by('register_id', 'desc');

		return $query->execute()->as_array();

	}
}
