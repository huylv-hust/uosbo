<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Medias extends \Controller_Uosbo
{
	private $_partner_type = 2;
	private $_partners = array('' => '全て');

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * list media
	 */
	public function action_index()
	{
		$m_group = new \Model_Mgroups();
		$m_partner = new \Model_Mpartner();
		$tmp = array('' => 'その他');
		$data['groups'] = $tmp + (new \Model_Mgroups())->get_type(2);
		$data['partners'] = $this->_partners;

		$filters = Input::get();
		$query_string = empty($filters) ? '' : '?'.http_build_query($filters);
		Session::set('medias_url', Uri::base().'master/medias'.$query_string);

		if(isset($filters['m_group_id']) && $filters['m_group_id'])
			$data['partners'] += array_column($m_partner->get_partner_group($filters['m_group_id'], $this->_partner_type), 'branch_name', 'partner_code');

		$m_media = new \Model_Mmedia();
		$m_post = new \Model_Mpost();
        unset($filters['limit']);
		$data['count_media'] = $m_media->count_data($filters);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'master/medias'.$query_string,
			'total_items'    => $data['count_media'],
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last' => true,
		));

		$filters['offset'] = $pagination->offset;
		$filters['limit'] = $pagination->per_page;

		$medias = $m_media->get_data($filters);
		foreach($medias as $media)
		{
			$media->count_post = $m_post->count_by_media_id($media->m_media_id);
		}

		$data['pagination'] = $pagination;
		$data['medias'] = $medias;
		$data['type'] = \Constants::$media_type;
		$data['classification'] = \Constants::get_search_media_classification();
		$data['filters'] = $filters;
		$data['media_autocomplete'] = $m_media->get_list_media('media_name');
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('medias',$data);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * list media
	 */
	public function action_get_partner()
	{
		$m_group_id = Input::post('m_group_id');
		if( ! isset($m_group_id) || $m_group_id == '')
			exit(json_encode($this->_partners));

		$m_partner = new \Model_Mpartner();
		$partners = $this->_partners + array_column($m_partner->get_partner_group($m_group_id, $this->_partner_type), 'branch_name', 'partner_code');
		return Response::forge(json_encode($partners));
	}
}