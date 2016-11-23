<?php
/**
 * job class
 * @author NamDD <namdd@seta-asia.com.vn>
 * @date 01/09/2015
 */

class Model_Job extends Fuel\Core\Model_Crud
{
	protected static $_table_name = 'job';
	protected static $_primary_key = 'job_id';
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
	public function save_data($data, $id = '')
	{
		if ($id === '')
		{
			$data = Utility::set_standard_data_job($data,true,$this->_data_default);
			$data['created_at'] = date('Y-m-d H:i');
			$obj = static::forge();
			$obj->set($data);
			$res = $obj->save();
			return $res['0'];
		}

		$obj = static::forge()->find_by_pk($id);
		if (count($obj))
		{
			$data['updated_at'] = date('Y-m-d H:i');
			$obj->set($data);
			$obj->is_new(false);
			return (boolean)$obj->save();
		}

		return false;
	}
	public function update_data_csv($data,$id,$validate,&$no_update,$index)
	{
		$obj = static::forge()->find_by_pk($id);
		if (count($obj))
		{
			if($obj['status'] == 0 && $obj['edit_data'] == '')
			{
				$no_update[$index] = $index.'行目:ステータスが「承認待ち」です';
				return true;
			}

			if( ! $validate)
				return false;

			foreach($data as $key => $val)
			{
				if($val == '') $data[$key] = null;
			}

			$data['updated_at'] = date('Y-m-d H:i:s');
			$obj->set($data);
			$obj->is_new(false);
			return (boolean)$obj->save();
		}
		else
		{
			return -1;
			//return 'NOT EXIT JOB_ID '.$id. ' AT ROW'.$order;
		}
	}

