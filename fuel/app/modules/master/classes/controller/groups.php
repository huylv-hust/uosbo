<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace Master;
use Fuel\Core\Debug;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Oil\Exception;

class Controller_Groups extends \Controller_Uosbo
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action list group
	 */
	public function action_index()
	{
		if($filter = Input::get())
		{
			Session::set('url_filter_group',http_build_query($filter));//Set url filter
		}

		$data = array();
		$groups = new \Model_Mgroups();
		$keywork = Input::get('keywork');
		$data['groups'] = $groups->get_all($keywork);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => \Uri::base().'master/groups?'.http_build_query(Input::get()),
			'total_items'    => count($data['groups']),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last' => true,
		));
		$data['pagination'] = $pagination;
		$data['groups'] = $groups->get_all($keywork,$pagination->offset,$pagination->per_page);
		$data['group_name'] = $groups->get_all();
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('groups/index',$data);
	}
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action Save group
	 */
	public function action_ajaxsave()
	{
		$group = new \Model_Mgroups();
		$groupid = \Input::post('groupid');
		$group_name = Input::post('groupname');
		$data = array(
			'group_id'   => $groupid,
			'group_name' => $group_name,
		);
		$status = $group->create_group($data);
		return Response::forge(json_encode($status));
	}
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action Show model group edit
	 */
	public function action_edit()
	{
		$group = new \Model_Mgroups();
		$groupid = \Input::post('groupid');
		$data = $group->get_one($groupid);
		if( ! $groupid or ! \Model_Mgroups::find_by_pk($groupid))
		{
			$data = \Constants::$_status_save['id_not_exist'];
			Session::set_flash('error','取引先グループは存在しません');
		}

		return Response::forge(json_encode($data));
	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action Delete
	 */
	public function action_delete()
	{
		$id_group = \Input::post('group_id');
		if( ! $id_group or ! \Model_Mgroups::find_by_pk($id_group))
		{
			\Session::set_flash('error','取引先グループは存在しません');
			\Response::redirect('master/groups');
		}

		$result = 'error';
		$message = '削除に失敗しました';
		$group = new \Model_Mgroups();
		if($group->delete_group($id_group))
		{
			$result = 'success';
			$message = '削除しました。';
		}

		\Session::set_flash($result,$message);
		\Response::redirect('master/groups?'.Session::get('url_filter_group'));
	}

}