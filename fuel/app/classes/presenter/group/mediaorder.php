<?php
/**
 * @author NamDD <namdd6566@seta-asia.com.vn>
 * @date 19/05/2015
 */
class Presenter_Group_Mediaorder extends Presenter
{
	public function view()
	{
		$model_group = new \Model_Mgroups();
		$model_media = new \Model_Mmedia();
		$model_partner = new \Model_Mpartner();
		$model_post = new Model_Mpost();
		$data['listgroup2'] = array();
		$list_partner2 = $model_partner->get_list_by_type(2);
		if($list_partner2)
		{
			$data['listgroup2'] = $model_group->get_list_by_partner($list_partner2);
		}

		$data['listpost'] = array();
		$data['listmedia'] = array();
		$data['listpartner'] = array();

		$post_id = $this->post_id;
		$data['post_id_selected'] = 0;
		$data['media_id_selected'] = 0;
		$data['partner_code_selected'] = 0;
		$data['group_id_selected'] = 0;
		$media_id = 0;
		$partner_code = 0;
		$group_id = 0;
		$data['media_name'] = null;

		if($post_id)
		{
			$post_info = $model_post->find_by_pk($post_id);
			if($post_info)
			{
				$media_id = $post_info['m_media_id'];
			}
			else
			{
				$data['no_data'] = true;
			}

			if($media_id)
			{
				$media_info = $model_media->find_by_pk($media_id);
				if($media_info)
				{
					$partner_code = $media_info['partner_code'];
					$data['media_name'] = $media_info['media_name'];
				}
				else
				{
					$data['no_data'] = true;
				}

				if($partner_code)
				{
					$partner_info = $model_partner->find_by_pk($partner_code);
					if($partner_info)
					{
						$group_id = $partner_info['m_group_id'];
						$data['listpartner'] = $model_partner->get_partner_group($group_id, 2);
						$config['where'] = array('partner_code' => $partner_code);
						$data['listmedia'] = $model_media->get_search_data($config);
					}
					else
					{
						$data['no_data'] = true;
					}
				}

				$config['where'] = array('m_media_id' => $media_id);
				$data['listpost'] = $model_post->get_search_data($config);
			}
		}

		$data['post_id_selected'] = $post_id;
		$data['media_id_selected'] = $media_id;
		$data['partner_code_selected'] = $partner_code;
		$data['group_id_selected'] = $group_id;
		$this->data = $data;
	}
}
