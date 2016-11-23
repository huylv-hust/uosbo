<?php
class ExportPerson
{
	static public function get_info_employment($data)
	{
		$employment = new Model_Employment();
		$info = $employment->get_data_detail($data['person_id']);
		if(empty($info))
		{
			$data['no_employment'] = 1;
			return $data;
		}

		$data['employee_code'] = $info['employee_code'];
		$data['hire_date'] = str_replace('-','/',$info['hire_date']);
		return $data;
	}
	static public function get_info_emcall($data)
	{
		$emcall_obj = new Model_Emcall();
		$emcall_info = $emcall_obj->get_data(array('person_id' => $data['person_id']));
		if($total_emcall = count($emcall_info))
		{
			foreach($emcall_info as $row)
			{
				$emcall_info = (array) $row;
				$data['emcall_zipcode'][] = $emcall_info['zipcode'];
				$data['emcall_add'][] = (isset(Constants::$address_1[$emcall_info['add1']]) ? (Constants::$address_1[$emcall_info['add1']] == '全て' ? '' : Constants::$address_1[$emcall_info['add1']]) : '').$emcall_info['add2'].$emcall_info['add3'];
				$data['emcall_name'][] = $emcall_info['name'];
				$data['emcall_kana'][] = $emcall_info['name_kana'];
				$data['emcall_relationship'][] = Constants::$relationship[$emcall_info['relationship']];
				$data['emcall_tel'][] = $emcall_info['tel'];
			}
		}
		else
		{
			$data['emcall_zipcode'] = '';
			$data['emcall_add'] = '';
			$data['emcall_name'] = '';
			$data['emcall_kana'] = '';
			$data['emcall_relationship'] = '';
			$data['emcall_tel'] = '';
		}

		$data['total_emcall'] = $total_emcall;
		return $data;

	}
	static public function get_info_group($data)
	{
		$name = '';
		$branch_name = '';
		$sssale_obj = new Model_Sssale();
		$ss_obj = new Model_Mss();
		$partner_obj = new Model_Mpartner();
		$group_obj = new Model_Mgroups();
		$sssale_info = $sssale_obj->get_sssale_info($data['sssale_id']);
		$ss_id = $sssale_info['ss_id'];
		$ss_info = current($ss_obj->get_ss_info($ss_id));
		$partner_code = $ss_info['partner_code'];
		if($partner_code)
		{
			$partner_info = $partner_obj->get_list_partner('partner_code ="'.$partner_code.'"');
			$partner_info = $partner_info->as_array();
			$partner_info = current($partner_info);
			$branch_name = $partner_info['branch_name'];
			$group_id = $partner_info['m_group_id'];
			$group_info = $group_obj->get_one($group_id);
			$name = $group_info['0']['obic7_name'] ? $group_info['0']['obic7_name'] : $group_info['0']['name'];
		}

		$data['name_group'] = $name;
		$data['branch_name'] = $branch_name;
		return $data;
	}
	static public function get_info_ss($data)
	{
		$sssale_obj = new Model_Sssale();
		$ss_obj = new Model_Mss();
		$sssale_info = $sssale_obj->get_sssale_info($data['sssale_id']);
		$ss_id = $sssale_info['ss_id'];
		$ss_info = current($ss_obj->get_ss_info($ss_id));
		$data['ss_name'] = $ss_info['ss_name'];
		$data['obic7_name'] = $ss_info['obic7_name'] ? $ss_info['obic7_name'] : $ss_info['ss_name'];
		return $data;
	}
	static public function get_info_interview($data)
	{
		$interview_obj = new Model_Interviewusami();

		$interview_info = $interview_obj->get_data($data['person_id']);

		if( ! count($interview_info))
		{
			$data['no_interview'] = 1;
			return $data;
		}


		$interview_info = current($interview_info);
		$data['commuting_means'] = $interview_info['commuting_means'];
		$data['commute_dis'] = $interview_info['commute_dis'];
		$data['commuting_means_bus'] = $interview_info['commuting_means_bus'];
		$data['commuting_means_train'] = $interview_info['commuting_means_train'];
		$data['insurance_employment'] = $interview_info['insurance_employment'];
		$data['qualification_mechanic'] = $interview_info['qualification_mechanic'];
		$data['qualification'] = $interview_info['qualification'];
		$data['qualification_b'] = $interview_info['qualification_b'];
		$data['driver_license'] = $interview_info['driver_license'];
		$data['occupation'] = $interview_info['occupation'];
		$data['adoption_rank'] = $interview_info['adoption_rank'];
		$data['insurance_social'] = $interview_info['insurance_social'] == '1' ? '1' : ($interview_info['insurance_social'] == '2' ? '2' : '0');
		$data['insurance_social_number'] = $interview_info['insurance_social'] == '1' ? '1' : ($interview_info['insurance_social'] == '2' ? '0' : '');
		$data['salary_hour_wage'] = $interview_info['salary_hour_wage'];
		$data['salary_role_wage'] = $interview_info['salary_role_wage'];
		$data['salary_evaluation_wage'] = $interview_info['salary_evaluation_wage'];
		$data['salary_special_wage'] = $interview_info['salary_special_wage'];
		$data['part_type'] = $interview_info['part_type'];
		$data['qualification_mechanic_date1'] = $interview_info['qualification_mechanic_date1'];
		$data['qualification_mechanic_date2'] = $interview_info['qualification_mechanic_date2'];
		$data['qualification_mechanic_date3'] = $interview_info['qualification_mechanic_date3'];
		$data['qualification_mechanic_date4'] = $interview_info['qualification_mechanic_date4'];
		$data['qualification_mechanic_date5'] = $interview_info['qualification_mechanic_date5'];
		$data['qualification_mechanic_date6'] = $interview_info['qualification_mechanic_date6'];
		$data['driver_license_date1'] = $interview_info['driver_license_date1'];
		$data['driver_license_date2'] = $interview_info['driver_license_date2'];
		$data['driver_license_date3'] = $interview_info['driver_license_date3'];
		$data['driver_license_date4'] = $interview_info['driver_license_date4'];
		$data['driver_license_date5'] = $interview_info['driver_license_date5'];
		$data['driver_license_date6'] = $interview_info['driver_license_date6'];
		$data['driver_license_date7'] = $interview_info['driver_license_date7'];
		$data['qualification_date1'] = $interview_info['qualification_date1'];
		$data['qualification_date2'] = $interview_info['qualification_date2'];
		$data['qualification_date3'] = $interview_info['qualification_date3'];
		$data['qualification_date4'] = $interview_info['qualification_date4'];

		return $data;
	}

