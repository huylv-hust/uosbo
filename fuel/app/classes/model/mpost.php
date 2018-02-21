<?php

class Model_Mpost extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_post';
	protected static $_primary_key = 'post_id';
	protected static $_properties = array(
		'post_id',
		'name',
		'count',
		'price',
		'note',
		'm_media_id',
	);

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count post by media
	 * @param $media_id
	 * @return int
	 * @throws FuelException
	 */
	public static function count_by_media_id($media_id)
	{
		$where = array(
			array(
				'm_media_id',
				'=',
				$media_id,
			),
		);
		$count = Model_Mpost::count('post_id', false, $where);
		return $count;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * save post
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	public function save_data($data = array())
	{
		$post = Model_Mpost::forge();
		$post->set($data);
		return $post->save();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * remove data post = ''
	 * @param array $data
	 * @return array
	 */
	public function set_array_post($data = array())
	{
		if( ! empty($data))
		{
			foreach($data as $k => $v)
			{
				if( ! isset($v['post_id']) && trim($v['name']) == '' && trim($v['count']) == '' && trim($v['price']) == '' && trim($v['note']) == '')
				{
					unset($data[$k]);
				}
			}
		}

		return $data;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * save multi post
	 * @param array $data
	 * @param $m_media_id
	 * @return bool
	 */
	public function save_multi_post($data = array(), $m_media_id)
	{
		$data = $this->set_array_post($data);
		$data_update = array();
		$data_insert = array();
		foreach($data as $k => $v)
		{
			foreach($v as $key => $val)
			{
				if(in_array($key, self::$_properties))
				{
					$v[$key] = (trim($val) != '') ? trim($val) : null;
				}
			}

			if(isset($v['post_id']))
				$data_update[] = $v;
			else
				$data_insert[] = $v;
		}

		if( ! empty($data_insert))
		{
			$query = DB::insert('m_post')
				->columns(array(
					'name',
					'count',
					'price',
					'note',
					'm_media_id',
					'created_at',
					'updated_at',
				));
			foreach ($data_insert as $k => $v)
			{
				$query->values(array($v['name'], $v['count'], $v['price'], $v['note'], $m_media_id, date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time())));
			}

			$result = $query->execute();
			if( ! isset($result[1]) || $result[1] != count($data_insert))
				return false;
		}

		if( ! empty($data_update))
		{
			foreach($data_update as $k => $v)
			{
				$query = \Fuel\Core\DB::update('m_post');
				$query->set(array(
					'name'       => $v['name'],
					'count'      => $v['count'],
					'price'      => $v['price'],
					'note'       => $v['note'],
					'updated_at' => date('Y-m-d H:i:s', time()),
				));
				$query->where('post_id', $v['post_id']);
				$result = $query->execute();
				if( ! $result)
					return false;
			}
		}

		return true;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete post by media id
	 * @param $media_id
	 * @return object
	 */
	public function delete_by_media($media_id, $post_id = array(0))
	{
		$post_id = !isset($post_id) || !is_array($post_id) || empty($post_id) ? array(0) : $post_id;
		$delete = \Fuel\Core\DB::query('DELETE FROM m_post where m_media_id = :media_id AND post_id NOT IN :post_id')->bind('media_id', $media_id)->bind('post_id', $post_id)->execute();
		return $delete;
	}

	/*
	 * Get sum price
	 *
	 * @since 20/10/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function get_sum_price($post_id)
	{
		$query = DB::select(DB::expr('SUM(price) as total'))
				->from(self::$_table_name)
				->where('post_id', $post_id);
		$result = $query->execute()->as_array();
		if($result[0]['total'])
		{
			return $result[0]['total'];
		}

		return 0;
	}

	/*
	 * Get post by media_id
	 *
	 * @since 06/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function get_list_by_media($media_id)
	{
		return DB::select('*')
				->from(self::$_table_name)
				->where('m_media_id', $media_id)
				->execute()
				->as_array();
	}

	/*
	 * Get post info
	 *
	 * @since 09/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function get_count_by_id($post_id)
	{
		$result = DB::select('*')
				->from(self::$_table_name)
				->where('post_id', $post_id)
				->execute()
				->as_array();
		if($result)
		{
			return $result[0]['count'] != null ? $result[0]['count'] : 0;
		}

		return 0;
	}

	/*
	 * Get all list
	 *
	 * @since 09/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function get_list_all()
	{
		return DB::select('*')
				->from(self::$_table_name)
				->execute()
				->as_array();
	}

	public function get_search_data($config)
	{
		return static::forge()->find($config);
	}
	public function get_list_post_id($media_id_list)
	{
		$is_where = DB::select('post_id')->from('m_post');
		$is_where->where('m_media_id' ,'in' ,$media_id_list);

		return Fuel\Core\DB::query($is_where)->execute()->as_array();
	}
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