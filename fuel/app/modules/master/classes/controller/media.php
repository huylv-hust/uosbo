<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Media
 * @package Master
 */
class Controller_Media extends \Controller_Uosbo
{
	private $filter_group = array(
		'step' => 2,
		'type' => 2,
	);
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action create/edit media
	 */
	public function action_index()
	{
		$m_media_id = Input::get('id', null);
		$filter_group = $this->filter_group;
		$datafilter['field'] = $filter_group;
		$media = new \Model_Mmedia();
		if(isset($m_media_id))
		{
			$media = \Model_Mmedia::find_by_pk($m_media_id);
			if( ! isset($media))
			{
				Session::set_flash('error', '媒体は存在しません');
				return Response::redirect('/master/medias');
			}

			$datafilter['datafilter'] = \Presenter_Group_Filter::edit($filter_group['step'],$filter_group['type'],$media->partner_code);
			$data['media'] = $media;
			$data['posts'] = \Model_Mpost::find_by_m_media_id($m_media_id);
		}

		$data['media_name_existed'] = $media->get_list_media('media_name');
		$data['media_version_name_existed'] = $media->get_list_media('media_version_name');
		if(Input::method() == 'POST')
		{
			$url = Session::get('medias_url') ? Session::get('medias_url') : Uri::base().'master/medias';
			$m_media_id = Input::post('m_media_id', null);
			if($m_media_id && ! \Model_Mmedia::find_by_pk($m_media_id))
			{
				Session::set_flash('error', '媒体は存在しません');
				return Response::redirect($url);
			}

			if( ! \Model_Mpartner::find_by_pk(Input::post('partner_code')))
			{
				Session::set_flash('error', '取引先(受注先)は存在しません');
			}
			else
			{
				$media = new \Model_Mmedia();
				$media_data = $media->set_data(Input::post());
				$umedia = new \Model_Umedia();
				$posts = (Input::post('post') != null) ? Input::post('post') : array();
				if($umedia->save_media($media_data, $posts, Input::post('m_media_id')))
				{
					Session::set_flash('success', \Constants::$message_create_success);
					return Response::redirect($url);
				}

				Session::set_flash('error', \Constants::$message_create_error);
			}
		}

		$data['classification'] = \Constants::get_create_media_classification();
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('media', $data);
		$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom',$datafilter);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action delete media
	 */
	public function action_delete()
	{
		if(Input::method() == 'POST')
		{
			$result = 'error';
			$m_media_id = Input::post('m_media_id', null);
			if( ! \Model_Mmedia::find_by_pk($m_media_id))
			{
				$message = '媒体は存在しません';
			}
			else
			{
				$umedia = new \Model_Umedia();
				$message = \Constants::$message_delete_error;
				if($umedia->delete_media($m_media_id))
				{
					$result = 'success';
					$message = \Constants::$message_delete_success;
				}
			}

			Session::set_flash($result, $message);
		}

		$url = Session::get('medias_url') ? Session::get('medias_url') : Uri::base().'master/medias';
		return Response::redirect($url);
	}
}