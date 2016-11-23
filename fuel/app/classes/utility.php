<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utility
{
	/*
	 * Send mail
	 *
	 * @since 05/06/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function sendmail($mailto, $subject, $data, $template = false)
	{
		$body = isset($data['body']) ? $data['body'] : null;

		$email = \Email::forge();
		$email->from(\Fuel\Core\Config::get('mail_from'), \Fuel\Core\Config::get('mail_from_name'));

		//if is array mail
		$mail_to = array();
		if(is_array($mailto))
		{
			foreach($mailto as $key => $value)
			{
				$mailto_arr = explode(',', trim($value, ','));
				if(is_array($mailto_arr))
				{
					foreach($mailto_arr as $k => $v)
					{
						if($v != '' && $v != null)
						{
							$mail_to[] = $v;
						}
					}
				}
			}

			//remove duplicate email
			if($mail_to)
			{
				$mail_to = array_unique($mail_to);
			}

			if (count($mail_to) == 0)
			{
				return;
			}

			$email->to($mail_to);
		}
		else
		{
			$email->to($mailto);
		}

		$email->subject($subject);
		$email->body($body);

		//use template
		if($template)
		{
			$email->body(\View::forge($template, $data)); //$data is var pass to template
		}

		//if have attach
		//$email->attach(DOCROOT.'my-pic.jpg');
		try
		{
			$email->send();
			return true;
		}
		catch(\EmailValidationFailedException $e)
		{
			Fuel\Core\Log::error('Mail validation: '.json_encode($mailto));
		}
		catch(\EmailSendingFailedException $e)
		{
			Fuel\Core\Log::error('Mail send failed: '.json_encode($mailto));
		}
	}

	/*
	 * Debug data
	 *
	 * @since 05/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function debug($value, $die = true)
	{
		echo '<pre>';
		print_r($value);
		echo '</pre>';
		if ($die)
		{
			die();
		}
	}

	/*
	 * Set null field data
	 *
	 * @since 05/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function set_null_data($field)
	{
		foreach($field as $key => $value)
		{
			if($value == null || $value == '')
			{
				$field[$key] = null;
			}
		}

		return $field;
	}

	/*
	 * User create array
	 *
	 * @since 05/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function create_array_users($user_array)
	{
		$listusers = array('' => '');
		if($user_array)
		{
			$listusers = $listusers + array_column($user_array, 'name', 'user_id');
		}

		return $listusers;
	}

	public static function sssale_start_end_time($start_time, $end_time)
	{
		if($start_time == null && $end_time == null)
		{
			return null;
		}

		if($start_time == null || $start_time == '')
		{
			$start_time = '00:00';
		}

		if($start_time != null && strlen(trim($start_time)) <= 3)
		{
			$start_time_ex = explode(':', $start_time);
			if(isset($start_time_ex[0]) && $start_time_ex[0] == null)
			{
				$start_time = '00'.$start_time;
			}
			else
			{
				$start_time = $start_time.'00';
			}
		}

		if($end_time == null || $end_time == '')
		{
			$end_time = '00:00';
		}

		if($end_time != null && strlen(trim($end_time)) <= 3)
		{
			$end_time_ex = explode(':', $end_time);
			if(isset($end_time_ex[0]) && $end_time_ex[0] == null)
			{
				$end_time = '00'.$end_time;
			}
			else
			{
				$end_time = $end_time.'00';
			}
		}

		return $start_time.' ～ '.$end_time;
	}


	/*
	 * @author: Bui Cong Dang <dangbc6591@seta-asia.com.vn>
	 * @param $type partner code
	 */
	public static function partner_code($type)
	{
		switch ($type)
		{
		    case '1':
				$ident = 'J';
		    break;

		    case '2':
				$ident = 'H';
		    break;

		    default:
				$ident = null;
		    break;
		}

		return $ident;
	}
	/*
	 * @author: Bui Cong Dang <dangbc6591@seta-asia.com.vn>
	 * @param Get time current
	 */
	public static function next_one_year($start_date)
	{
		return date('Y-m-d', strtotime(date('Y-m-d', strtotime($start_date)).' + 1 year'.' - 1 days'));
	}
	public static function next_one_day($start_date)
	{
		return date('Y-m-d', strtotime(date('Y-m-d', strtotime($start_date)).' + 1 days'));
	}
	public static function between_date($current_year)
	{
		return new DateTime($current_year.'-'.Constants::$plan_between_date['month'].'-'.Constants::$plan_between_date['day']);
	}
	public static function get_time_current()
	{
		$current_year = date('Y');//Get current year now
		$current_month = date('m');//get current month now
		if($current_month < Constants::$plan_between_date['month'])
		{
			$current_year = $current_year - 1;
		}

		$next_year = $current_year + 1;
		$date_start_now = self::between_date($current_year)->format('Y-m-d');
		$date_start_end = self::next_one_year($date_start_now);
		$date_next_now = self::next_one_day($date_start_end);
		$date_next_end = self::next_one_year($date_next_now);
		$arr_date = array(
			$current_year.'-'.Constants::$plan_between_date['month'].'-'.Constants::$plan_between_date['day'] => $date_start_now.' ~ '.$date_start_end,
			$next_year.'-'.Constants::$plan_between_date['month'].'-'.Constants::$plan_between_date['day']    => $date_next_now.' ~ '.$date_next_end,
		);
		return $arr_date;
	}

	public static function get_group_partner($idpartnet)
	{
		$partner = new Model_Mpartner();
		$group_id = $partner->get_group_partner($idpartnet);
		return $group_id;
	}

	public static function get_default_data($table_name)
	{
		$fields = \DB::list_columns($table_name);
		foreach($fields as $k => $v)
		{
			$_data_default[$k] = $v['default'];
		}

		$_data_default['is_new'] = true;
		return $_data_default;
	}

	public static function set_standard_data_job($data,$is_exists =true,$_data_default = array())
	{
		if( ! count($data))
			return array();

		$data['zipcode'] = '';
		if(isset($data['zipcode_first']))
			$data['zipcode'] = $data['zipcode_first'];

		if(isset($data['zipcode_last']))
			$data['zipcode'] .= $data['zipcode_last'];

		$data['public_type'] = 0;
		if(isset($data['public_type_1']))
			$data['public_type'] = (int)$data['public_type_1'];

		if(isset($data['public_type_2']))
			$data['public_type'] = $data['public_type'] + (int)$data['public_type_2'];

		$data['phone_number1'] = '';
		if(isset($data['phone_number1_1']))
			$data['phone_number1'] .= $data['phone_number1_1'];

		if(isset($data['phone_number1_2']))
			$data['phone_number1'] .= ','.$data['phone_number1_2'];

		if(isset($data['phone_number1_3']))
			$data['phone_number1'] .= ','.$data['phone_number1_3'];

		$data['phone_number2'] = '';
		if(isset($data['phone_number2_1']))
			$data['phone_number2'] .= $data['phone_number2_1'];

		if(isset($data['phone_number2_2']))
			$data['phone_number2'] .= ','.$data['phone_number2_2'];

		if(isset($data['phone_number2_3']))
			$data['phone_number2'] .= ','.$data['phone_number2_3'];

		foreach($data as $key => $val)
		{
			if(is_array($val))
			{
				$data[$key] = implode(',',$val);
				if($data[$key])
					$data[$key] = ','.$data[$key].',';
			}
			else
			{
				$data[$key] = trim($val);
			}

			if($val == '')
				$data[$key] = null;

			if($is_exists)
			{
				if ( ! key_exists($key, $_data_default))
				{
					unset($data[$key]);
				}
			}
		}


		if( ! isset($data['is_pickup']))
			$data['is_pickup'] = 0;

		if( ! isset($data['is_conscription']))
			$data['is_conscription'] = 0;

		$data['updated_at'] = date('Y-m-d H:i');
		$data['status'] = 0;
		$data['is_available'] = 0;

		return $data;
	}
	/**
	 * set data for add and recruit
	 * @param type $data
	 * @param type $job_id
	 * @param type $index_1
	 * @param type $index_2
	 * @return type
	 */
	public static function set_data_job_add_recruit($data,$job_id,$index_1 = 'job_add_sub_title',$index_2 = 'job_add_text')
	{
		$data_job = array();
		$data_sub_title = isset($data[$index_1]) ? $data[$index_1] : array();
		$data_text = isset($data[$index_2]) ? $data[$index_2] : array();

		if(count($data_sub_title))
		{
			for($i = 0; $i < count($data_sub_title); ++$i)
			{
				if(( ! isset($data_sub_title[$i]) && ! isset($data_text[$i]) ) || ( trim($data_sub_title[$i]) == '' && trim($data_text[$i]) == '')) continue;

				$data_job[] = array(
					'sub_title' => $data_sub_title[$i],
					'text'      => $data_text[$i],
					'job_id'    => $job_id,
				);
			}
		}

		return $data_job;
	}
	/**
	 *
	 * @param type $data
	 * @return type
	 */
	public static function object_to_array($data)
	{
		$result = array();
		$j = 0;
		foreach ($data as $_temp)
		{
			foreach ($_temp as $k => $v)
				$result[$j][$k] = $v;
			++$j;
		}

		return $result;
	}

	//Strip tag html and space in string
	public static function strip_tag_string($str)
	{
		$str = strip_tags($str);
		$str = trim($str);
		return $str;
	}

	//Get uri from controller
	private static function convert_controller_uri($s_controller)
	{
		$uri = explode('\\',$s_controller);
		$uri = explode('_',$uri[1]);
		return strtolower($uri[1]);
	}

	private static function get_array_uri($division_type = null)
	{
		if( ! isset($division_type))
		{
			return false;
		}

		if( ! array_key_exists($division_type, MyAuth::$roles))
		{
			return false;
		}

		$arr_controller = MyAuth::$roles[$division_type];
		$arr_uri = array();
		foreach($arr_controller as $k => $v)
		{
			$arr_uri[] = self::convert_controller_uri($k);
		}

		return $arr_uri;
	}
	//View role menu
	public static function view_menu_role($uri)
	{
		if( ! $login_info = \Fuel\Core\Session::get('login_info'))
			return 'hide';
		if( ! array_key_exists($login_info['division_type'], self::get_array_uri($login_info['division_type'])))
			return 'hide';
		$arr_role = self::get_array_uri($login_info['division_type']);
		if( ! in_array($uri,$arr_role))
			return 'hide';
	}
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param $action (edit|public|unpublic|approval|unapproval)
	 * @return mixed.
	 */
	public static function is_allowed($action)
	{
		$user_info = \Fuel\Core\Session::get('login_info');
		$division_type = $user_info['division_type'];
		$accept_roles = explode(',', MyAuth::$roles_edit[$division_type]);
		if(in_array($action, $accept_roles))
			return '';
		return 'hide';
	}
	/**
	 * crop tring, add ...
	 * @param $str
	 * @param $length
	 * @param string $char
	 * @return string
	 */
	public static function crop_string($str, $length)
	{
		$str = trim($str);

		// nếu str < length, return str
		$strlen	= mb_strlen($str, 'UTF-8');

		if($strlen <= $length) return $str;

		// Cắt chiều dài chuỗi tới đoạn cần lấy
		$substr	= mb_substr($str, 0, $length, 'UTF-8');
		return $substr;
	}

	/**
	 * Dang Bui
	 * crop tring, add ...
	 * @param $str
	 * @param $length
	 * @param string $char
	 * @return string
	 */
	public static function explode_hh_mm($str)
	{
		$str = trim($str);
		$pieces = explode(':', $str);
		return $pieces;
	}

	/**
	 * Japanese holidays
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @return array
	 */
	public static function get_holidays()
	{
		$identifier = 'holidays';

		try
		{
			$cache = \Fuel\Core\Cache::get($identifier);
			if (is_array($cache))
			{
				return $cache;
			}
		}
		catch (\Fuel\Core\CacheNotFoundException $ex)
		{
		}

		$url = 'https://calendar.google.com/calendar/ical/japanese__ja%40holiday.calendar.google.com/public/full.ics';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$ics = curl_exec($ch);
		curl_close($ch);

		$holidays = array(); $day = null;
		foreach (explode("\n", $ics) as $line)
		{
			$line = trim($line);
			if (substr($line, 0, 8) == 'DTSTART;')
			{
				$array = explode(':', $line);
				$day = $array[1];
			}
			if (substr($line, 0, 8) == 'SUMMARY:')
			{
				$array = explode(':', $line);
				$holidays[$day] = $array[1];
			}
		}

		ksort($holidays);
		\Fuel\Core\Cache::set($identifier, $holidays, 86400);

		return $holidays;
	}

	/**
	 * Encrypt
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @param mixed
	 * @return string
	 */
	public static function encrypt($data)
	{
		return bin2hex(mcrypt_encrypt(
			MCRYPT_BLOWFISH,
			pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
			serialize($data),
			MCRYPT_MODE_CBC,
			pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
		));
	}

	/**
	 * Decrypt
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @param string
	 * @return mixed
	 */
	public static function decrypt($encrypted)
	{
		try
		{
			$decrypted = rtrim(mcrypt_decrypt(
				MCRYPT_BLOWFISH,
				pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
				pack("H*", $encrypted),
				MCRYPT_MODE_CBC,
				pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
			));

			return unserialize($decrypted);
		}
		catch (Fuel\Core\PhpErrorException $ex)
		{
			return null;
		}
	}

	/**
	 * Compare json two data
	 */
	public static function compare_json_data($data,$json)
	{
		$is_view = array();
		if($data_json = json_decode($json))
		{
			foreach($data_json as $k => $v)
			{
				if($data[$k] != $v)
				{
					$is_view[$k] = 'edit-display-show';
				}
			}
		}

		return $is_view;
	}


}