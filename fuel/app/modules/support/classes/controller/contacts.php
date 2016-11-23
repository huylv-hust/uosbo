<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace support;
use Fuel\Core\DB;
use Fuel\Core\Debug;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Oil\Exception;

class Controller_Contacts extends \Controller_Uosbo
{
	public function __construct()
	{
//		Session::set('url_filter_contacts',http_build_query(\Input::get()));
	}
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action list contact
	 */
	public function action_index()
	{
		$data = array();
		$filters = array();
		$keyword = array();
		if(Input::get())
		{
			Session::set('url_filter_contacts',http_build_query(\Input::get()));
			$arr_remove = array(
				'',
				null,
			);
			$filters = array_diff(Input::get(),$arr_remove);
			if(isset($filters['end_date']))
				$filters['end_date'] = $filters['end_date'].' 23:59:59';
			if(isset($filters['keyword']) and trim($filters['keyword']) != '')
				$keyword = array_unique(explode(' ',trim($filters['keyword'])));
		}

		$contacts = new \Model_Contact();
        unset($filters['limit']);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'support/contacts?'.Session::get('url_filter_contacts'),
			'total_items'    => $contacts->count_data($filters,$keyword),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last'      => true,
		));
		$filters['offset'] = $pagination->offset;
		$filters['limit'] = $pagination->per_page;
		$data['pagination'] = $pagination;
		$data['contacts'] = $contacts->get_data($filters,$keyword);
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('contacts/index',$data);
	}

	public function action_change_status()
	{
		if($contact_id = Input::post('contact_id'))
		{
			$user_login = Session::get('login_info');

			$contact = \Model_Contact::find_by_pk($contact_id);
			if(Input::post('status') == 0)
			{
				$contact->set(array('status' => 1, 'user_id' => $user_login['user_id'], 'update_at' => date('Y-m-d H:i:s')));
			}

			if(Input::post('status') == 1)
			{
				$contact->set(array('status' => 0, 'user_id' => null, 'update_at' => null));
			}

			$contact->save();
			Response::redirect(Uri::base().'support/contacts?'.Session::get('url_filter_contacts'));
		}

		Response::redirect(Uri::base().'support/contacts?'.Session::get('url_filter_contacts'));
	}
}