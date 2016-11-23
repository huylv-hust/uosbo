<?php


Class Model_Mmedia extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_media';
	protected static $_primary_key = 'm_media_id';
	protected static $_properties = array(
		'm_media_id',
		'partner_code',
		'media_name',
		'media_version_name',
		'classification',
		'budget_type',
		'type',
		'is_web_reprint',
		'public_description',
		'deadline_description',
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
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update
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

		return $fields;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $data
	 * @return bool
	 * @throws Exception
	 */
	public function save_data($data = array())
	{
		if(empty($data))
			return false;

		$data['updated_at'] = date('Y-m-d H:i:s', time());
		if( ! isset($data['m_media_id']))
		{
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$media = static::forge();
		}
		else
		{
			$media = static::find_by_pk($data['m_media_id']);
			$media->is_new(false);
		}

		if( ! isset($media))
			return false;

		$media->set($data);
		return $media->save();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $filters
	 * @return mixed
	 */
	private function _get_where($filters = array())
	{
		$query = DB::select('m_media.*', 'm_partner.branch_name')->from('m_media');
		$query->join('m_partner','left')->on('m_media.partner_code', '=', 'm_partner.partner_code');
		$query->join('m_group','left')->on('m_partner.m_group_id', '=', 'm_group.m_group_id');

		if(isset($filters['m_group_id']) && $filters['m_group_id'])
		{
			if(isset($filters['partner_code']) && $filters['partner_code'])
			{
				$query->where('m_media.partner_code', '=', $filters['partner_code']);
			}
			else
			{
				$query->where('m_group.m_group_id', '=', $filters['m_group_id']);
			}
		}

		if(isset($filters['type']) && $filters['type'])
		{
			$query->where('m_media.type', '=', $filters['type']);
		}

		if(isset($filters['classification']) && $filters['classification'])
		{
			$query->where('m_media.classification', '=', $filters['classification']);
		}

		if(isset($filters['media_name']) && $filters['media_name'])
		{
			$query->where('m_media.media_name', 'like', '%'.$filters['media_name'].'%');
		}

		if(isset($filters['limit']) && $filters['limit'])
		{
			$query->limit($filters['limit']);
		}

		if(isset($filters['offset']) && $filters['offset'])
		{
			$query->offset($filters['offset']);
		}

		$query->order_by('m_media.m_media_id','desc');
		return $query;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * list media
	 * @param array $filters
	 * @return mixed
	 */
	public function get_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return $query->as_object()->execute();
	}

	/*
	 * List all media
	 *
	 * @since 29/05/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_all_media($filters = array())
	{
		$res = static::forge()->find($filters);

		if(count($res))
		{
			return Utility::object_to_array($res);
		}

		return false;

	}

	public function get_search_data($config)
	{
		return static::forge()->find($config);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count media
	 * @param array $filters
	 * @return int
	 */
	public function count_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return count($query->execute());
	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @return object
	 */
	public function get_list_media($column = '*')
	{
		$sql = 'SELECT distinct '.$column.' FROM m_media';
		return Fuel\Core\DB::query($sql)->execute();
	}

	public function get_media_id_list_by_name($media_name){
		$sql = 'SELECT distinct m_media_id FROM m_media'
				. ' WHERE media_name LIKE "%'.$media_name.'%"';
		return Fuel\Core\DB::query($sql)->execute()->as_array();
	}
	public function get_media_name($media_id){
		if(count($media_id) == 0)
			return array();
		$sql = 'SELECT media_name FROM m_media'
				. ' WHERE m_media_id ='.$media_id;
		return Fuel\Core\DB::query($sql)->execute()->as_array();
	}
}