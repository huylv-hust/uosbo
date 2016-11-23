<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * des: Model_partner and Model_partner_code
 **/

use Fuel\Core\DB;


class Model_Umpartner
{
	public function save_partner($arr_partner = array(),$arr_partner_code = array())
	{
		if(empty($arr_partner) || ! isset($arr_partner['type']))
			return false;

		try{
			DB::start_transaction();
			//Arr_partner['type'] is value before form submit
			$arr_partner_code['ident'] = \Utility::partner_code($arr_partner['type']);

			$m_partner_code = \Model_Partnercode::forge($arr_partner_code);
			if($m_partner_code->save())
			{
				//Get ident and seq_no before partner_code save
				$ident = $m_partner_code->ident;
				$seq_no = sprintf("%'.05d", $m_partner_code->seq_no);
				$arr_partner['partner_code'] = $ident.$seq_no;
			}
			else
			{
				DB::rollback_transaction();
				return false;
			}
			$arr_partner['status']   = \Constants::$_status_partner['pending'];
			$arr_partner['created_at'] = date('Y-m-d H:i:s');
			$m_partner = Model_Mpartner::forge();
			$m_partner->is_new(true);
			$m_partner->set($arr_partner);
			if( ! $m_partner->save())
			{
				DB::rollback_transaction();
				return false;
			}
			else
			{
				DB::commit_transaction();
				return true;
			}
		} catch (Exception $ex) {
			DB::rollback_transaction();
			return false;
		}
	}

	public function edit_partner($id,$arr_partner)
	{
		if(empty($arr_partner) || ! $partner = \Model_Mpartner::find_by_pk($id))
		{
			Session::set_flash('error','取引先は存在しません');
			Response::redirect('master/partners');
		}

		$data_json = json_encode($arr_partner);
		$partner->updated_at = date('Y-m-d H:i:s');
		$partner->status = \Constants::$_status_partner['pending'];
		$partner->edit_data = $data_json;

		if($partner != null && $partner->save() >= 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
}
