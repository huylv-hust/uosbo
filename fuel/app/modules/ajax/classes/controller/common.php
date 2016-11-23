<?php

/**
 * List function
 *
 * @author NamDD <namdd6566@seta-asia.com.vn>
 * @date 2/06/2015
 */
namespace Ajax;
use Fuel\Core\Input;
use Fuel\Core\Model;
use Fuel\Core\Session;

class Controller_Common extends \Controller_Uosbo
{
	/**
	 * @author NamDD <namdd6566@seta-asia.com.vn>
	 * get info car
	 * @return \Response
	 */
	public function action_get_ss()
	{
		$group_id = null;
		$partner_code = null;
		if (\Fuel\Core\Input::method() == 'POST')
		{
			$group_id = \Fuel\Core\Input::post('group_id', null);
			$partner_code = \Fuel\Core\Input::post('partner_code', null);
		}
		else
		{
			$group_id = \Fuel\Core\Input::get('group_id', null);
			$partner_code = \Fuel\Core\Input::get('partner_code', null);
		}

		$data = (new \Model_Mss())->get_data(array(
			'group_id' => $group_id,
			'partner_code' => $partner_code
		))->as_array();

		$res = array();
		if (count($data))
		{
			$i = 0;
			foreach($data as $row)
			{
				$res[$i]['ss_id'] = $row->ss_id;
				$res[$i]['ss_name'] = $row->ss_name;
				++$i;
			}
		}

		return new \Response(json_encode($res), 200,array());
	}

	public function action_approved()
	{
		$job_obj = new \Model_Job();
		$job_id = \Fuel\Core\Input::post('job_id');
		$status = \Fuel\Core\Input::post('status');
		$res = $job_obj->approve_data($job_id);
		Session::set_flash('class','alert-danger');
		if($res === true)
		{
			\Fuel\Core\Session::set_flash('report', '承認しました。');
			Session::set_flash('class','alert-success');
		}

		elseif($res === 0)
			\Fuel\Core\Session::set_flash ('report','登録データが正しくありません');
		else
			\Fuel\Core\Session::set_flash ('report','承認に失敗しました。');

		return new \Response($res, 200,array());

	}
	public function active_deletejob()
	{
		$job_obj = new \Model_Job();
		$person = new \Model_Person();
		$job_id = \Fuel\Core\Input::post('job_id');
		$check_data = $person->get_filter_person(['job_id'=>$job_id]);
		if(count($check_data))
		{
			\Fuel\Core\Session::set_flash ('report','関連する応募者データが存在するため削除できません');
			return new \Response($check_data, 200,array());
		}
		$res = $job_obj->delete_data($job_id);
		if($res){
			\Fuel\Core\Session::set_flash('report', '削除しました。');
		}
		else{
			\Fuel\Core\Session::set_flash('report', '削除に失敗しました。');
		}

		return new \Response($res, 200,array());
	}

	public function action_available()
	{
		$job_obj = new \Model_Job();
		$job_id = \Fuel\Core\Input::post('job_id');
		$is_available = \Fuel\Core\Input::post('is_available');
		$data = array('is_available' => $is_available);

		$res = $job_obj->save_data($data, $job_id);
		\Fuel\Core\Session::set_flash ('report','承認に失敗しました。');
		if($res)
		{
			\Fuel\Core\Session::set_flash ('report', $is_available == 0 ? '非公開しました' : '公開しました');
		}

		return new \Response($res, 200,array());
	}

    public function action_webtoku()
    {
        $job_obj = new \Model_Job();
        $job_id = \Fuel\Core\Input::post('job_id');
        $is_webtoku = \Fuel\Core\Input::post('is_webtoku');
        $data = array('is_webtoku' => $is_webtoku);

        $res = $job_obj->save_data($data, $job_id);
        \Fuel\Core\Session::set_flash ('report','失敗しました。');
        if($res)
        {
            \Fuel\Core\Session::set_flash ('report', $is_webtoku == 0 ? 'WEB得OFFにしました' : 'WEB得ONにしました');
        }

        return new \Response($res, 200,array());
    }

	public function action_upload_img()
	{
		$order_id = \Fuel\Core\Input::post('order_id');
		$model_order = \Model_Orders::find_by_pk($order_id);
		if( ! $model_order)
		{
			return 'failed';
		}

		$data = array(
			'image_content' => base64_decode(\Fuel\Core\Input::post('content_image', null)),
			'width'		    => \Fuel\Core\Input::post('width', null),
			'height'        => \Fuel\Core\Input::post('height', null),
			'mine_type'     => \Fuel\Core\Input::post('mine_type', null),
		);

		$obj_order = new \Model_Orders();
		if($res = $obj_order->order_update($data, $order_id))
		{
			\Fuel\Core\Session::set_flash ('success','媒体画像を登録しました。');
		}
		else
		{
			\Fuel\Core\Session::set_flash ('error','媒体画像登録は失敗しました。');
		}

		return new \Response($res, 200,array());
	}
	public function action_get_m_ss_access()
	{
		$ss_id = \Fuel\Core\Input::post('ss_id');
		$model_ss = new \Model_Mss();
		$info_ss = $model_ss->get_ss_info($ss_id);
		return new \Response($info_ss['0']['access'], 200,array());

	}

	public function action_get_partners()
	{
		$group_id = \Fuel\Core\Input::get('group_id');
		$type = \Fuel\Core\Input::get('type');
		$model_partner = new \Model_Mpartner();
		$partners = $model_partner->get_filter_partner(array('group_id' => $group_id, 'type' => $type));

		$response = array();
		foreach ($partners as $partner)
		{
			$response[$partner['partner_code']] = $partner;
		}

		return new \Response(json_encode($response), 200,array());
	}

	public function get_employee_code()
	{
		$person_id = \Fuel\Core\Input::get('person_id');
		$model_employment = new \Model_Employment();

		$response = array();

		try
		{
			$response['code'] = $model_employment->get_new_code($person_id);
		}
		catch (\Exception $ex)
		{
			$response['code'] = null;
			$response['error'] = $ex->getMessage();
		}

		return new \Response(json_encode($response), 200,array());
	}
}