	static public function add_date($org_date,$mth)
	{
		$org_date = date('Y-m-01',strtotime($org_date));
		$cd = strtotime($org_date);
		$ret_day = date('Y-m-t', strtotime('+'.$mth.' months', $cd));
		return $ret_day;
	}
	static public function person_type_1($data)
	{
		$data = self::get_info_employment($data);
		return array(
			'データ区分'  => '100',
			'社員コード'  => $data['employee_code'],
			'氏名'        => $data['p_name'],
			'氏名カナ'    => mb_convert_kana($data['name_kana'],'hs'),
			'呼称適用'    => '0',
			'性別区分'    => $data['gender'] == '0' ?  1 : ($data['gender'] == 1 ? 2 : '') ,
			'生年月日'    => str_replace('-', '/', $data['birthday']),
			'入社年月日'  => $data['hire_date'],
		);
	}

	static public function person_type_2($data)
	{
		$data = self::get_info_employment(self::get_info_group($data));
		return array(
			'データ区分'			=> '200',
			'社員コード'			=> $data['employee_code'],
			'氏名'				=> $data['p_name'],
			'事業所発令日'			=> $data['hire_date'],
			'発令コード'			=> '1020',
			'稟議NO'				=> '',
			'事業所発令実施日'		=> date('Y/m/d'),
			'事業所名'			=> $data['name_group'],
			'事業所滞留継続区分'	=> '0',
			'備考'				=> '',
		);
	}
	static public function person_type_3($data)
	{
		$data = self::get_info_ss($data);
		return array(
			'データ区分'		=> '201',
			'社員コード'		=> $data['employee_code'],
			'氏名'			=> $data['p_name'],
			'事業所発令日'		=> str_replace('-', '/', $data['hire_date']),
			'発令コード'		=> '1020',
			'稟議NO'			=> '',
			'所属発令実施日'	=> date('Y/m/d'),
			'所属名'			=> $data['obic7_name'],
			'所属滞留継続区分'	=> '0',
			'備考'			=> '',
		);
	}

