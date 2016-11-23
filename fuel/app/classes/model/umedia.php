<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Umedia
 */
class Model_Umedia
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * save media
	 * @param array $media_data
	 * @param array $posts_data
	 * @param null $media_id_edit
	 * @return bool
	 */
	public function save_media($media_data = array(), $posts_data = array(), $media_id_edit = null)
	{
		if(empty($media_data))
			return false;
		try
		{
			\Fuel\Core\DB::start_transaction();
			$media = new Model_Mmedia();
			$post = new Model_Mpost();
			$save = $media->save_data($media_data);
			if( ! $save)
				return false;

			$media_id = isset($save[0]) ? $save[0] : '';
			if(isset($media_id_edit))
			{
				$post_id_edit = array();
				foreach($posts_data as $k => $v)
				{
					if(isset($v['post_id'])) $post_id_edit[] = $v['post_id'];
				}

				$delete = $post->delete_by_media($media_id_edit,$post_id_edit);

				if( ! isset($delete))
				{
					\Fuel\Core\DB::rollback_transaction();
					return false;
				}

				$media_id = $media_id_edit;
			}

			if( ! $post->save_multi_post($posts_data, $media_id))
			{
				\Fuel\Core\DB::rollback_transaction();
				return false;
			}

			\Fuel\Core\DB::commit_transaction();
			return true;
		}
		catch (Exception $e)
		{
			\Fuel\Core\DB::rollback_transaction();
			return false;
		}
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * delete media
	 * @param $media_id
	 * @return bool
	 */
	public function delete_media($media_id)
	{
		$media = Model_Mmedia::find_by_pk($media_id);
		if($media)
		{
			try
			{
				$media_in_job = Model_Job::count('job_id', false, array(array('media_list', 'like', '%,'.$media_id.',%')));
				$array_post = [-1];
				$post = Model_Mpost::find_by('m_media_id', $media_id);
				if(is_array($post)) {
					foreach($post as $k => $v) {
						$array_post[] = $v['post_id'];
					}
				}
				$media_in_order = Model_Orders::count('order_id', false, array(array('post_id', 'in', $array_post)));

				if($media_in_job || $media_in_order)
					return false;
				\Fuel\Core\DB::start_transaction();
				$post = new Model_Mpost();
				$delete_post = $post->delete_by_media($media_id);
				if( ! isset($delete_post))
				{
					\Fuel\Core\DB::rollback_transaction();
					return false;
				}

				if($media->delete() != 1)
				{
					\Fuel\Core\DB::rollback_transaction();
					return false;
				}

				\Fuel\Core\DB::commit_transaction();
				return true;
			}
			catch (Exception $e)
			{
				\Fuel\Core\DB::rollback_transaction();
			}
		}

		return false;
	}
}