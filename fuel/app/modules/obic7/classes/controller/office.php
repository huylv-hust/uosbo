<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace obic7;
use Fuel\Core\Debug;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Oil\Exception;

class Controller_Office extends \Controller_Uosbo
{
	public function action_index()
	{
		$data = array();
		$groups = new \Model_Mgroups();
		if(Input::method() == 'POST')
		{
			$rs = true;
			$data = Input::post();
			$data_update = $data['obic7_name'];
			foreach($data_update as $row)
			{
				foreach($row as $id => $obic7)
				{
					$rs = $rs & $groups->update_obic7(array('obic7_name' => $obic7), $id);

				}
			}
			if($rs)
			{
				Session::set_flash('success','保存しました');
			}
			else
			{
				Session::set_flash('error','取引先グループは存在しません');
			}

		}

		$keywork = Input::get('keywork');
		$data['groups'] = $groups->get_all($keywork, null, null, 'created_at');
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => \Uri::base().'obic7/office?'.http_build_query(Input::get()),
			'total_items'    => count($data['groups']),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last' => true,
		));
		$data['pagination'] = $pagination;
		$data['groups'] = $groups->get_all($keywork,$pagination->offset,$pagination->per_page);
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('office',$data);
	}

}