<?php

/**
 * Append ss list
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 10/10/2015
 */

class Presenter_Group_Ss extends Presenter
{
	/**
	* Start append ss list
	*
	* @author Ha Huu Don<donhh6551@seta-asia.com.vn>
	* @date 16/09/2015
	*/
	public function view()
	{
		$model_group = new \Model_Mgroups();
		$model_ss = new Model_Mss();
		$model_partner = new \Model_Mpartner();
		$data['listgroup1'] = array();
		$list_partner1 = $model_partner->get_list_by_type();
		if($list_partner1)
		{
			$data['listgroup1'] = $model_group->get_list_by_partner($list_partner1);
		}

		$data['listss'] = array();
		$data['listpartner'] = array();
		$ss_id = $this->ss_id;
		$data['ss_id_selected'] = 0;
		$data['partner_code_selected'] = 0;
		$data['group_id_selected'] = 0;
		$partner_code = 0;
		$group_id = 0;

		if($ss_id)
		{
			$ss_info = $model_ss->find_by_pk($ss_id);
			if($ss_info)
			{
				$partner_code = $ss_info['partner_code'];
			}

			if($partner_code)
			{
				$partner_info = $model_partner->find_by_pk($partner_code);
				if($partner_info)
				{
					$group_id = $partner_info['m_group_id'];
					$data['listpartner'] = $model_partner->get_partner_group($group_id, 1);
				}

				$config['where'] = array('partner_code' => $partner_code);
				$data['listss'] = $model_ss->find($config);
			}
		}

		$data['stt_selected'] = $this->stt;
		$data['ss_id_selected'] = $ss_id;
		$data['partner_code_selected'] = $partner_code;
		$data['group_id_selected'] = $group_id;
		$this->data = $data;
	}
}
