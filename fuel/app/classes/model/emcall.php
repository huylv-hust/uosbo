<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Emcall
 * @package Model
 */
class Model_Emcall extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'emcall';
	protected static $_primary_key = 'emcall_id';
	protected static $_properties = array(
		'emcall_id',
		'person_id',
		'relationship',
		'name',
		'name_kana',
		'tel',
		'zipcode',
		'add1',
		'add2',
		'add3',
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
	private $obj;

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update
	 * @param array $data
	 * @return array
	 */
	public function set_data($obj, $data = array())
	{
		$fields = array();
		foreach($data as $k => $v)
		{
			if(in_array($k, self::$_properties))
			{
				$fields[$k] = trim($v) != '' ? trim($v) : null;
			}

			$fields['zipcode'] = trim($data['zipcode_first'].$data['zipcode_last']);
			$fields['tel'] = $data['tel_1'] != '' ? trim($data['tel_1'].'-'.$data['tel_2'].'-'.$data['tel_3']) : '';
		}

		$fields['updated_at'] = date('Y-m-d H:i:s', time());
		if(isset($fields['emcall_id']))
		{
			$obj->is_new(false);
		}
		else
		{
			$fields['created_at'] = date('Y-m-d H:i:s', time());
		}

		$obj->set($fields);
		$this->obj = $obj;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * @param array $data
	 * @return bool
	 * @throws \Exception
	 */
	public function save_data()
	{
		return $this->obj->save();
	}

	private function _get_where($filters = array())
	{
		$query = \Fuel\Core\DB::select('emcall.*')->from('emcall');

		if(isset($filters['person_id']) && $filters['person_id'])
		{
			$query->where('person_id', '=', $filters['person_id']);
		}

		return $query;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * get data for list emcall
	 * @param array $filters
	 * @return mixed
	 */
	public function get_data($filters = array())
	{
		$query = $this->_get_where($filters);
		return $query->as_object()->execute();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete emcall
	 * @return bool|mixed
	 */
	public function delete_data()
	{
		try
		{
			return self::delete();
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}