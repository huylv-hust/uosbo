<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace support;
use Fuel\Core\Debug;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Oil\Exception;

class Controller_Contact extends \Controller_Uosbo
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action detail contact
	 */
	public function action_index($id = null)
	{
		$data = array();
		if( ! isset($id) or ! \Model_Contact::find_by_pk($id))
		{
			Response::redirect(Uri::base().'support/contacts');
		}

		$data['contact'] = \Model_Contact::find_by_pk($id);
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('contact/index',$data);
	}
}