	static public function person_type_4($data)
	{
		$data = self::get_info_interview($data);
		if( ! isset($data['no_interview']))
		{
			return array(
				'データ区分'			=> '208',
				'社員コード'			=> $data['employee_code'],
				'氏名'				=> $data['p_name'],
				'社員区分発令日'		=> str_replace('-', '/', $data['hire_date']),
				'発令コード'			=> '1020',
				'稟議NO'				=> '',
				'社員区分発令実施日'	=> date('Y/m/d'),
				'社員区分名'			=> $data['insurance_social'] == '1' ? '契約' : ($data['insurance_social'] == '2' ? 'パートタイマー' : ''),
				'契約開始日'			=> '',
				'契約終了'			=> '',
				'備考'				=> '',
			);
		}

		return array(
			'データ区分'			=> '',
			'社員コード'			=> '',
			'氏名'				=> '',
			'社員区分発令日'		=> '',
			'発令コード'			=> '',
			'稟議NO'				=> '',
			'社員区分発令実施日'	=> '',
			'社員区分名'			=> '',
			'契約開始日'			=> '',
			'契約終了'			=> '',
			'備考'				=> '',
		);

	}
	static public function person_type_5($data)
	{
		$data = self::get_info_employment($data);
		if( ! isset($data['no_employment']))
		{
			return array(
				'データ区分'			=> '210',
				'社員コード'			=> $data['employee_code'],
				'氏名'				=> $data['p_name'],
				'社員区分発令日'		=> str_replace('-', '/', $data['hire_date']),
				'発令コード'			=> 1020,
				'稟議NO'				=> '',
				'社員区分発令実施日'	=> date('Y/m/d'),
				'職位名'				=> 'パートタイマー',
				'備考'				=> '',
			);
		}

		return array(
				'データ区分'			=> '',
				'社員コード'			=> '',
				'氏名'				=> '',
				'社員区分発令日'		=> '',
				'発令コード'			=> '',
				'稟議NO'				=> '',
				'社員区分発令実施日'	=> '',
				'職位名'				=> '',
				'備考'				=> '',
			);


	}
	static public function person_type_6($data)
	{
		$data = self::get_info_interview($data);
		if(isset($data['no_interview']))
		{
			return array(
				'データ区分'			=> '',
				'社員コード'			=> '',
				'氏名'				=> '',
				'給与区分'			=> '',
				'遡及対象フラグ'		=> '',
				'有休付与表区分'		=> '',
				'有休時期区分'			=> '',
				'保存有休有無区分'		=> '',
				'有休付与基準日'		=> '',
				'給与明細書定義番号'	=> '',
				'給与税表区分'			=> '',
				'賞与税表区分'			=> '',
				'時給計'				=> '',
				'1公2車3二'			=> '',
				'1ヶ月定期代'			=> '',
				'片道距離'			=> '',
				'回数券単価'			=> '',
				'雇保契約期間開始'		=> '',
				'雇保契約期間終了'		=> '',
				'健康保険区分'			=> '',
				'社保徴収区分'			=> '',
				'厚生年金区分'			=> '',
				'雇用保険区分'			=> '',
				'G入社日'				=> '',
				'住民税徴収区分'		=> '',
				'ランク'				=> '',
				'基本時給'			=> '',
				'役割時給'			=> '',
				'評価時給'			=> '',
				'特別時給'			=> '',
				'入社時時給'			=> '',
			);
		}

		if(substr_count($data['commuting_means'],',5,') || substr_count($data['commuting_means'],',6,'))
		{
			$data['commuting_means'] = 1;
		}
		elseif(substr_count($data['commuting_means'],',4,'))
		{
			$data['commuting_means'] = 2;
		}
		elseif(substr_count($data['commuting_means'],',3,'))
		{
			$data['commuting_means'] = 3;
		}
		else
		{
			$data['commuting_means'] = 0;
		}

		if($data['adoption_rank'] == '1')
		{
			$data['adoption_rank'] = 'マスター';
		}
		elseif($data['adoption_rank'] == '2')
		{
			$data['adoption_rank'] = 'レギュラー';
		}
		else
		{
			$data['adoption_rank'] = 'ビギナー';
		}

		return array(
			'データ区分'			=> '501',
			'社員コード'			=> $data['employee_code'],
			'氏名'				=> $data['p_name'],
			'給与区分'			=> '4',
			'遡及対象フラグ'		=> '0',
			'有休付与表区分'		=> '7',
			'有休時期区分'			=> '1',
			'保存有休有無区分'		=> '0',
			'有休付与基準日'		=> $data['hire_date'] ? substr($data['hire_date'],0,8).'01' : '',
			'給与明細書定義番号'	=> '101',
			'給与税表区分'			=> '2',
			'賞与税表区分'			=> '2',
			'時給計'				=> $data['salary_hour_wage'] + $data['salary_role_wage'] + $data['salary_evaluation_wage'] + $data['salary_special_wage'],
			'1公2車3二'			=> $data['commuting_means'],
			'1ヶ月定期代'			=> '0',
			'片道距離'			=> $data['commute_dis'] * 1000,
			'回数券単価'			=> $data['commuting_means_bus'] + $data['commuting_means_train'],
			'雇保契約期間開始'		=> $data['hire_date'],
			'雇保契約期間終了'		=> $data['hire_date'] ? self::add_date($data['hire_date'],11) : '',
			'健康保険区分'			=> $data['insurance_social_number'],
			'社保徴収区分'			=> '0',
			'厚生年金区分'			=> $data['insurance_social_number'],
			'雇用保険区分'			=> $data['insurance_employment'] == '1' ? '1' : ($data['insurance_employment'] == '2' ? '0' : ''),
			'G入社日'				=> $data['hire_date'],
			'住民税徴収区分'		=> '1',
			'ランク'				=> $data['adoption_rank'],
			'基本時給'			=> $data['salary_hour_wage'],
			'役割時給'			=> $data['salary_role_wage'],
			'評価時給'			=> $data['salary_evaluation_wage'],
			'特別時給'			=> $data['salary_special_wage'],
			'入社時時給'			=> $data['salary_hour_wage'] + $data['salary_role_wage'] + $data['salary_evaluation_wage'] + $data['salary_special_wage'],
		);
	}
	static public function person_type_7($data)
	{
		$data = self::get_info_emcall($data);
		$total_emcall = $data['total_emcall'];
		$data_emcall = array();
		if($total_emcall)
		{
			for($i = 0; $i < $total_emcall; ++$i)
			{
				$data_emcall[] = array(
					'データ区分'		=> '108',
					'社員番号'		=> $data['employee_code'],
					'緊急郵便番号'		=> $data['emcall_zipcode'][$i] ? substr($data['emcall_zipcode'][$i],0,3).'-'.substr($data['emcall_zipcode'][$i],3,4) : '',
					'緊急住所１'		=> $data['emcall_add'][$i],
					'緊急住所２'		=> '',
					'緊急連絡先名'		=> $data['emcall_name'][$i],
					'緊急連絡先名カナ' => mb_convert_kana($data['emcall_kana'][$i], 'hs'),
					'緊急連絡先関係'	=> $data['emcall_relationship'][$i],
					'緊急電話番号'		=> $data['emcall_tel'][$i],
				);
			}

		}
		else
		{
			$data_emcall[] = array(
				'データ区分'		=> '',
				'社員番号'		=> '',
				'緊急郵便番号'		=> '',
				'緊急住所１'		=> '',
				'緊急住所２'		=> '',
				'緊急連絡先名'		=> '',
				'緊急連絡先名カナ' => '',
				'緊急連絡先関係'	=> '',
				'緊急電話番号'		=> '',
			);
		}

		return $data_emcall;
	}
	static public function person_type_8($data)
	{
		return array(
			'データ区分'		=> '111',
			'社員番号'		=> $data['employee_code'],
			'入居年月日'		=> str_replace('-', '/', $data['hire_date']),
			'社員SEQ'		=> '',
			'住人票区分'		=> '',
			'世帯主区分'		=> '',
			'郵便番号'		=> isset($data['zipcode']) ? substr($data['zipcode'],0,3).'-'.substr($data['zipcode'],3,4) : '',
			'住所１'			=> (isset(Constants::$address_1[$data['addr1']]) ? Constants::$address_1[$data['addr1']] : '').$data['addr2'],
			'住所２'			=> $data['addr3'],
			'地方自治体コード'	=> '',
			'電話番号'		=> $data['mobile'] ? $data['mobile'] : $data['tel'],
			'備考'			=> '',
		);
	}
	static public function person_type_9($data)
	{
		$data = self::get_info_interview($data);
		$data = self::get_info_employment($data);
		$data_export = array();
		$data['result'] = '';
		if(isset($data['qualification_mechanic']))
		{
			if (substr_count($data['qualification_mechanic'],',1,'))
			{
				$data['result'] = '２級整備士(ガソリン)';
				$data_export[] = array(
					'データ区分'		=> '116',
					'社員番号'		=> $data['employee_code'],
					'取得年月日'		=> $data['qualification_mechanic_date1'],
					'免許資格名'		=> $data['result'],
					'社員SEQ'		=> '',
					'認定番号'		=> '',
					'有効期限'		=> '',
				);
			}

			if (substr_count($data['qualification_mechanic'],',2,'))
			{
				$data['result'] = '２級整備士(ジーゼル)';
				$data_export[] = array(
					'データ区分'		=> '116',
					'社員番号'		=> $data['employee_code'],
					'取得年月日'		=> $data['qualification_mechanic_date2'],
					'免許資格名'		=> $data['result'],
					'社員SEQ'		=> '',
					'認定番号'		=> '',
					'有効期限'		=> '',
				);
			}

			if (substr_count($data['qualification_mechanic'],',3,'))
			{
				$data['result'] = '３級整備士(ガソリン)';
				$data_export[] = array(
					'データ区分'		=> '116',
					'社員番号'		=> $data['employee_code'],
					'取得年月日'		=> $data['qualification_mechanic_date3'],
					'免許資格名'		=> $data['result'],
					'社員SEQ'		=> '',
					'認定番号'		=> '',
					'有効期限'		=> '',
				);
			}

			if (substr_count($data['qualification_mechanic'],',4,'))
			{
				$data['result'] = '３級整備士(シャーシ)';
				$data_export[] = array(
					'データ区分'		=> '116',
					'社員番号'		=> $data['employee_code'],
					'取得年月日'		=> $data['qualification_mechanic_date4'],
					'免許資格名'		=> $data['result'],
					'社員SEQ'		=> '',
					'認定番号'		=> '',
					'有効期限'		=> '',
				);
			}

			if (substr_count($data['qualification_mechanic'],',5,'))
			{
				$data['result'] = '３級整備士(ジーゼル)';
				$data_export[] = array(
					'データ区分'		=> '116',
					'社員番号'		=> $data['employee_code'],
					'取得年月日'		=> $data['qualification_mechanic_date5'],
					'免許資格名'		=> $data['result'],
					'社員SEQ'		=> '',
					'認定番号'		=> '',
					'有効期限'		=> '',
				);
			}
		}


		if (isset($data['qualification']) && substr_count($data['qualification'],',2,') && $data['qualification_b'] == '4')
		{
			$data['result'] = '危険物取扱主任者乙四';
			$data_export[] = array(
				'データ区分'		=> '116',
				'社員番号'		=> $data['employee_code'],
				'取得年月日'		=> $data['qualification_date2'],
				'免許資格名'		=> $data['result'],
				'社員SEQ'		=> '',
				'認定番号'		=> '',
				'有効期限'		=> '',
			);
		}

		if (isset($data['driver_license']) && substr_count($data['driver_license'], ',5,')) {
			$data['result'] = '原付免許';
			$data_export[] = array(
				'データ区分'		=> '116',
				'社員番号'		=> $data['employee_code'],
				'取得年月日'		=> $data['driver_license_date5'],
				'免許資格名'		=> $data['result'],
				'社員SEQ'		=> '',
				'認定番号'		=> '',
				'有効期限'		=> '',
			);
		}

		if (isset($data['driver_license']) && (substr_count($data['driver_license'], ',1,') || substr_count($data['driver_license'], ',2,')))
		{
			$driver_license_date = '';
			if(substr_count($data['driver_license'], ',1,'))
			{
				$driver_license_date = $data['driver_license_date1'];
			}
			else
			{
				$driver_license_date = $data['driver_license_date2'];
			}


			$data['result'] = '普通車免許';
			$data_export[] = array(
				'データ区分'		=> '116',
				'社員番号'		=> $data['employee_code'],
				'取得年月日'		=> $driver_license_date,
				'免許資格名'		=> $data['result'],
				'社員SEQ'		=> '',
				'認定番号'		=> '',
				'有効期限'		=> '',
			);
		}

		if(count($data_export) == 0)
		{
			$data_export[] = array(
				'データ区分'		=> '',
				'社員番号'		=> '',
				'取得年月日'		=> '',
				'免許資格名'		=> '',
				'社員SEQ'		=> '',
				'認定番号'		=> '',
				'有効期限'		=> '',
			);
		}

		return $data_export;
	}
	static public function person_type_10($data)
	{
		$data = self::get_info_interview($data);
		if( ! isset($data['no_interview']))
		{
			return array(
				'データ区分'	=> '115',
				'社員番号'	=> $data['employee_code'],
				'パート区分'	=> isset(Constants::$part_type[$data['part_type']]) ? Constants::$part_type[$data['part_type']] : '',

			);
		}

		return array(
			'データ区分'	=> '',
			'社員番号'	=> '',
			'パート区分'	=> '',

		);

	}
	static public function creat_folder($path)
	{
		if ( ! is_dir($path))
		{
           return mkdir($path,0777);
        }

		return true;
	}
	static public function get_list_file($folder)
	{
		if ( ! is_dir($folder)) {
            return false;
        }

        $list_files = scandir($folder);
        $list_files = array_diff($list_files, ['.', '..']);
		return $list_files;
	}
	static public function zip_file($arr_file = array(), $tmp_folder = '')
	{
		$array_name = array(
			'1'		=> '社員基本',
			'2'		=> '事業所',
			'3'		=> '所属',
			'4'		=> '社員区分',
			'5'		=> '職位',
			'6'		=> 'パート初期',
			'7'		=> '緊急連絡先',
			'8'		=> '住所',
			'9'		=> '免許資格',
			'10'	=> '事由項目'
		);
		$zip = new \ZipArchive();
        $tmp_file = tempnam($tmp_folder, '');
        if ($zip->open($tmp_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true)
		{
            die('An error occurred creating your ZIP file.');
        }
        //Add file in zip
        foreach ($arr_file as $type => $name_file)
		{
            $zip->addFile($name_file, date('Ymd').'_'.mb_convert_encoding($array_name[$type],'SJIS','UTF-8').'.csv');
        }

        $zip->close();
        header('Content-disposition: attachment; filename='.date('Ymd').'.zip');
        header('Content-type: application/zip');
        readfile($tmp_file);
        unlink($tmp_file);
        return true;
	}

	static public function export($rows,$type)
	{
		$function = 'person_type_'.$type;
		$contents = array();
		$tmp_fname = tempnam("/tmp", time());
		$fp = fopen($tmp_fname, "w+");
		//fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		$k = 0;
		$j = 0;
		foreach($rows as $row)
		{
			if($type == 7 || $type == 9) // emcall
			{
				$data = self::$function($row);

				foreach($data as $item)
				{
					if($j == 0)
					{
						$item_title = array_keys($item);
						$item_title = mb_convert_encoding(implode(',', $item_title),'SJIS');
						$item_title = explode(',', $item_title);
						fputcsv($fp, $item_title);
						fseek($fp, -1, SEEK_CUR);
						fwrite($fp, "\r\n");
					}

					if( ! empty(array_filter($item, 'strlen')))
					{
						$item = mb_convert_encoding(implode(',', $item),'SJIS');
						$item = explode(',', $item);
						fputcsv($fp, $item);
						fseek($fp, -1, SEEK_CUR);
						fwrite($fp, "\r\n");
					}

					++$j;
				}

			}
			else
			{
				$data = self::$function($row);
				if($k == 0)
				{
					$item = array_keys($data);
					$item = mb_convert_encoding(implode(',', $item),'SJIS');
					$item = explode(',', $item);
					fputcsv($fp, $item);
					fseek($fp, -1, SEEK_CUR);
					fwrite($fp, "\r\n");
				}

				if( ! empty(array_filter($data, 'strlen')))
				{
					$item = mb_convert_encoding(implode(',', $data),'SJIS');
					$item = explode(',', $item);
					fputcsv($fp, $item);
					fseek($fp, -1, SEEK_CUR);
					fwrite($fp, "\r\n");

				}

			}
			++$k;

		}

		fclose($fp);
		return $tmp_fname;
	}
}
