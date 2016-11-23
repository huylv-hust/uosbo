<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace obic7;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Workplace extends \Controller_Uosbo
{
	public function action_index()
	{
		$data = array();
		$m_ss = new \Model_Mss();
		if(Input::method() == 'POST')
		{
			$rs = true;
			$data = Input::post();
			$data_update = $data['obic7_name'];
			foreach($data_update as $row)
			{
				foreach($row as $id => $obic7)
				{
					$rs = $rs & $m_ss->update_obic7(array('obic7_name' => $obic7), $id);

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

		$filters = Input::get();
		$query_string = empty($filters) ? '' : '?'.http_build_query($filters);
        unset($filters['limit']);
		$data['count_ss'] = $m_ss->count_data($filters);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'obic7/workplace'.$query_string,
			'total_items'    => $data['count_ss'],
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last' => true,
		));

		$filters['offset'] = $pagination->offset;
		$filters['limit'] = $pagination->per_page;
		$data['ss'] = $m_ss->get_data($filters);
		$data['filters'] = $filters;
		$data['pagination'] = $pagination;
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('workplace',$data);
	}

}