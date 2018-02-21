<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Downloadhis
 * @package Model
 */
class Model_Downloadhis extends \Fuel\Core\Model_Crud
{
	protected static $_table_name = 'download_his';
	protected static $_primary_key = 'id';
	protected static $_properties = array(
		'id',
		'download_date',
		'user_id',
		'param',
		'content',
	);

	private $fields;


	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * set data for create/update
	 * @param array $data
	 * @return array
	 */
	public function set_data($data = array())
	{
		foreach ($data as $k => $v)
		{
			$data[$k] = trim($v) != '' ? trim($v) : null;
		}

		$this->fields = $data;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>+
	 * @return bool
	 * @throws Exception
	 */
	public function save_data()
	{
		$login_info = \Fuel\Core\Session::get('login_info');
		$data = $this->fields;
		if (empty($data))
			return false;

		$data['download_date'] = date('Y-m-d H:i:s', time());
		$data['user_id'] = $login_info['user_id'];
		$obj = static::forge();

		$obj->set($data);
		if ($obj->save())
			return true;

		return false;
	}
}