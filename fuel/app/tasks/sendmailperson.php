<?php
namespace Fuel\Tasks;
use Fuel\Core\DB;
use Fuel\Core\Uri;
use Utility;
class Sendmailperson
{
	public static $nametitle = array(
		'1' => '連絡結果',
		'2' => '面接日',
		'3' => '面接結果',
		'4' => '採否結果',
		'5' => '契約締結日',
		'6' => '契約結果',
		'7' => '入社日',
		'8' => '社員コード',
		'9' => '勤務確認',
	);

	public function mysendmail($person,$type)
	{
		foreach($person as $k => $v)
		{
			$arr_mail = array();
			if($type == 1 or $type == 2 or $type == 3 or $type == 4)
			{
				$arr_mail[] = self::get_email_user($v['business_user_id']);
				$arr_mail[] = self::get_email_user($v['interview_user_id']);
			}

			if($type == 5 or $type == 6 or $type == 7)
			{
				$arr_mail[] = self::get_email_user($v['business_user_id']);
				$arr_mail[] = self::get_email_user($v['agreement_user_id']);
			}

			if($type == 8)
			{
				$arr_mail[] = self::get_email_user($v['business_user_id']);
			}

			if($type == 9)
			{
				$arr_mail[] = self::get_email_user($v['business_user_id']);
				$arr_mail[] = self::get_email_user($v['training_user_id']);
			}

			$data = array(
				'person_id' => $v['person_id'],
				'uri_base'  => Uri::base(),
				'uosbo_url'   => \Fuel\Core\Config::get('uosbo_url'),
				'ss_name'   => $v['ss_name'],
				'name_kana' => Utility::crop_string($v['name_kana'],4),
				'nametitle' => self::$nametitle[$type],
			);
			if(array_filter($arr_mail))
				Utility::sendmail($arr_mail,'求人管理システム',$data,'email/sendmailperson');
		}
	}

	public static function get_email_user($user_id)
	{
		if( ! isset($user_id) or ! \Model_Muser::find_by_pk($user_id))
			return null;

		return \Model_Muser::find_by_pk($user_id)->mail;
	}

	public static function get_person_id($arr = array())
	{
		$arr_person_id = array();
		foreach($arr as $k => $v)
		{
			foreach($v as $k1 => $v1)
				$arr_person_id[] = $v1['person_id'];
		}

		if(empty($arr_person_id))
		{
			return array('');
		}

		return $arr_person_id;
	}
	public static function execute_array()
	{
		return DB::select(
			'person.person_id',
			'person.order_id',
			'person.interview_user_id',
			'person.agreement_user_id',
			'person.training_user_id',
			'person.business_user_id',
			'm_partner.user_id',
			'm_ss.ss_name',
			'person.name_kana'
		)
			->from('person')
			->join('employment','LEFT')->on('person.person_id', '=', 'employment.person_id')
			->join('sssale')->on('person.sssale_id','=','sssale.sssale_id')
			->join('m_ss')->on('sssale.ss_id','=','m_ss.ss_id')
			->join('m_partner')->on('m_ss.partner_code','=','m_partner.partner_code');
	}
	public function run()
	{
		// check holiday
		$holidays = Utility::get_holidays();
		if (isset($holidays[date('Ymd')]))
		{
			return;
		}

		$person1 = self::execute_array()
			->where('employment.contact_result','is',null)
			->or_where('employment.contact_result','=','0')
			->execute()->as_array();
		$person2 = self::execute_array()
			->where('employment.contact_result','=','1')
			->and_where('employment.review_date','is',null)
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1)))
			->execute()->as_array();
		$person3 = self::execute_array()
			->where('employment.review_date','<',date('Y-m-d'))
			->and_where('employment.review_result','=','0')
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2)))
			->execute()->as_array();
		$person4 = self::execute_array()
			->where('employment.review_result','=','1')
			->and_where('employment.adoption_result','=','0')
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3)))
			->execute()->as_array();
		$person5 = self::execute_array()
			->where('employment.adoption_result','=','1')
			->and_where('employment.contract_date','is',null)
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3, $person4)))
			->execute()->as_array();
		$person6 = self::execute_array()
			->where('employment.contract_date','<',date('Y-m-d'))
			->and_where('employment.contract_result','=','0')
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3, $person4, $person5)))
			->execute()->as_array();
		$person7 = self::execute_array()
			->where('employment.contract_result','=','1')
			->and_where('employment.hire_date','is',null)
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3, $person4, $person5, $person6)))
			->execute()->as_array();
		$person8 = self::execute_array()
			->where('employment.hire_date','<',date('Y-m-d'))
			->and_where('employment.employee_code','is',null)
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3, $person4, $person5, $person6, $person7)))
			->execute()->as_array();
		$person9 = self::execute_array()
			->where('employment.hire_date','<',date('Y-m-d'))
			->and_where('employment.work_confirmation','=','0')
			->and_where('person.person_id','NOT IN',self::get_person_id(array($person1, $person2, $person3, $person4, $person5, $person6, $person7, $person8)))
			->execute()->as_array();


		if( ! empty($person1))
		{
			self::mysendmail($person1,1);
		}

		if( ! empty($person2))
		{
			self::mysendmail($person2,2);
		}

		if( ! empty($person3))
		{
			self::mysendmail($person3,3);
		}

		if( ! empty($person4))
		{
			self::mysendmail($person4,4);
		}

		if( ! empty($person5))
		{
			self::mysendmail($person5,5);
		}

		if( ! empty($person6))
		{
			self::mysendmail($person6,6);
		}

		if( ! empty($person7))
		{
			self::mysendmail($person7,7);
		}

		if( ! empty($person8))
		{
			self::mysendmail($person8,8);
		}

		if( ! empty($person9))
		{
			self::mysendmail($person9,9);
		}
	}
}
