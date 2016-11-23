<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Mss
 * @package Model
 */
class Model_Mss extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_ss';
	protected static $_primary_key = 'ss_id';
	protected static $_properties = array(
		'ss_id',
		'edit_data',
		'partner_code',
		'ss_name',
		'obic7_name',
		'original_sale',
		'base_code',
		'zipcode',
		'addr1',
		'addr2',
		'addr3',
		'tel',
		'access',
		'station_name1',
		'station_walk_time1',
		'station_line1',
		'station_name2',
		'station_walk_time2',
		'station_line2',
		'station_name3',
		'station_walk_time3',
		'station_line3',
		'station1',
		'station2',
		'station3',
		'mark_info',
		'notes',
		'status',
		'is_available',
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
	public $fields = array();
	public static $status = array(
		'accept'  => 1,
		'default' => 0,
	);

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $filters
	 * @return $this
	 */
	private function _get_where($filters = array(),$condition = '')
	{
		if($condition == 'autocomplete')
		{
			$query = \Fuel\Core\DB::select('m_ss.base_code', 'm_partner.branch_name', 'm_group.name')->from('m_ss');
		}
		else
		{
			$query = \Fuel\Core\DB::select('m_ss.*', 'm_partner.branch_name', 'm_group.name')->from('m_ss');
		}

		$query->join('m_partner','left')->on('m_ss.partner_code', '=', 'm_partner.partner_code');
		$query->join('m_group','left')->on('m_group.m_group_id', '=', 'm_partner.m_group_id');

		if(isset($filters['department_id']) && $filters['department_id'])
		{
			$query->where('m_partner.department_id', '=', $filters['department_id']);
		}

		if(isset($filters['addr1']) && $filters['addr1'])
		{
			$query->where('m_ss.addr1', '=', $filters['addr1']);
		}

		if(isset($filters['addr2']) && $filters['addr2'])
		{
			$query->where('m_ss.addr2', '=', $filters['addr2']);
		}

		if(isset($filters['group_id']) && $filters['group_id'])
		{
			$query->where('m_partner.m_group_id', '=', $filters['group_id']);
		}

		if(isset($filters['partner_code']) && $filters['partner_code'])
		{
			$query->where('m_ss.partner_code', '=', $filters['partner_code']);
		}

		if(isset($filters['base_code']) && $filters['base_code'] !== '')
		{
			$query->where('m_ss.base_code', '=', $filters['base_code']);
		}

		if(isset($filters['status']) && $filters['status'] !== '')
		{
			$query->where('m_ss.status', '=', $filters['status']);
		}

		if(isset($filters['is_available']) && $filters['is_available'] !== '')
		{
			$query->where('m_ss.is_available', '=', $filters['is_available']);
		}

		if(isset($filters['keyword']) && $filters['keyword'])
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword'])));
			$query->and_where_open();

			$query->and_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where(\Fuel\Core\DB::expr('CONCAT(m_group.name, m_partner.branch_name)'), 'like', '%'.$v.'%');
			}

			$query->and_where_close();

			$query->and_where_close();
		}
		if(isset($filters['keyword_obic7']) && $filters['keyword_obic7'])
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword_obic7'])));
			$query->and_where_open();

			$query->and_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where(\Fuel\Core\DB::expr('CONCAT(m_group.name, m_partner.branch_name,m_ss.ss_name)'), 'like', '%'.$v.'%');
			}

			$query->and_where_close();

			$query->and_where_close();
		}

		if(isset($filters['department_id']) && $filters['department_id'])
		{
			$partner_code = Model_Mpartner::get_partnercode_department($filters['department_id']);
			if(empty($partner_code))
				$partner_code = array('');

			$query->where('m_ss.partner_code','IN',$partner_code);
		}

		if(isset($filters['limit']) && $filters['limit'])
		{
			$query->limit($filters['limit']);
		}

		if(isset($filters['offset']) && $filters['offset'])
		{
			$query->offset($filters['offset']);
		}

		$query->order_by('m_ss.ss_id','desc');
		return $query;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get data for list ss
	 * @param array $filters
	 * @return mixed
	 */
	public function get_data($filters = array(),$condition = '')
	{
		$query = $this->_get_where($filters,$condition);
		return $query->as_object()->execute();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count data for list ss
	 * @param array $filters
	 * @return int
	 */
	public function count_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return count($query->execute());
	}

	/*
	 * List all mss
	 *
	 * @since 16/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_all_ss($filters = array())
	{
		$query = $this->_get_where($filters);
		return $query->execute()->as_array();
	}

	/*
	 * List all ss by list partner_code
	 *
	 * @since 16/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_all_ss_by_list_partner_code($list_partner)
	{
		if(empty($list_partner))
		{
			return array();
		}

		return  DB::select('*')
				->from(self::$_table_name)
				->where('partner_code', 'IN', $list_partner)
				->execute()
				->as_array();
	}

	/*
	 * List all mss
	 *
	 * @since 16/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public static function get_ss_info($ss_id)
	{
		return  DB::select('*')
				->from(self::$_table_name)
				->where('ss_id', $ss_id)
				->execute()
				->as_array();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update
	 * @param array $data
	 * @return array
	 */
	public function set_data($data = array())
	{
		$fields = array();
		if (isset($data['tel_1']) && isset($data['tel_1']) != '')
		{
			$data['tel'] = $data['tel_1'].'-'.$data['tel_2'].'-'.$data['tel_3'];
		}

		foreach($data as $k => $v)
		{
			if(in_array($k, self::$_properties))
			{
				$fields[$k] = trim($v) != '' ? trim($v) : null;
			}

			$fields['zipcode'] = trim($data['zipcode_first'].$data['zipcode_last']);
		}

		if(isset($fields['ss_id']))
		{
			$ss_id = $fields['ss_id'];
			$edit_data['edit_data'] = json_encode($fields);
			$fields = $edit_data;
			$fields['ss_id'] = $ss_id;
		}

		$fields['status'] = 0;
		$this->fields = $fields;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $data
	 * @return bool
	 * @throws \Exception
	 */
	public function save_data()
	{
		$data = $this->fields;
		if(empty($data))
			return false;

		$data['updated_at'] = date('Y-m-d H:i:s', time());
		if( ! isset($data['ss_id']))
		{
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$data['is_available'] = 0;
			$ss = Model_Mss::forge();
		}
		else
		{
			$ss = Model_Mss::find_by_pk($data['ss_id']);
			if( ! isset($ss))
				return false;

			$ss->is_new(false);
		}

		$ss->set($data);
		if($ss->save())
			return true;

		return false;
	}

	public function update_obic7($data,$id)
	{
		$obj = static::forge()->find_by_pk($id);
		if (count($obj))
		{
			$data['updated_at'] = date('Y-m-d H:i:s');
			$obj->set($data);
			$obj->is_new(false);
			return (boolean)$obj->save();
		}

		return false;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * approve ss
	 * @param $ss_id
	 * @return bool
	 */
	public function approve($ss_id)
	{
		if($ss = static::find_by_pk($ss_id))
		{
			$this->fields = array();
			$edit_data = $ss->edit_data;
			if($edit_data != '')
			{
				$this->fields = json_decode($edit_data, true);
				if( ! Model_Mpartner::find_by_pk($this->fields['partner_code']))
				{
					Session::set_flash('error', '取引先は存在しません');
					$url = Session::get('sslist_url') ? Session::get('sslist_url') : Uri::base().'master/sslist';
					return Response::redirect($url);
				}
			}

			$this->fields['ss_id'] = $ss_id;
			$this->fields['status'] = self::$status['accept'];
			$this->fields['edit_data'] = '';
			if($this->save_data())
				return true;
		}

		return false;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * public/unpublic
	 * @param $ss_id
	 * @return bool
	 */
	public function set_is_available($ss_id, $status)
	{
		$this->fields = array(
			'ss_id'        => $ss_id,
			'is_available' => $status,
		);
		if($this->save_data())
			return true;

		return false;
	}

	//@buicongdang code presenter
	public function get_ss_partner($partner_code, $type = false)
	{
		if($type)
		{
			$query = \Fuel\Core\DB::query('SELECT ss_id,ss_name FROM m_ss');
		}
		else
		{
			$query = \Fuel\Core\DB::query('SELECT ss_id,ss_name FROM m_ss WHERE partner_code = :partner_code')->bind('partner_code',$partner_code);
		}

		return $query->execute()->as_array();
	}


	public function get_all_ss()
	{
		$query = \Fuel\Core\DB::query('SELECT ss_id,ss_name FROM m_ss');
		return $query->execute()->as_array();
	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param $where
	 * @return object
	 */
	public  function get_list_ss($where)
	{
		$sql = 'SELECT * FROM m_ss WHERE '.$where;

		if($where == '')
			$sql = 'SELECT * FROM m_ss';

		return Fuel\Core\DB::query($sql)->execute();
	}

	/**
	 * @author Dangbc <dangbc6591@seta-asia.com.vn>
	 * @param $where
	 * @return object
	 */
	public  function get_list_ss_addr($filter = array())
	{
		$query = \Fuel\Core\DB::select('ss_id')->from(self::$_table_name);
		if($filter['addr_1'])
			$query->where('addr1','=',$filter['addr_1']);
		if($filter['addr_2'])
			$query->where('addr2','=',$filter['addr_2']);

		return $query->execute()->as_array();
	}
}