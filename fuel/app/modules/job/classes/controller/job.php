<?php
namespace job;
class Controller_Job extends \Controller_Uosbo
{
	/**
	 *
	 * @param type $str1
	 * @param type $str2
	 * @return boolean is true str1!=str2
	 */
	private function _compare_other_string($str1,$str2)
	{
		$_arr1 = explode(',', trim($str1,','));
		$_arr2 = explode(',', trim($str2,','));


		if(count($_arr1) != count($_arr2))
			return true;


		$res = array_diff($_arr1,$_arr2);
		if(count($res) == 0)
			return false;
		else
			return true;

	}
	/**
	 *
	 * @param type $edit_data
	 * @param type $json_data
	 * @return boolean
	 * is false edit_data =! json_data is true
	 */
	private function _set_data_json($data)
	{
		if(isset($data['employment_mark']) && is_array($data['employment_mark']) && count($data['employment_mark']))
		{
			$data['employment_mark'] = ','.implode(',',$data['employment_mark']).',';
		}
		else
		{
			$data['employment_mark'] = '';
		}

		if(isset($data['work_time_view']) && is_array($data['work_time_view']) && count($data['work_time_view']))
		{
			$data['work_time_view'] = ','.implode(',',$data['work_time_view']).',';
		}
		else
		{
			$data['work_time_view'] = '';
		}

		if(isset($data['trouble']) && is_array($data['trouble']) && count($data['trouble']))
		{
			$data['trouble'] = ','.implode(',',$data['trouble']).',';
		}
		else
		{
			$data['trouble'] = '';
		}

		if(isset($data['media_list']))
		{
			$data['media_list'] = ','.implode(',',$data['media_list']).',';
		}
		else
			$data['media_list'] = '';

		return $data;


	}
	private function _compare_other_data_json($edit_data, $json_data)
	{



		$_arr_key_other = array();
		unset($edit_data['edit_data']);
		if($json_data == '' || $json_data == null)
			return $_arr_key_other;

		$data = $this->_set_data_json(json_decode($json_data,true));
		if(isset($data['phone_number1_1']))
		{
			$data['phone_number1'] = $data['phone_number1_1'].','.$data['phone_number1_2'].','.$data['phone_number1_3'];
		}

		if(isset($data['phone_number2_1']))
		{
			$data['phone_number2'] = $data['phone_number2_1'].','.$data['phone_number2_2'].','.$data['phone_number2_3'];
		}

		$data['public_type'] = 0;
		if(isset($data['public_type_1']))
			$data['public_type'] = $data['public_type'] + (int)$data['public_type_1'];

		if(isset($data['public_type_2']))
			$data['public_type'] = $data['public_type'] + (int)$data['public_type_2'];

		$data['zipcode'] = '';
		if(isset($data['zipcode_first']))
			$data['zipcode'] .= $data['zipcode_first'];
		if(isset($data['zipcode_last']))
			$data['zipcode'] .= $data['zipcode_last'];

		unset($data['zipcode_first']);
		unset($data['zipcode_last']);
		unset($data['public_type_1']);
		unset($data['public_type_2']);
		unset($data['phone_number1_1']);
		unset($data['phone_number1_2']);
		unset($data['phone_number1_3']);
		unset($data['phone_number2_1']);
		unset($data['phone_number2_2']);
		unset($data['phone_number2_3']);
		unset($data['m_group_id']);
		unset($data['partner_code']);
		foreach($data as $key => $val)
		{
			if($key == 'media_list')
			{
				if($this->_compare_other_string($edit_data[$key],$val))
				{
					$_arr_key_other['media_list'] = true;
					//return true;
				}
			}

			elseif($key == 'image_list')
			{
				$image_list = json_decode($edit_data['image_list'],true);
				$image_list1 = json_decode($data['image_list'],true);
				if(count(array_diff($image_list1,$image_list)) || count(array_diff($image_list,$image_list1)))
				{
					$_arr_key_other['image_list'] = true;
				}
			}

			elseif($key == 'job_recruit_sub_title')
			{
				$job_recruit = $edit_data['job_recruit'];
				$content = '';
				foreach($edit_data['job_recruit'] as $row)
				{
					$content .= $row['sub_title'].'.'.$row['text'].'|';
				}

				$content = trim(trim($content,'|'),'.');

				$content_1 = '';

				for($i = 0; $i < count($data[$key]); ++$i)
				{
					if(isset($data[$key][$i]))
					{
						if(isset($data[$key][$i]))
						{
							$content_1 .= $data[$key][$i].'.'.$data['job_recruit_text'][$i].'|';
						}
					}
				}

				$content_1 = trim(trim($content_1,'|'),'.');
				if($content_1 != $content)
				{
					$_arr_key_other['job_recruit_sub_title'] = true;
					//return true;
				}
				else
				{
					$_arr = explode('|',$content);
					$_arr1 = explode('|',$content_1);
					if(count($_arr1) != count($_arr))
					{
						$_arr_key_other['job_recruit_sub_title'] = true;
						//return true;
					}

					else
					{
						if(count(array_diff($_arr,$_arr1)) > 0)
						{
							$_arr_key_other['job_recruit_sub_title'] = true;
						}
					}
				}
			}

			elseif($key == 'job_add_sub_title')
			{
				$job_add = $edit_data['job_add'];

				$content_add = '';
				foreach($edit_data['job_add'] as $row)
				{
					$content_add .= $row['sub_title'].'.'.$row['text'].'|';
				}

				$content_add = trim(trim($content_add,'|'),'.');

				$content_add_1 = '';
				for($i = 0; $i < count($data[$key]); ++$i)
				{
					if(isset($data[$key][$i]))
					{
						if(isset($data[$key][$i]))
						{
							$content_add_1 .= $data[$key][$i].'.'.$data['job_add_text'][$i].'|';
						}
					}
				}

				$content_add_1 = trim(trim($content_add_1,'|'),'.');
				if($content_add_1 != $content_add)
				{
					$_arr_key_other['job_add_sub_title'] = true;
					//return true;
				}
				else
				{
					$_arr = explode('|',$content_add);
					$_arr1 = explode('|',$content_add_1);

					if(count($_arr1) != count($_arr))
					{
						$_arr_key_other['job_add_sub_title'] = true;
						//return true;
					}
					else
					{
						if(count(array_diff($_arr,$_arr1)) > 0)
						{
							$_arr_key_other['job_add_sub_title'] = true;
							//return true;
						}
					}
				}
			}

			else
			{
				if($key != 'm_image_id' && $key != 'job_add_sub_title' && $key != 'image_list' && $key != 'job_recruit_text' && $key != 'job_add_text' && $val != $edit_data[$key])
				{
					$_arr_key_other[$key] = true;
					//return true;
				}
			}
		}

		if(isset($edit_data['is_pickup']) && ! isset($data['is_pickup']))
			$_arr_key_other['is_pickup'] = true;

		if(isset($edit_data['is_conscription']) && ! isset($data['is_conscription']))
			$_arr_key_other['is_conscription'] = true;

		return $_arr_key_other;

	}
	public function action_index()
	{
		$data = array();
		$ujob_obj = new \Model_Ujob();
		$job_id = \Fuel\Core\Input::get('job_id','');
		$copy_job_id = \Fuel\Core\Input::get('copy_job_id','');
		$job_id_get_data = $copy_job_id ? $copy_job_id : $job_id;
		$data_default = $ujob_obj->get_info_job($job_id_get_data);

		if($data_default['job_id'] == null && $job_id)
			\Fuel\Core\Response::redirect (\Fuel\Core\Uri::base ().'job/job');

		if($copy_job_id)
			$data_default['edit_data'] = null;

		$data = $data_default;
		$data['old_data'] = $data_default;
		$data['old_data']['job_add'] = array();
		$data['old_data']['job_recruit'] = array();
		$data['old_data']['m_image'] = array();
		$data['job_add'] = array();
		$data['job_recruit'] = array();
		$data['m_image'] = array();
		$label = array(
			'group'	  => 'グループ',
			'partner' => '取引先(受注先)',
			'ss'      => 'SS',
			'sslist'  => '売上形態',
		);
		$data_filter['field'] = array(
			'step'  => 4,
			'type'  => 1,
			'label' => $label,
		);

		if(\Fuel\Core\Input::method() == 'POST')
		{
			$data_post = \Fuel\Core\Input::post();
			if( ! isset($data_post['employment_mark']))
			{
				$data_post['employment_mark'] = array();
			}

			if( ! isset($data_post['work_time_view']))
			{
				$data_post['work_time_view'] = array();
			}

			if( ! isset($data_post['trouble']))
			{
				$data_post['trouble'] = array();
			}

			$check = true;
			if( ! \Model_Sssale::find_by_pk($data_post['sssale_id']))
			{
				\Fuel\Core\Session::set_flash('report', '売上形態は存在しません');
				$check = false;
			}

			foreach($data_post['media_list'] as $k => $v)
			{
				if($v == '')
				{
					unset($data_post['media_list'][$k]);
					continue;
				}

				if( ! \Model_Mmedia::find_by_pk($v))
				{
					\Fuel\Core\Session::set_flash('report', '媒体は存在しません');
					$check = false;
					break;
				}
			}

			if($check)
				$this->save($ujob_obj, $job_id, $data_post);
		}

		if($data_default['edit_data'])
		{
			$data = json_decode($data_default['edit_data'],true);
			$data_default_edit = $ujob_obj->get_info_job('');
			$data = $data + $data_default_edit;
			$data = \Utility::set_standard_data_job($data,false);
			$ujob_obj->convert_job_add_recruit($data);
			$data['m_image'] = $ujob_obj->get_list_m_image($data['image_list']);
			/*Get old data*/
			$data['old_data'] = $data_default;
			$data['old_data']['job_add'] = $ujob_obj->get_list_job_add($job_id);
			$data['old_data']['job_recruit'] = $ujob_obj->get_list_job_recruit($job_id);
			$data['old_data']['m_image'] = $ujob_obj->get_list_m_image($data['old_data']['image_list']);
		}
		else
		{
			if($job_id_get_data)
			{
				$data['job_add'] = $ujob_obj->get_list_job_add($job_id_get_data);
				$data['job_recruit'] = $ujob_obj->get_list_job_recruit($job_id_get_data);
				$data['m_image'] = $ujob_obj->get_list_m_image($data['image_list']);
				$data['old_data']['job_add'] = $data['job_add'];
				$data['old_data']['job_recruit'] = $data['job_recruit'];
				$data['old_data']['m_image'] = $data['m_image'];
			}
		}

		$data['is_show_old'] = array();
		if($job_id)
		{
			$data['is_show_old'] = $this->_compare_other_data_json($data['old_data'],$data_default['edit_data']);
		}

		$data_filter['datafilter'] = \Presenter_Group_Filter::edit($data_filter['field']['step'],$data_filter['field']['type'],$data['sssale_id'],$data['old_data']['sssale_id']);

		$data['interview_des'] = '面接は勤務地または近隣にて行います。';
		$data['apply_method'] = '下記のフリーダイヤルまたは「応募する」ボタンより、応募シートに必要事項を入力の上、送信して下さい。※応募書類は返却致しません。ご了承ください。';
		$data['apply_process'] = '追って、こちらからご連絡差し上げます。※ご連絡は平日に致します。★ネット応募は24ｈ受付中!!';

		$this->template->title = 'UOS求人システム';
		$this->template->content = \Fuel\Core\View::forge('job/index',$data);
		$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom',$data_filter);
	}


	public function save($ujob_obj,$job_id,$data_post)
	{
		if($job_id != '' && ! \Model_Job::find_by_pk($job_id))
		{
			\Fuel\Core\Session::set_flash('report', '求人情報は存在しません');
			\Fuel\Core\Session::set_flash('class','alert-danger');
			\Fuel\Core\Response::redirect (\Fuel\Core\Uri::base ().'job/jobs');
		}

		\Fuel\Core\Session::set_flash('report',\Constants::$message_create_error);
		if($ujob_obj->save_data($data_post,$job_id) >= 0)
		{
			\Fuel\Core\Session::set_flash('class','alert-success');
			\Fuel\Core\Session::set_flash('report',  \Constants::$message_create_success);
			if(\Session::get('url_job_redirect'))
			{
				\Fuel\Core\Response::redirect(\Session::get('url_job_redirect'));
			}

			\Fuel\Core\Response::redirect (\Fuel\Core\Uri::base ().'job/jobs');
		}
	}
}

