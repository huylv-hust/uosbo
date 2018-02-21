<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Uss
 */
class Model_Uss
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action delete ss
	 * @param null $ss_id
	 * @return bool
	 */
	public static function delete_ss($ss_id = null)
	{
		if( ! isset($ss_id))
			return false;

		$ss = Model_Mss::find_by_pk($ss_id);
		if( ! isset($ss))
			return false;

		try
		{
			\Fuel\Core\DB::start_transaction();
			$sssale = new Model_Sssale();
			$delete = $sssale->delete_by_ss($ss_id);
			if( ! isset($delete))
				return false;

			if ( ! $ss->delete())
			{
				\Fuel\Core\DB::rollback_transaction();
				return false;
			}

			\Fuel\Core\DB::commit_transaction();
			return true;
		}
		catch (Exception $e)
		{
			\Fuel\Core\DB::rollback_transaction();
			return false;
		}
	}
}