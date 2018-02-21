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
        'lat',
        'lon',
		'mark_info',
		'notes',
		'user_id',
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
	public $header_csv = array(
		'SSID',
		'取引先コード',
		'SS名',
		'元売',
		'拠点コード',
		'郵便番号',
		'都道府県',
		'市区町村',
		'以降の住所',
		'電話番号',
		'アクセス',
		'最寄駅会社1',
		'最寄駅路線1',
		'最寄駅名1',
		'最寄り駅徒歩1',
		'最寄駅会社2',
		'最寄駅路線2',
		'最寄駅名2',
		'最寄り駅徒歩2',
		'最寄駅会社3',
		'最寄駅路線3',
		'最寄駅名3',
		'最寄り駅徒歩3',
        '緯度',
        '経度',
		'備考',
		'営業担当',
	);
	private $error_import = array();
	private $error_approve = array();

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
		if (array_key_exists('is_hidden',$filters))
		{
            $query->where('m_ss.is_hidden', '=', $filters['is_hidden']);
		}
        if (array_key_exists('is_hidden_partner',$filters))
        {
            $query->where('m_partner.is_hidden', '=', $filters['is_hidden_partner']);
        }
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
				$query->where(\Fuel\Core\DB::expr('CONCAT(m_group.name, m_partner.branch_name, m_ss.ss_name)'), 'like', '%'.$v.'%');
			}

			$query->and_where_close();

			$query->and_where_close();
		}

		if(isset($filters['keyword_modal']) && $filters['keyword_modal'])
		{
			$arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword_modal'])));
			$query->and_where_open();
			foreach($arr_keyword as $k => $v)
			{
				$query->where(\Fuel\Core\DB::expr('CONCAT(m_group.name, m_partner.branch_name, m_ss.ss_name, m_ss.addr2, IF(m_ss.addr3 IS NULL, "", m_ss.addr3))'), 'like', '%'.$v.'%');
			}

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

		if(isset($filters['ss_id']) && $filters['ss_id'])
		{
			$query->where('m_ss.ss_id', '=', $filters['ss_id']);
		}
		if(isset($filters['ss_id_in']) && $filters['ss_id_in'])
		{
			$query->where('m_ss.ss_id', 'IN', $filters['ss_id_in']);
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
    public static function get_in_ss($ss_list)
    {
        $query = \Fuel\Core\DB::query('SELECT ss_id,ss_name FROM m_ss WHERE ss_id IN('.$ss_list.')');
        return $query->execute()->as_array();
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
			$query->where('addr2','like','%'.$filter['addr_2'].'%');

		return $query->execute()->as_array();
	}

	/**
	 * @author ThuanTh6589
	 * validate import file
	 * @param $line
	 * @param array $data
	 */
	public function validate_import($line, $data = array())
	{
		if (count($data) != 27)
		{
			$this->error_import[] = $line.'行目:CSVファイルのフォーマットが正しくありません';
		}
		else
		{
			if ($data[0])
			{
				$ss = static::find_by_pk($data[0]);
				if (!$ss)
				{
					$this->error_import[] = $this->set_message_exist($line, $this->header_csv[0]);
				}
				else if (!$ss->status)
				{
					$this->error_approve[] = $this->set_message_approved($line);
					return true;
				}

			}

			if($data[1] == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[1]);
			}
			else
			{
				if( ! Model_Mpartner::find_by_pk($data[1]))
				{
					$this->error_import[] = $this->set_message_exist($line, $this->header_csv[1]);
				}
			}

			if(trim($data[2]) == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[2]);
			}

			if($this->get_length($data[2]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[2], 20);
			}

			if($this->get_length($data[3]) > 50)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[3], 50);
			}

			if(strlen($data[4]) > 7 || ($data[4] != '' && ! preg_match('/^[a-zA-Z0-9]+$/', $data[4])))
			{
				$this->error_import[] = '拠点コードが7桁の半角英数字以内で入力してください';
			}

			if(trim($data[5]) == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[5]);
			}

			if(trim($data[5]) != '' && (strlen($data[5]) != 7 || ! preg_match('/^[0-9]+$/', $data[5])))
			{
				$this->error_import[] = $this->set_message_equal_length($line, $this->header_csv[5], 7);
			}

			if($data[6] == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[6]);
			}
			else
			{
				if(! in_array($data[6], Constants::$address_1))
				{
					$this->error_import[] = $this->set_message_exist($line, $this->header_csv[6]);
				}
			}


			if(trim($data[7]) == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[7]);
			}

			if($this->get_length($data[7]) > 10)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[7], 10);
			}

			if($this->get_length($data[8]) > 50)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[8], 50);
			}

			if($data[9] == '')
			{
				$this->error_import[] = $this->set_message_require($line, $this->header_csv[9]);
			}
			else if (preg_match('/^(?:[0-9]{1,5}-[0-9]{1,4}-[0-9]{1,4}|[0-9]{1,11})$/', $data[9]) == false)
			{
				$this->error_import[] = $this->set_message_format($line, $this->header_csv[9]);
			}

			if($this->get_length($data[10]) > 22)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[10], 22);
			}

			if($this->get_length($data[11]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[11], 20);
			}

			if($this->get_length($data[12]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[12], 20);
			}

			if($this->get_length($data[13]) > 50)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[13], 50);
			}

			if($data[14] !== '' && ( ! preg_match('/^[0-9]+$/', $data[14]) || (int)$data[14] > 99))
			{
				$this->error_import[] = $this->set_message_format($line, $this->header_csv[14]);
			}

			if($this->get_length($data[15]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[15], 20);
			}

			if($this->get_length($data[16]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[16], 20);
			}

			if($this->get_length($data[17]) > 50)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[17], 50);
			}

			if($data[18] !== '' && ( ! preg_match('/^[0-9]+$/', $data[18]) || (int)$data[18] > 99))
			{
				$this->error_import[] = $this->set_message_format($line, $this->header_csv[18]);
			}

			if($this->get_length($data[19]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[19], 20);
			}

			if($this->get_length($data[20]) > 20)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[20], 20);
			}

			if($this->get_length($data[21]) > 50)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[21], 50);
			}

			if($data[22] !== '' && ( ! preg_match('/^[0-9]+$/', $data[22]) || (int)$data[22] > 99))
			{
				$this->error_import[] = $this->set_message_format($line, $this->header_csv[22]);
			}

            if ($data[23] !== '' && (!is_numeric($data[23]) || $data[23] > 999.99999999)) {
                $this->error_import[] = $this->set_message_format($line, $this->header_csv[23]);
            }

            if ($data[24] !== '' && (!is_numeric($data[24]) || $data[24] > 999.99999999)) {
                $this->error_import[] = $this->set_message_format($line, $this->header_csv[24]);
            }

			if($this->get_length($data[25]) > 500)
			{
				$this->error_import[] = $this->set_message_over_length($line, $this->header_csv[24], 500);
			}

			if ($data[26])
			{
				if( ! Model_Muser::find_one_by('name', $data[26]))
				{
					$this->error_import[] = $this->set_message_exist($line, $this->header_csv[25]);
				}
			}
		}
	}

	/**
	 * @author ThuanTh6589
	 * get length full size str
	 */
	private function get_length($str)
	{
		return mb_strlen($str);
	}

	/**
	 * @author ThuanTh6589
	 * message for validate length
	 */
	private function set_message_equal_length($line, $column, $length)
	{
		return $line.'行目:'.$column.'が'.$length.'桁の半角数字で入力して下さい';
	}

	/**
	 * @author ThuanTh6589
	 * message for validate length
	 */
	private function set_message_over_length($line, $column, $length)
	{
		return $line.'行目:'.$column.'が'.$length.'文字以内を入力して下さい';
	}

	/**
	 * @author ThuanTh6589
	 * message for validate require
	 */
	private function set_message_require($line, $column)
	{
		return $line.'行目:'.$column.'を入力して下さい。';
	}

	/**
	 * @author ThuanTh6589
	 * message for validate existed
	 */
	private function set_message_exist($line, $column)
	{
		return $line.'行目:'.$column.'が存在しません。';
	}

	/**
	 * @author ThuanTh6589
	 * message for validate format
	 */
	private function set_message_format($line, $column)
	{
		return  $line.'行目:'.$column.'が正しくありません';
	}

	/**
	 * @author ThuanTh6589
	 * message for validate approved
	 */
	private function set_message_approved($line)
	{
		return $line.'行目:ステータスが「承認待ち」です。';
	}

	/**
	 * @author ThuanTh6589
	 * Import data ss
	 */
	public function save_import($file)
	{
		$header = fgetcsv($file);
		if(count($header) != 27)
		{
			$this->error_import[] = '1行目:CSVファイルのフォーマットが正しくありません';
		}
		$line = 2;
		$error_update = 0;
		\Fuel\Core\DB::start_transaction();
		try
		{
			while(($data = fgetcsv($file)) !== false)
			{
				$this->validate_import($line, $data);
				if(empty($this->error_import))
				{
					if(!$this->update_data_import($data))
						$error_update++;
				}

				$line++;
			}

			if ($error_update > 0 || !empty($this->error_import)) {
				\Fuel\Core\DB::rollback_transaction();
				return ['import' => false, 'error' => $this->error_import, 'approve' => $this->error_approve];
			}

			\Fuel\Core\DB::commit_transaction();
		}
		catch (Exception $e)
		{
			\Fuel\Core\DB::rollback_transaction();
			$this->error_import[] = 'インポートができません';
            Fuel\Core\Log::error('import ss: ' .$e);
			return ['import' => false, 'error' => $this->error_import, 'approve' => $this->error_approve];
		}

		return ['import' => true, 'error' => $this->error_import, 'approve' => $this->error_approve];
	}

    /**
     * @param $data
     * @return bool
     */
	private function update_data_import($data)
	{
		$obj = null;

		if ($data[0])
		{
			$obj = static::find_by_pk($data[0]);
			if(!$obj->status) {
				return true;
			}
		} else {
			$obj = new Model_Mss();
		}

		$update['user_id'] = null;
		if (strlen($data[26]))
		{
			$user = Model_Muser::find_one_by('name', $data[26]);
			if (!$user)
			{
				return false;
			}
			$update['user_id'] = $user['user_id'];
		}

		$update['partner_code'] = $data[1];
		$update['ss_name'] = $data[2];
		$update['original_sale'] = $data[3];
		$update['base_code'] = $data[4];
		$update['zipcode'] = $data[5];
		$update['addr1'] = array_search($data[6], Constants::$address_1);
		$update['addr2'] = $data[7];
		$update['addr3'] = $data[8];
		if(substr_count($data[9],'-'))
		{
			$tel = $data[9];
		}
		else
		{
			if(strlen($data[9]) < 7)
			{
				$tel = substr($data[9], 0, -2).'-'.substr($data[9], -2, 1).'-'.substr($data[9], -1);
			}
			elseif(strlen($data[9]) < 9)
			{
				$tel = substr($data[9], 0, 4).'-'.substr($data[9], 4, -1).'-'.substr($data[9], -1);
			}
			else
			{
				$tel = substr($data[9], 0, 4).'-'.substr($data[9], 4, 4).'-'.substr($data[9], 8, 4);
			}
		}

		$update['tel'] = $tel;
		$update['access'] = $data[10];
		$update['station_name1'] = $data[11];
		$update['station_line1'] = $data[12];
		$update['station1'] = $data[13];
		$update['station_walk_time1'] = $data[14] ? $data[14] : null;
		$update['station_name2'] = $data[15];
		$update['station_line2'] = $data[16];
		$update['station2'] = $data[17];
		$update['station_walk_time2'] = $data[18] ? $data[18] : null;
		$update['station_name3'] = $data[19];
		$update['station_line3'] = $data[20];
		$update['station3'] = $data[21];
		$update['station_walk_time3'] = $data[22] ? $data[22] : null;
		$update['lat'] = $data[23] !== '' ? $data[23] : null;
		$update['lon'] = $data[24] !== '' ? $data[24] : null;
		$update['notes'] = $data[25];
		$update['updated_at'] = date('Y-m-d H:i:s');
		$obj->set($update);
		if($obj->save())
			return true;

		return false;
	}

    /**
     * author HuyLV6635
     * get list address_2, order by address_2 ASC
     * @param array $filters
     * @return mixed
     */
    public function get_list_addr2($filters = array())
    {
        $query = \Fuel\Core\DB::select('addr2')->from('m_ss');
        if(isset($filters['addr1']) && $filters['addr1'])
        {
            $query->where('addr1', '=', $filters['addr1']);
        }

        $query->order_by('addr2','asc');

        return $query->execute()->as_array();
    }

}
