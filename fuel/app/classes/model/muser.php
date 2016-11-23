<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Muser
 * @package Model
 */
class Model_Muser extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'm_user';
	protected static $_primary_key = 'user_id';
	protected static $_properties = array(
		'user_id',
		'department_id',
		'division_type',
		'name',
		'login_id',
		'created_at',
		'updated_at',
		'mail',
		'pass',
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
	 * @param array $filters
	 * @return $this
	 */
	private function _get_where($filters = array())
	{
		$query = \Fuel\Core\DB::select('m_user.*')->from('m_user');

		if(isset($filters['department_id']) && $filters['department_id'])
		{
			$query->where('m_user.department_id', '=', $filters['department_id']);
		}

		if(isset($filters['name']) && $filters['name'])
		{
			$query->where('m_user.name', 'like', '%'.$filters['name'].'%');
		}

		if(isset($filters['limit']) && $filters['limit'])
		{
			$query->limit($filters['limit']);
		}

		if(isset($filters['offset']) && $filters['offset'])
		{
			$query->offset($filters['offset']);
		}

		if(isset($filters['order_by_time']))
			$query->order_by('m_user.created_at');
		else
			$query->order_by('m_user.user_id','desc');
		return $query;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get data for list user
	 * @param array $filters
	 * @return mixed
	 */
	public function get_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return $query->as_object()->execute();
	}

	/*
	 * List users by department_id
	 *
	 * @since 15/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_user_by_departmentid($department_id, $mail = false, $all = false)
	{
		$query = DB::select('*')
				->from(self::$_table_name);
		if($all == false)
		{
			$query->where('department_id', $department_id);
		}
		else
		{
			if($department_id)
			{
				$query->where('department_id', $department_id);
			}
		}

		if($mail)
		{
			$query->and_where('division_type', 2);
			$query->or_where('division_type', 1);
		}

		return $query->execute()->as_array();
	}

	/*
	 * List email by department_id
	 *
	 * @since 28/10/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_email_by_departmentid($department_id, $user_id, $status)
	{
		$query = DB::select('mail')
				->from(self::$_table_name);
		if($status == 99)
		{
			$query->where('department_id', $department_id);
			$query->and_where('division_type', 2);
		}

		$query->or_where('division_type', 1);

		return $query->execute()->as_array();
	}

	/*
	 * List users by department_id
	 *
	 * @since 15/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_user_info($user_id)
	{
		$result = DB::select('*')
				->from(self::$_table_name)
				->where('user_id', $user_id)
				->execute()
				->as_array();
		if($result)
		{
			return $result[0];
		}
	}

	/*
	 * List all users
	 *
	 * @since 16/09/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function get_list_users()
	{
		return DB::select('*')
				->from(self::$_table_name)
				->execute()
				->as_array();
	}

	/**
	 *
	 * @param type $user_id
	 * @return type
	 */
	public function get_user_info_path($user_id,$key_name1,$data)
	{
		$result = DB::select('*')
				->from(self::$_table_name)
				->where('user_id', $user_id)
				->execute()
				->as_array();

		if($result)
		{
			$data[$key_name1.'_department_id'] = $result[0]['department_id'];
			$data['listusers_'.$key_name1] = $this->get_list_user_by_departmentid($result[0]['department_id']);
			return $data;
		}

		return $data;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count data for list user
	 * @param array $filters
	 * @return int
	 */
	public function count_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return count($query->execute());
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
		$mail = '';
		foreach($data['mail'] as $key => $value)
		{
			if($value)
			{
				$mail .= $value.',';
			}
		}

		$data['mail'] = rtrim($mail, ',');
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
	 * validate unique login_id
	 * @param $login_id
	 * @param null $login_id_old
	 * @return bool
	 */
	public function validate_unique_login_id($login_id, $user_id = null)
	{
		if($user_id && $user = static::find_by_pk($user_id))
		{
			$login_id_old = $user->login_id;
		}

		if( ! isset($login_id_old) || (isset($login_id_old) && $login_id != $login_id_old))
		{
			$data = static::find_one_by('login_id', $login_id);
			if(isset($data))
				return false;
		}

		return true;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $data
	 * @return bool
	 * @throws \Exception
	 */
	public function save_data($data = array())
	{
		if(empty($data))
			return false;
		$data['pass'] = hash('SHA256',\Fuel\Core\Input::post('pass'));
		$data['updated_at'] = date('Y-m-d H:i:s', time());
		if( ! isset($data['user_id']))
		{
			$data['created_at'] = date('Y-m-d H:i:s', time());
			$user = static::forge();
		}
		else
		{
			$user = static::find_by_pk($data['user_id']);
			if(\Fuel\Core\Input::post('pass') == '')
				unset($data['pass']);
			if( ! isset($user))
				return false;

			$user->is_new(false);
		}

		$user->set($data);
		if($user->save())
			return true;

		return false;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete data
	 * @param $user_id
	 * @return bool
	 */
	public function delete_data($user_id)
	{
		try
		{
			if(Model_Orders::count('order_id', false, array(array('author_user_id', '=', $user_id)))
				|| Model_Orders::count('order_id', false, array(array('interview_user_id', '=', $user_id)))
				|| Model_Orders::count('order_id', false, array(array('agreement_user_id', '=', $user_id)))
				|| Model_Orders::count('order_id', false, array(array('training_user_id', '=', $user_id))))
				return false;
			$user = static::find_by_pk($user_id);
			if($user)
			{
				return $user->delete();
			}
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	/**
	 *
	 * @param type $id
	 * @return array([0]['name'])
	 */
	public function get_user_name($id){
		if(count($id) == 0)
			return array();
		$sql = 'SELECT name FROM m_user'
				. ' WHERE user_id ='.$id;
		return Fuel\Core\DB::query($sql)->execute()->as_array();
	}

	public function get_list_mail_department($department_id)
	{
		$query = DB::select('mail')
			->from(self::$_table_name);
		$query->where('department_id', $department_id);
		$query->where('mail','!=',null);
		$query->where('mail','!=','');

		return $query->execute()->as_array();
	}
}