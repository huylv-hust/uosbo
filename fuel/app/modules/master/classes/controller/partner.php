<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @param:
 **/
namespace Master;
use Fuel\Core\Response;
use Fuel\Core\Security;
use Fuel\Core\Input;
use Fuel\Core\Session;

class Controller_Partner extends \Controller_Uosbo
{
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: Action edit and create partner
	 **/
	public function action_index($id_partner = null)
	{
		$is_view = array();
		$data = array();
		$department_id = null;
		if($id_partner)
		{
			$data['partner_code'] = $id_partner;
			if( ! $data_partner = \Model_Mpartner::find_by_pk($id_partner))
			{
				Session::set_flash('error','取引先は存在しません');
				Response::redirect('master/partners');
			}

			$data['edit_partner'] = $data_partner;
			$data['partner'] = $data_partner;

			if($edit_data = $data_partner->edit_data)
			{
				$data['partner'] = json_decode($edit_data);//If exits edit_data, get edit_data
				$is_view = \Utility::compare_json_data($data_partner,$edit_data);
			}
		}

		if(Input::post())
		{
			$arr_partner_code = array();
			$arr_partner = \Model_Mpartner::_set(Input::post());
			$um_partner = new \Model_Umpartner();
			if(isset($id_partner))
			{
				if($is_save = $um_partner->edit_partner($id_partner,$arr_partner))
				{
					Session::set_flash('success',\Constants::$message_create_success);
					Response::redirect('master/partners?'.Session::get('url_filter_partner'));
				}

				Session::set_flash('error',\Constants::$message_create_error);
			}
			else
			{
				if($is_save = $um_partner->save_partner($arr_partner,$arr_partner_code))
				{
					Session::set_flash('success',\Constants::$message_create_success);
					Response::redirect('master/partners?'.Session::get('url_filter_partner'));
				}

				Session::set_flash('error',\Constants::$message_create_error);
			}
		}

		//Get lisst partner name
		$partner = new \Model_Mpartner();
		$data['partner_name'] = $partner->get_partner_name();

		//Define variable form load database from database
		$group = new \Model_Mgroups();
		$data['is_view'] = $is_view;
		$first_group = array('' => '取引先グループを選択して下さい');
		$arr_group = array_column($group->get_all(),'name','m_group_id');
		$data['form']['arr_group'] = $first_group + $arr_group;
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('partner/index',$data);
	}
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: Get all partner name auto complete
	 **/
	public function action_partner_name()
	{
		$partner = new \Model_Mpartner();
		$partner_name = $partner->get_partner_name();
		return Response::forge(json_encode($partner_name));
	}
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: forward status from pending to approval
	 **/
	public function action_approval()
	{
		if(Input::post())
		{
			$partner_id = Input::post('action_partner_code');
			$partner = new \Model_Mpartner();
			$return = 'error';
			$messege = \Constants::$message_approval_error;
			if($partner->approval_partner($partner_id))
			{
				$return = 'success';
				$messege = \Constants::$message_approval_success;
			}

			Session::set_flash($return,$messege);
		}

		Response::redirect('master/partners/?'.Session::get('url_filter_partner'));
	}
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: delete partner
	 **/
	public function action_delete()
	{
		if(Input::post())
		{
			$partner_id = Input::post('action_partner_code');
			$result = 'error';
			$message = \Constants::$message_delete_error;

			$partner = new \Model_Mpartner();
			if($partner->delete_partner($partner_id))
			{
				$result = 'success';
				$message = \Constants::$message_delete_success;
			}

			Session::set_flash($result,$message);
		}

		Response::redirect('master/partners/?'.Session::get('url_filter_partner'));
	}
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: Event change department filter user in form
	 **/
	public function action_change_department($id_department = null)
	{
		if(Input::post())
		{
			$id_department = Input::post('department_id');
			if($id_department == null || $id_department == '') return false;
			$partner = new \Model_Mpartner();
			$arr_user = $partner->get_filter_user_department($id_department);
			return Response::forge(json_encode($arr_user));
		}
	}
}