	public function approve_data($id)
	{
		try{
			$obj = static::forge()->find_by_pk($id);
			$data = array();
			if (count($obj))
			{
				$data_old = $obj->_data;
				$data_job_add = array();
				$data_job_rec = array();

				if($data_old['edit_data'])
				{
					$data = json_decode($data_old['edit_data'],true);
					if( ! Model_Sssale::find_by_pk($data['sssale_id']))
					{
						return 0;
					}

					$data_job_add = Utility::set_data_job_add_recruit($data,$id);
					$data_job_rec = Utility::set_data_job_add_recruit($data,$id,'job_recruit_sub_title','job_recruit_text');
					$data = Utility::set_standard_data_job($data,true,$this->_data_default);
				}
				else
				{
					$data['updated_at'] = date('Y-m-d H:i');
					$data['status'] = 1;
					$obj->set($data);
					$obj->is_new(false);
					return (boolean)$obj->save();
				}

				DB::start_transaction();
				$data['is_available'] = $data_old['is_available'];
				$data['status'] = 1;
				$data['edit_data'] = null;
				$obj->set($data);
				$obj->is_new(false);
				$res = (boolean)$obj->save();
				if($res)
				{
					$obj_add = new Model_Jobadd();
					$obj_rec = new Model_Jobrecruit();
					$res_flag = false;
					if($obj_add->delete_data($id) >= 0)
					{
						$res_flag = true;
					}

					if($res_flag && $obj_add->insert_multi_data($data_job_add,$this) === false)
					{
						$res_flag = false;
					}

					if($res_flag && $obj_rec->delete_data($id) >= 0)
					{
						$res_flag = true;
					}
					else
					{
						$res_flag = false;
					}

					if($res_flag && $obj_rec->insert_multi_data($data_job_rec,$this) === false)
					{
						$res_flag = false;
					}

					if($res_flag)
					{
						\DB::commit_transaction();
						return true;
					}
					else
					{
						\DB::rollback_transaction();
						return false;
					}
				}

				return false;
			}

			return false;
		}
		catch (Exception $e)
		{
			\DB::rollback_transaction();
			throw $e;
			return false;
		}
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
	/**
	 *
	 * @param type $id
	 * @return type
	 */
	public function get_info_data($id)
	{
		$obj = static::forge()->find_by_pk($id);
		if($obj !== null)
		{
			return $obj->_data;
		}

		return $this->_data_default;
	}

	public function get_search_data($config)
	{
		return static::forge()->find($config);
	}

	public function get_list_id()
	{
		$list = array('なし');

		$query = DB::query('
			SELECT
				j.job_id, ss.ss_name, sale.sale_name
			FROM
				job as j
				left join m_ss as ss on (j.ss_id = ss.ss_id)
				left join sssale as sale on (j.sssale_id = sale.sssale_id)
		');

		// return a new Database_MySQLi_Result
		$data = $query->execute()->as_array();

		if($data)
		{
			foreach($data as $value)
			{
				$list[$value['job_id']] = $value['ss_name'].' '.$value['sale_name'];
			}
		}

		return $list;
	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get job for export result csv
	 * @return mixed
	 */
	public function get_job_for_result_csv($filters)
	{
		$query = \Fuel\Core\DB::select('job.job_id', 'job.ss_id', 'job.sssale_id', 'person.reprinted_via', 'm_group.name', 'm_partner.branch_name', 'm_ss.ss_name', 'm_user.department_id', 'm_user.name')->from('job');
		$query->join('person','left')->on('person.job_id', '=', 'job.job_id');
		$query->join('sssale','left')->on('sssale.sssale_id', '=', 'job.sssale_id');
		$query->join('m_ss','left')->on('m_ss.ss_id', '=', 'sssale.ss_id');
		$query->join('m_partner','left')->on('m_ss.partner_code', '=', 'm_partner.partner_code');
		$query->join('m_user','left')->on('m_user.user_id', '=', 'm_partner.user_id');
		$query->join('m_group','left')->on('m_partner.m_group_id', '=', 'm_group.m_group_id');

		if(isset($filters['start_date']) && $filters['start_date'])
		{
			$query->where('job.start_date', '>=', $filters['start_date']);
		}

		if(isset($filters['end_date']) && $filters['end_date'])
		{
			$query->where('job.end_date', '<=', $filters['end_date']);
		}

		$query->group_by('job.job_id');
		return $query->execute();
	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count person for export result csv
	 * @param $filters
	 * @return mixed
	 */
	public function count_person($filters)
	{
		$query = \Fuel\Core\DB::select('employment.review_result', 'employment.contact_result', 'employment.adoption_result')->from('job');
		$query->join('person','left')->on('job.job_id', '=', 'person.job_id');
		$query->join('employment','left')->on('person.person_id', '=', 'employment.person_id');

		if(isset($filters['person_id']))
		{
			$filters['person_id'] = empty($filters['person_id']) ? array(0) : $filters['person_id'];
			$query->where('person.person_id', 'in', $filters['person_id']);
		}

		return $query->execute();
	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count person for export result csv
	 * @param $filters
	 * @return int
	 */
	public function count_person_in_sssale($filters)
	{
		$query = \Fuel\Core\DB::select('person.person_id')->from('job');
		$query->join('person','left')->on('job.job_id', '=', 'person.job_id')->and_on('job.sssale_id', '=', 'person.sssale_id');

		$query->where('person.person_id', 'is not', null);
		if(isset($filters['job_id']))
		{
			$query->where('job.job_id', '=', $filters['job_id']);
		}

		return $query->execute();
	}
	public function count_data($filters = array())
	{
		$result = DB::select('*')->from('job')->where('status',0)->execute();
		return count($result);

	}

	/**
	 * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * count job for top
	 * @param array $filters
	 * @return int
	 */
	public function count_job_department_id($filters = array())
	{
		$query = \Fuel\Core\DB::select('job.job_id')->from('job');
		$query->join('sssale','left')->on('sssale.sssale_id', '=', 'job.sssale_id');
		$query->join('m_ss','left')->on('m_ss.ss_id', '=', 'sssale.ss_id');
		$query->join('m_partner','left')->on('m_ss.partner_code', '=', 'm_partner.partner_code');

		if(isset($filters['department_id']) && $filters['department_id'])
			$query->where('m_partner.department_id', '=', $filters['department_id']);
		if(isset($filters['status']) && $filters['status'] !== '')
			$query->where('job.status', '=', $filters['status']);
		return count($query->execute());
	}
}
