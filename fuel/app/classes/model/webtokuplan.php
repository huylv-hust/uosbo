<?php
use \Fuel\Core\DB;

class Model_Webtokuplan extends Orm\Model
{
	protected static $_table_name = 'webtoku_plan';
	protected static $_primary_key = array(
		'department_id',
		'start_date',
		'month',
	);
	protected static $_properties = array(
		'department_id',
		'start_date',
		'month',
		'budget',
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

	public function get_plans($department_id, $start_date)
	{
		$rows = DB::select('*')->from(self::$_table_name)
			->where('department_id','=', $department_id)
			->where('start_date','=', $start_date)
			->execute()->as_array();

		$plans = [];
		if (empty($rows) == false)
		{
			foreach ($rows as $row)
			{
				$plans[$row['month']] = $row['budget'];
			}
		}
		else
		{
			for ($i=1;$i<=12;$i++)
			{
				$plans[$i] = 0;
			}
		}

		return $plans;
	}

	public function save_plan($department_id, $start_date, $plans)
	{
		try{
			DB::start_transaction();

			$table_name = self::$_table_name;
			$res = DB::query("
				DELETE FROM $table_name where
				department_id = :department_id and start_date = :start_date")
				->bind('department_id', $department_id)
				->bind('start_date', $start_date)
				->execute();

			$insert = DB::insert(self::$_table_name)
				->columns(array('department_id', 'start_date', 'month', 'budget', 'created_at', 'updated_at'));

			$month = 0;
			foreach ($plans as $budget)
			{
				$insert->values(array($department_id, $start_date, ++$month, intval($budget), DB::expr('NOW()'), DB::expr('NOW()')));
			}

			if (!$insert->execute())
			{
				DB::rollback_transaction();
				return false;
			}

			DB::commit_transaction();
			return true;
		} catch (Exception $ex){
			DB::rollback_transaction();
			return false;
		}
	}

}
