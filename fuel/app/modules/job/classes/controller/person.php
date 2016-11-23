<?php
namespace Job;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Uri;
use JsonSchema\Uri\UriResolver;
use Model\Person;
use Model\Job;
use Model\Orders;
use Fuel\Core\Session;
use Fuel\Core\Response;
use Oil\Exception;


/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Person extends \Controller_Uosbo
{


	/**
	 * @author NamNT
	 * action index
	 */
	public function action_index()
	{
		$data   = array();
		$is_view = array();
		$model = new \Model_Person();
		$employment = new \Model_Employment();
		$model_job = new \Model_Job();
		$model_order = new \Model_Orders();
		$model_user = new \Model_Muser();
		$sssale_id = null;
		$sssale_id_view = null;
		$order_id = null;
		$post_id = null;

		$data['person_info'] = null;
		$data['edit_person'] = null;
		$data['post_id'] = null;
		$data['job_id'] = $model_job->get_list_id();
		$data['person_id'] = (\Input::get('person_id'));
		$data['listusers_interview'] = array();
		$data['listusers_agreement'] = array();
		$data['listusers_training'] = array();
		$data['listusers_business'] = array();

		if((\Input::get('order_id')))
		{
			$order_id = \Input::get('order_id');
			$od = $model_order->get_order_info($order_id);
			$post_id = $od['post_id'];
			$data['post_id'] = $post_id;

			$data['order'] = $od;
			$data['order']['listusers_interview'] = array();
			$data['order']['listusers_agreement'] = array();
			$data['order']['listusers_training'] = array();
			$data['order']['interview_department_id'] = '';
			$data['order']['agreement_department_id'] = '';
			$data['order']['training_department_id'] = '';
			$data['order'] = $model_user->get_user_info_path($od['interview_user_id'],'interview',$data['order']);
			$data['order'] = $model_user->get_user_info_path($od['agreement_user_id'],'agreement',$data['order']);
			$data['order'] = $model_user->get_user_info_path($od['training_user_id'],'training',$data['order']);
		}

		if((\Input::get('person_id')))
		{
			$person_info = \Model_Person::find(\Input::get('person_id'));
			$data['edit_person'] = $person_info;
			$data['edit_person']['interview_department_id'] = '';
			$data['edit_person']['agreement_department_id'] = '';
			$data['edit_person']['training_department_id'] = '';
			$data['edit_person']['business_department_id'] = '';
			$data['edit_person']['listusers_interview'] = array();
			$data['edit_person']['listusers_agreement'] = array();
			$data['edit_person']['listusers_training'] = array();
			$data['edit_person']['listusers_business'] = array();
			$data['edit_person'] = $model_user->get_user_info_path($person_info->interview_user_id,'interview',$data['edit_person']);
			$data['edit_person'] = $model_user->get_user_info_path($person_info->agreement_user_id,'agreement',$data['edit_person']);
			$data['edit_person'] = $model_user->get_user_info_path($person_info->training_user_id,'training',$data['edit_person']);
			$data['edit_person'] = $model_user->get_user_info_path($person_info->business_user_id,'business',$data['edit_person']);
			$data['person_info'] = $data['edit_person'];

			if($edit_data = $person_info->edit_data)
			{
				$person_info['application_date'] = substr($person_info['application_date'],0,16);
				$data['edit_person'] = json_decode($edit_data,true);
				$data['edit_person']['interview_user_id'] = isset($data['edit_person']['interview_user_id']) ? $data['edit_person']['interview_user_id'] : '';
				$data['edit_person']['agreement_user_id'] = isset($data['edit_person']['agreement_user_id']) ? $data['edit_person']['agreement_user_id'] : '';
				$data['edit_person']['training_user_id'] = isset($data['edit_person']['training_user_id']) ? $data['edit_person']['training_user_id'] : '';
				$data['edit_person']['business_user_id'] = isset($data['edit_person']['business_user_id']) ? $data['edit_person']['business_user_id'] : '';
				$data['edit_person']['interview_department_id'] = '';
				$data['edit_person']['agreement_department_id'] = '';
				$data['edit_person']['business_department_id'] = '';
				$data['edit_person']['training_department_id'] = '';
				$data['edit_person']['listusers_interview'] = array();
				$data['edit_person']['listusers_agreement'] = array();
				$data['edit_person']['listusers_training'] = array();
				$data['edit_person']['listusers_business'] = array();
				$data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['interview_user_id'],'interview',$data['edit_person']);
				$data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['agreement_user_id'],'agreement',$data['edit_person']);
				$data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['training_user_id'],'training',$data['edit_person']);
				$data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['business_user_id'],'business',$data['edit_person']);
				$data['is_view'] = \Utility::compare_json_data($person_info,$edit_data);
			}
		}
		$data_filter['field'] = array(
				'step'	=> 4,
				'type'	=> 1,
				'label' => array(
					'group'   => 'グループ',
					'partner' => '取引先(受注先)',
					'ss'      => 'SS',
					'sslist'  => '売上形態'
				)
		);
		if($data['edit_person'])
			$sssale_id = $data['edit_person']['sssale_id'];
		if($data['person_info'])
			$sssale_id_view = $data['person_info']['sssale_id'];

		$data_filter['datafilter'] = \Presenter_Group_Filter::edit($data_filter['field']['step'],$data_filter['field']['type'],$sssale_id, $sssale_id_view);

		if(\Input::method() == 'POST')
		{
			$datas = array();
			$dataPost = \Input::post();
			$datas = $model->get_person_data($dataPost);

			$action = 'add';

			foreach(\Input::post() as $key => $value)
			{
				if(\Input::post($key) == '')
				{
					$datas[$key] = null;
				}
			}

			if( ! \Model_Sssale::find_by_pk($datas['sssale_id']))
			{
				Session::set_flash('error', '売上形態は存在しません');
			}
			else
			{
				if((\Input::get('person_id')))
				{
					$action = 'edit';
					if( ! $model = $model->find(\Input::get('person_id')))
					{
						Session::set_flash('error', '応募者は存在しません');
						Response::redirect('job/persons');
					}

					$model->status = \Constants::$_status_person['pending'];
					$data_temp = Input::post();
					if( ! $data_temp['business_user_id'])
						$data_temp['business_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);

					if( ! $data_temp['interview_user_id'])
						$data_temp['interview_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);

					if( ! $data_temp['agreement_user_id'])
						$data_temp['agreement_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);


					$model->edit_data = json_encode($model->get_person_data($data_temp));
					if($model->save())
					{
						Session::set_flash('success', \Constants::$message_create_success);
						Response::redirect(Uri::base().'job/persons');
					}
				}
				else
				{
					$datas['created_at'] = date('Y-m-d H:i:s');
					if( ! $datas['business_user_id'])
					{
						$datas['business_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
					}

					if( ! $datas['interview_user_id'])
					{
						$datas['interview_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
					}

					if( ! $datas['agreement_user_id'])
					{
						$datas['agreement_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
					}

					$model->set($datas);
					if ($model->save())
					{
						if ($action == 'add')
						{
							$person_obj = $model->find($model->person_id);
							$sssale_id_mail = $person_obj->sssale_id != '' ? $person_obj->sssale_id : 0;
							$person_data = $model->get_data_for_mail($sssale_id_mail);
							if (count($person_data))
							{
								//send mail
								$model_user = new \Model_Muser();
								$department_id = ($person_data['0']['department_id']) ? $person_data['0']['department_id'] : 0;
								$list_email_department = $model_user->get_list_mail_department($department_id);
								$datamail_department = array(
									'm_group'     => isset($person_data['0']['name']) ? $person_data['0']['name'] : '',
									'branch_name' => isset($person_data['0']['branch_name']) ? $person_data['0']['branch_name'] : '',
									'ss_name'     => isset($person_data['0']['ss_name']) ? $person_data['0']['ss_name'] : '',
									'sale_name'   => isset($person_data['0']['sale_name']) ? $person_data['0']['sale_name'] : '',
									'list_emails' => $list_email_department,
									'last_id'     => $model->person_id,
								);

								$model->sendmail_department($datamail_department);
							}
						}

						Session::set_flash('success', \Constants::$message_create_success);
					}
					else
					{
						Session::set_flash('error', \Constants::$message_create_error);
					}
				}
			}

			if(\Fuel\Core\Cookie::get('person_url'))
			{
				Response::redirect(\Fuel\Core\Cookie::get('person_url'));
			}
			else
			{
				Response::redirect('job/persons');
			}
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('persons/person',$data);
		$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom',$data_filter);

	}

	/**
	 * @author Thuanth6589
	 * @return Response
	 */
	public function action_check_order()
	{
		$order_id = Input::post('order_id', 0);
		$result = array('message' => false);
		if(\Model_Orders::find_by_pk($order_id))
			$result = array('message' => true);
		return Response::forge(json_encode($result));
	}

	public function action_approval()
	{
		if($value = Input::post())
		{
			$person = new \Model_Person();
			$person_id = $value['person_id'];
			if($person->approval_person($person_id))
			{
				$return = 'success';
				$messege = \Constants::$message_approval_success;
			}
			else
			{
				$return = 'error';
				$messege = \Constants::$message_approval_error;
			}
			Session::set_flash($return, $messege);
			Response::redirect(Uri::base().'job/persons?'.\Session::get('url_filter_persons'));
		}
		Response::redirect(Uri::base().'job/persons');
	}
	public function get_default_business_user_id($sssale_id)
	{
		$business_user_id = 0 ;
		$sssale_obj = new \Model_Sssale();
		$ss_obj = new \Model_Mss();
		$partner_obj = new \Model_Mpartner();
		$sssale_info = $sssale_obj->get_sssale_info($sssale_id);
		$ss_id = $sssale_info['ss_id'];
		$ss_info = current($ss_obj->get_ss_info($ss_id));
		$partner_code = $ss_info['partner_code'];
		if($partner_code)
		{
			$partner_info = $partner_obj->get_list_partner('partner_code ="'.$partner_code.'"');
			$partner_info = $partner_info->as_array();
			$partner_info = current($partner_info);
			$business_user_id = $partner_info['user_id'];
		}

		return $business_user_id;
	}
}