<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Ss
 * @package Master
 */
class Controller_Ss extends \Controller_Uosbo
{
	private $filter_group = array(
		'step' => 2,
		'type' => 1,
	);

	private function _compare_data_json($edit_data, $json)
	{
		if($json == '') return array();
		$data = json_decode($json);
		$hide = array();
		foreach($data as $k => $v)
		{
			if($v != $edit_data->$k)
			{
				$hide['title'] = '';
				$hide[$k] = '';
			}
		}

		return $hide;
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action create/update ss
	 */
	public function action_index()
	{
		$ss_id = Input::get('ss_id');
		$filter_group = $this->filter_group;
		$data_filter['field'] = $filter_group;
		if(isset($ss_id))
		{
			$ss = \Model_Mss::find_by_pk($ss_id);
			if( ! isset($ss))
			{
				Session::set_flash('error', 'SSは存在しません');
				return Response::redirect('/master/sslist');
			}

			$data['ss'] = $ss;
			$data['json'] = $ss->edit_data != '' ? json_decode($ss->edit_data) : $ss;
			$data_filter['datafilter'] = \Presenter_Group_Filter::edit($filter_group['step'],$filter_group['type'],$data['json']->partner_code);
			$partner = \Model_Mpartner::find_by_pk($ss->partner_code);
			$group = \Model_Mgroups::find_by_pk($partner->m_group_id);
			$data['branch_name'] = $partner->branch_name;
			$data['group_name'] = $group->name;
			$data['is_view'] = $this->_compare_data_json($ss, $ss->edit_data);
		}

		$submit = Input::post('submit');
		if(isset($submit))
		{
			$url = Session::get('sslist_url') ? Session::get('sslist_url') : Uri::base().'master/sslist';
			$ss = new \Model_Mss();
			$ss->set_data(Input::post());

			if(isset($ss->fields['ss_id']) && ! \Model_Mss::find_by_pk($ss->fields['ss_id']))
			{
				Session::set_flash('error', 'SSは存在しません');
				return Response::redirect($url);
			}

			if( ! \Model_Mpartner::find_by_pk(Input::post('partner_code')))
			{
				Session::set_flash('error', '取引先(受注先)は存在しません');
			}
			else
			{
				if($ss->save_data())
				{
					Session::set_flash('success', \Constants::$message_create_success);
					return Response::redirect($url);
				}

				Session::set_flash('error', \Constants::$message_create_error);
			}
		}

		$data['address1'] = \Constants::get_create_address();
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('ss', $data);
		$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom',$data_filter);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * process change status/is_available ss
	 * @param $type
	 * @param $status
	 */
	private function _set_is_available($status)
	{
		if(Input::method() == 'POST')
		{
			$ss_id = Input::post('ss_id',null);
			$result = 'error';
			$message = \Constants::$message_create_error;
			if( ! \Model_Mss::find_by_pk($ss_id))
			{
				$message = 'SSは存在しません';
			}
			else
			{
				$ss = new \Model_Mss();
				if($ss->set_is_available($ss_id, $status))
				{
					$result = 'success';
					$message = $status == 1 ? '公開しました' : '非公開しました';
				}
			}

			Session::set_flash($result, $message);
		}

		$url = Session::get('sslist_url') ? Session::get('sslist_url') : Uri::base().'master/sslist';
		return Response::redirect($url);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action accept ss
	 */
	public function action_accept()
	{
		$this->_set_is_available(\Model_Mss::$status['accept']);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action reject ss
	 */
	public function action_reject()
	{
		$this->_set_is_available(\Model_Mss::$status['default']);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action confirm ss
	 */
	public function action_confirm()
	{
		if(Input::method() == 'POST')
		{
			$ss_id = Input::post('ss_id', null);
			$result = 'error';
			if( ! \Model_Mss::find_by_pk($ss_id))
			{
				$message = 'SSは存在しません';
			}
			else
			{
				$ss  = new \Model_Mss();
				$message = \Constants::$message_approval_error;
				if($ss->approve($ss_id))
				{
					$result = 'success';
					$message = \Constants::$message_approval_success;
				}
			}

			Session::set_flash($result, $message);
		}

		$url = Session::get('sslist_url') ? Session::get('sslist_url') : Uri::base().'master/sslist';
		return Response::redirect($url);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action delete ss
	 */
	public function action_delete()
	{
		if(Input::method() == 'POST')
		{
			$ss_id = Input::post('ss_id', null);
			$result = 'error';
			if( ! \Model_Mss::find_by_pk($ss_id))
			{
				$message = 'SSは存在しません';
			}
			else
			{
				$message = \Constants::$message_delete_error;
				if(\Model_Uss::delete_ss($ss_id))
				{
					$result = 'success';
					$message = \Constants::$message_delete_success;
				}
			}

			Session::set_flash($result, $message);
		}

		$url = Session::get('sslist_url') ? Session::get('sslist_url') : Uri::base().'master/sslist';
		return Response::redirect($url);
	}
}