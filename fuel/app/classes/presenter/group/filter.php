<?php

/**
 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
 * @params: Presenter_Group_Filter
 */
class Presenter_Group_Filter extends \Fuel\Core\Presenter
{
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: View groups
	 **/
	public function view()
	{

	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * @params: send data edit presenter
	 */
	public static function edit($step = null, $type = null, $id = null, $id_label = null)
	{
		$p_partner = new \Model_Mpartner();
		$p_mss = new \Model_Mss();
		$p_sssale_id = new \Model_Sssale();

		if($order_id = \Fuel\Core\Input::get('order_id') and (\Fuel\Core\Uri::current() == \Fuel\Core\Uri::base().'job/person'))
		{
			$sssale_id_order = Model_Orders::find_by_pk($order_id)->agreement_type;
			if( ! isset($order_id) or $order_id != 0)
			{
				$ss_id_order = Model_Orders::find_by_pk($order_id)->ss_id;
			}
		}

		switch ($step)
		{
		    case 2:{
				$label_arr_id = array();
				$arr_id = array();
				$arr_edit = array();
				$partner_code = $id;
				$label_partner_code = $id_label;

				if(isset($id_label))
				{
					$label_group_id = Model_Mpartner::find_by_pk($label_partner_code)->m_group_id;
					$label_arr_id = array(
						'label_m_group_id'   => $label_group_id,
						'label_partner_code' => $label_partner_code,
					);
				}

				if($m_partner = \Model_Mpartner::find_by_pk($partner_code))
				{
					$group_id = $m_partner->m_group_id;
					$arr_edit_partner = $p_partner->get_partner_group($group_id, $type);
					$arr_id = array(
						'm_group_id'   => $group_id,
						'partner_code' => $partner_code,
					);
					$arr_edit = array('edit_partner' => $arr_edit_partner);
				}

				return array_merge($arr_id, $arr_edit, $label_arr_id);
				break;
			}

		    case 3:{
				$label_arr_id = array();
				$arr_id = array();
				$arr_edit = array();
				$label_ss_id = $id_label;
				$ss_id = $id;

				if( ! isset($type) || $type == '')
					return false;

				if(isset($id_label))
				{
					$label_partner_code = \Model_Mss::find_by_pk($label_ss_id)->partner_code;
					$label_group_id = Model_Mpartner::find_by_pk($label_partner_code)->m_group_id;
					$label_arr_id = array(
						'label_ss_id'        => $label_ss_id,
						'label_m_group_id'   => $label_group_id,
						'label_partner_code' => $label_partner_code,
					);
				}

				if($m_ss = \Model_Mss::find_by_pk($ss_id) and $m_group = \Model_Mpartner::find_by_pk($m_ss->partner_code))
				{
					$partner_code = $m_ss->partner_code;
					$group_id = $m_group->m_group_id;
					$arr_edit_partner = $p_partner->get_partner_group($group_id, $type);
					$arr_edit_ss_id = $p_mss->get_ss_partner($partner_code);
					$arr_id = array(
						'ss_id'        => $ss_id,
						'partner_code' => $partner_code,
						'm_group_id'   => $group_id,
					);
					$arr_edit = array(
						'edit_partner' => $arr_edit_partner,
						'edit_ss_id'   => $arr_edit_ss_id,
					);
				}
					return array_merge($label_arr_id,$arr_id,$arr_edit);
				break;
			}
		    case 4:{
				$label_arr_id = array();
				$arr_id = array();
				$arr_edit = array();
				$sssale_id = $id;
				if( ! isset($sssale_id) and isset($sssale_id_order) and $sssale_id_order != 0)
					$sssale_id = $sssale_id_order;
				$label_sssale_id = $id_label;
				if( ! isset($type) || $type == '')
				{
					return false;
				}

				if(isset($id_label))
				{
					$label_ss_id = \Model_Sssale::find_by_pk($label_sssale_id)->ss_id;
					$label_partner_code = \Model_Mss::find_by_pk($label_ss_id)->partner_code;
					$label_group_id = Model_Mpartner::find_by_pk($label_partner_code)->m_group_id;

					$label_arr_id = array(
						'label_sssale_id'    => $label_sssale_id,
						'label_ss_id'        => $label_ss_id,
						'label_m_group_id'   => $label_group_id,
						'label_partner_code' => $label_partner_code,
					);
				}

				if($m_ss_sale = \Model_Sssale::find_by_pk($sssale_id) and $m_ss = \Model_Mss::find_by_pk($m_ss_sale->ss_id) and $m_partner = \Model_Mpartner::find_by_pk($m_ss->partner_code))
				{
					$ss_id = $m_ss_sale->ss_id;
					$partner_code = $m_ss->partner_code;
					$group_id = $m_partner->m_group_id;
					$arr_edit_partner = $p_partner->get_partner_group($group_id, $type);
					$arr_edit_ss_id = $p_mss->get_ss_partner($partner_code);
					$arr_edit_ss_sale = $p_sssale_id->get_sssale_ss($ss_id);
					$arr_id = array(
						'sssale_id'    => $sssale_id,
						'ss_id'        => $ss_id,
						'partner_code' => $partner_code,
						'm_group_id'   => $group_id,
					);
					$arr_edit = array(
						'edit_partner' => $arr_edit_partner,
						'edit_ss_id'   => $arr_edit_ss_id,
						'edit_ss_sale' => $arr_edit_ss_sale,
					);
				}
				else
				{
					if(isset($ss_id_order) and $m_ss = \Model_Mss::find_by_pk($ss_id_order) and $m_partner = \Model_Mpartner::find_by_pk($m_ss->partner_code))
					{
						$ss_id = $ss_id_order;
						$partner_code = $m_ss->partner_code;
						$group_id = $m_partner->m_group_id;
						$arr_edit_partner = $p_partner->get_partner_group($group_id, $type);
						$arr_edit_ss_id = $p_mss->get_ss_partner($partner_code);
						$arr_edit_ss_sale = $p_sssale_id->get_sssale_ss($ss_id);
						$arr_id = array(
							'sssale_id'    => $sssale_id,
							'ss_id'        => $ss_id,
							'partner_code' => $partner_code,
							'm_group_id'   => $group_id,
						);
						$arr_edit = array(
							'edit_partner' => $arr_edit_partner,
							'edit_ss_id'   => $arr_edit_ss_id,
							'edit_ss_sale' => $arr_edit_ss_sale,
						);
					}
				}

					return array_merge($label_arr_id,$arr_id,$arr_edit);
				break;
			}
		    default:
		    return false;
			break;
		}

	}
}
