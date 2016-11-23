<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @Des: Prensenter load list using ajax
 **/

class Controller_Filtergroups extends \Fuel\Core\Controller
{
	public function action_group_list()
	{
		$data = array();
		$model_group = new \Model_Mgroups();
		$model_partner = new \Model_Mpartner();
		$data['listgroup'] = array();
		$list_partner = $model_partner->get_list_by_type(1);
		if($list_partner)
		{
			$data['listgroup'] = $model_group->get_list_by_partner($list_partner);
		}

		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($data), 200, $content_type);
	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action load partner list - ajax
	 */
	public function action_partner_list()
	{
		$data = array();
		$group_id = Input::post('group_id');
		$type = Input::post('type');
		$partner = new \Model_Mpartner();
		$data['partners'] = $partner->get_partner_group($group_id,$type);
		return json_encode($data);
	}
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action load ss list - ajax
	 */
	public function action_ss_list()
	{
		$data = array();

		$partner_id = Input::post('partner_id');
		$addr1 = Input::post('addr1', null);
		$flag = Input::post('flag', null);

		$mss = new \Model_Mss();

		if($addr1 && $partner_id == null)
		{
			$model_partner = new \Model_Mpartner();
			$config = array(
				'addr1' => $addr1,
				'type'  => 1,
			);

			$list_partner = $model_partner->get_filter_partner($config);
			$list_partner_code = array();
			if($list_partner)
			{
				foreach($list_partner as $partner)
				{
					$list_partner_code[] = $partner['partner_code'];
				}
			}

			if($list_partner_code)
			{
				$data['list_ss'] = $mss->get_all_ss_by_list_partner_code($list_partner_code);
			}
		}
		else
		{
			$data['list_ss'] = $mss->get_ss_partner($partner_id);
			if($flag && $partner_id == null)
			{
				$data['list_ss'] = $mss->get_ss_partner($partner_id, true);
			}
		}

		return json_encode($data);
	}

	/*
	 * List all media
	 *
	 * @since 29/05/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_media_list()
	{
		if( ! \Input::method() == 'POST')
		{
			return false;
		}

		if( ! \Input::post('partner_id'))
		{
			return false;
		}

		$config['where'] = array('partner_code' => \Input::post('partner_id'));

		$model_media = new Model_Mmedia();
		$list_media['list_media'] = $model_media->get_list_all_media($config);
		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($list_media), 200, $content_type);
	}

	/*
	 * List post
	 *
	 * @since 06/11/2015
	 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	 */
	public function action_post_list()
	{
		if( ! \Input::method() == 'POST')
		{
			return false;
		}

		$media_id = \Input::post('media_id');

		$model_post = new Model_Mpost();
		$data['list_post'] = $model_post->get_list_by_media($media_id);

		$content_type = array(
			'Content-type' => 'application/json',
			'SUCCESS'      => 0,
		);
		echo new \Response(json_encode($data), 200, $content_type);

	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action load ss sale list - ajax
	 */
	public function action_ss_sale_list()
	{
		$data = array();
		$ss_id = Input::post('ss_id');
		$sssale = new Model_Sssale();
		$data['list_ss_sale'] = $sssale->get_sssale_ss($ss_id);
		return json_encode($data);
	}
}