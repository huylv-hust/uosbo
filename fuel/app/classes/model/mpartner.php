<?php
/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * File Class/Controler/Model
**/
class Model_Mpartner extends Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_partner';
	protected static $_primary_key = 'partner_code';

	protected static $_properties = array(
		'partner_code',
		'user_id',
		'edit_data',
		'type',
		'master_num',
		'branch_name',
		'zipcode',
		'addr1',
		'addr2',
		'addr3',
		'tel',
		'fax',
		'billing_department',
		'billing_tel',
		'billing_fax',
		'billing_deadline_day',
		'payment_day',
		'billing_start_date',
		'bank_name',
		'bank_branch_name',
		'bank_account_number',
		'notes',
		'status',
		'created_at',
		'updated_at',
		'bank_type',
		'm_group_id',
		'department_id',
		'usami_branch_code',
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

	public static function _set($data = [])
	{
		$fields = array();
		if( ! isset($data['zipcode']))
			$fields['zipcode'] = $data['zipcode_p1'].$data['zipcode_p2'];

		if (isset($data['tel_1']) && isset($data['tel_1']) != '')
		{
			$data['tel'] = $data['tel_1'].'-'.$data['tel_2'].'-'.$data['tel_3'];
		}

		if (isset($data['fax_1']) && isset($data['fax_1']) != '')
		{
			$data['fax'] = $data['fax_1'].'-'.$data['fax_2'].'-'.$data['fax_3'];
		}

		foreach ($data as $k => $v)
		{
			if(in_array($k,self::$_properties))
			{
				$fields[$k] = ($v != '') ? $v : null;
			}
		}

		return $fields;
	}
	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param is where
	 */
	public function _where($filter = array(), $select = '')
	{
		if($select == 'autocomplete')
		{
			$is_where = DB::select('m_group.name','m_partner.branch_name','m_partner.partner_code')->from('m_partner')->join('m_group', 'INNER')->on('m_partner.m_group_id', '=', 'm_group.m_group_id')->order_by('m_partner.created_at','desc');
		}
		else
		{
			$is_where = DB::select('*')->from('m_partner')->join('m_group', 'INNER')->on('m_partner.m_group_id', '=', 'm_group.m_group_id')->order_by('m_partner.created_at','desc');
		}

		if (isset($filter['type']) && $filter['type'] != '')
		{
			$is_where->where('type', '=', $filter['type']);
		}

		if (isset($filter['addr1']) && $filter['addr1'] != '')
		{
			$is_where->where('addr1', '=', $filter['addr1']);
		}

		if (isset($filter['partner_code']) && $filter['partner_code'] != '')
		{
			$is_where->where('partner_code', '=', $filter['partner_code']);
		}

		if (isset($filter['status']))
		{
			$is_where->where('status', '=', $filter['status']);
		}

		if (isset($filter['keyword']) && $filter['keyword'] != '')
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filter['keyword'])));
			$is_where->and_where_open();

			$is_where->and_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$is_where->where(\Fuel\Core\DB::expr('CONCAT(m_group.name, m_partner.branch_name)'), 'like', '%'.$v.'%');
			}

			$is_where->and_where_close();
			$is_where->and_where_close();
		}

		if(isset($filter['department_id']) && $filter['department_id'] != '')
		{
			$is_where->where('department_id','=',$filter['department_id']);
		}

		if(isset($filter['group_id']) && $filter['group_id'] != '')
		{
			$is_where->where('m_partner.m_group_id','=',$filter['group_id']);
		}

		if (isset($filter['limit']))
		{
			$is_where->limit($filter['limit']);
		}

		if (isset($filter['offset']))
		{
			$is_where->offset($filter['offset']);
		}

		return $is_where;
	}
	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param count data
	 */
	public function count_data($filters = array())
	{
		$query = $this->_where($filters);
		return count($query->execute());
	}
	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param Get filter_partner
	 */
	public function get_filter_partner($filter, $select = '*')
	{
		$result = $this->_where($filter,$select);
		return $result->execute()->as_array();
	}

	/*
	 * Get list by type
	 *
	 * @since 05/11/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_by_type($type = 1)
	{
		$query = DB::select(DB::expr('DISTINCT m_group_id'))
				->from(self::$_table_name)
				->where('type', $type)
				->execute()
				->as_array();
		$list_partner = array();
		if($query)
		{
			$list_partner = array_column($query, 'm_group_id');
		}

		return $list_partner;
	}

	/*
	 * Get info by user_id
	 *
	 * @since 16/12/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_info_by_userid($user_id)
	{
		return DB::select('*')
				->from(self::$_table_name)
				->where('user_id', $user_id)
				->execute()
				->as_array();
	}

	//Filter User in department
	public static function get_filter_user_department($id = null)
	{

		$select = DB::select('user_id','name')->from('m_user')->where('department_id','=',$id);
		return $select->execute()->as_array();
	}
	//Get department to user_id
	public static function get_department_user($user_id = null)
	{
		$department_id = null;
		if( ! isset($user_id))
			return false;

		if(\Model_Muser::find_by_pk($user_id))
			$department_id = \Model_Muser::find_by_pk($user_id)->department_id;

		return $department_id;
	}

	//Get partner code in department
	public static function get_partnercode_department($department_id)
	{
		$select = \Fuel\Core\DB::select('partner_code')->from(self::$_table_name)->where('department_id','=',$department_id);
		return $select->execute()->as_array();
	}

	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param Get partner group using presenter
	 */
	public function delete_partner($partner_id)
	{
		if( ! isset($partner_id) or ! $partner = Model_Mpartner::find_by_pk($partner_id))
		{
			Session::set_flash('error','取引先は存在しません');
			Response::redirect('master/partners/?'.Session::get('url_filter_partner'));
		}

		try{
			if($partner->delete())
			{
				return true;
			}
			else
				return false;
		}
		catch(Exception $ex)
		{
			return false;
		}

	}

	public function approval_partner($partner_id)
	{
		if( ! isset($partner_id) || ! $partner = \Model_Mpartner::find_by_pk($partner_id))
		{
			Session::set_flash('error','取引先は存在しません');
			Response::redirect('master/partners/?'.Session::get('url_filter_partner'));
		}

		//Get json from field edit_data
		$edit_data = json_decode($partner->edit_data,true);
		//Set array partner to save array field

		//Check group in json exits
		if($edit_data and ! Model_Mgroups::find_by_pk($edit_data['m_group_id']))
		{
			Session::set_flash('error','取引先グループは存在しません');
			Response::redirect('master/partners/?'.Session::get('url_filter_partner'));
		}

		if(isset($edit_data))
			$arr_partner = \Model_Mpartner::_set($edit_data);

		$arr_partner['status'] = \Constants::$_status_partner['approval'];
		$arr_partner['edit_data'] = null;
		$partner->set($arr_partner);
		if($partner->save())
		{
			return true;
		}

		return false;
	}

	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param Get all partner name
	 */
	public function get_partner_name()
	{
		$select = DB::select('branch_name');
		$select->from('m_partner')->distinct(true)->order_by('created_at', 'desc');
		return $select->execute()->as_array();
	}

	/**
	 * @author DangBc <dang6591@seta-asia.com.vn>
	 * @param Get partner group using presenter
	 */
	public function get_partner_group($idgroup = null, $type = null)
	{
		$select = DB::select('partner_code','branch_name','m_group_id');
		$select->from('m_partner');
		if(isset($idgroup))
		{
			$select->where('m_group_id','=',$idgroup);
		}

		if(isset($type))
		{
			$select->where('type','=',$type);
		}

		return $select->execute()->as_array();
	}

	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * @param string $where
	 * @return object
	 */
	public  function get_list_partner($where ='type=1')
	{
		$sql = 'SELECT * FROM m_partner WHERE '.$where;
		return Fuel\Core\DB::query($sql)->execute();
	}
	public function get_list_partner_login($user_id)
	{
		$sql = 'SELECT * FROM m_partner WHERE user_id = '.$user_id;
		return Fuel\Core\DB::query($sql)->execute();
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
