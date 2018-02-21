<?php
use Fuel\Core\DB;

class Model_Employment extends \Orm\Model
{
	protected static $_table_name = 'employment';
	protected static $_primary_key = array('person_id');

	public function get_data_detail($person_id)
	{
		$data = array();
		$query = DB::query('SELECT * FROM employment WHERE person_id ='.$person_id);

		$data = $query->execute()->as_array();
		if($data)
			return $data[0];

		return array();
	}
	public function get_list_data($array_person_id)
	{
		$query = DB::query('SELECT * FROM employment WHERE person_id IN ('.implode(',',$array_person_id).')');
		return $query->execute();
	}

	public function get_data_by_employee_code($employee_code)
	{
		$query = DB::query('SELECT * FROM employment WHERE employee_code = '.$employee_code);
		$data = $query->execute()->as_array();
		return $data;
	}

	public function get_new_code($person_id)
	{
		$row_partner = Fuel\Core\DB::select('m_partner.usami_branch_code')->from('person')
			->join('sssale', 'INNER')->on('person.sssale_id', '=', 'sssale.sssale_id')
			->join('m_ss', 'INNER')->on('sssale.ss_id', '=', 'm_ss.ss_id')
			->join('m_partner', 'INNER')->on('m_ss.partner_code', '=', 'm_partner.partner_code')
			->where('person.person_id', '=', $person_id)
			->execute()
			->as_array()
		;

		if (is_array($row_partner[0]) == false || !$row_partner[0]['usami_branch_code'])
		{
			throw new \Exception(sprintf('配属先の宇佐美支店番号が登録されていません(応募者ID:%d)', $person_id));
		}


		$branch_code = $row_partner[0]['usami_branch_code'];

		$row_employment = DB::select(DB::expr('max(employee_code) as max_employee_code'))->from('employment')
			->where('employee_code', 'like', $branch_code . '%')
			->execute()
			->as_array()
		;


		$max_code = null;
		if (is_array($row_employment[0]) && $row_employment[0]['max_employee_code'])
		{
			$max_code = $row_employment[0]['max_employee_code'];
		}
		else
		{
			$initials = \Fuel\Core\Config::get('initial_employee_code');
			if (isset($initials[$branch_code]) == false)
			{
				throw new \Exception(sprintf('初期社員コードが未設定です(支店:%s)', $branch_code));
			}
			$max_code = $initials[$branch_code];
		}

		$type = (int)substr($max_code, 2, 1);
		$seq = (int)substr($max_code, -5) + 1;

		if ($seq & 100 === 0)
		{
			$seq++;
		}

		if ($seq > 99999)
		{
			$type++;
			$seq = 1;
		}

		$code = sprintf(
			'%02d%01d%05d',
			(int)$branch_code,
			$type,
			$seq
		);

		return $code;
	}
}