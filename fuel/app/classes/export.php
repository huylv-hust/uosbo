<?php
class Export
{

	public function field_json()
	{
	}

	static public function get_field_json($key,$arr_json = array())
	{
		if(isset($arr_json[$key]))
			return $arr_json[$key];

		return '';
	}

	static public function field($data)
	{
		$model_add = new Model_Jobadd();
		$model_rec = new Model_Jobrecruit();
		$arr_json = array();
		$arr_phone_number = array();
		$arr_db = $data;
		if(isset($arr_db['csv']))
			$arr_json = json_decode($arr_db['csv'],true);
		if(isset($arr_db['phone_number1']))
			$arr_phone_number = explode(',',trim($arr_db['phone_number1'],','));

		$config_add['where'][] = array(
			'job_id',
			'=',
			$arr_db['job_id'],
		);
		$list_add = $model_add->get_list_data($config_add);

		$config_rec['where'][] = array(
			'job_id',
			'=',
			$arr_db['job_id'],
		);
		$arr_add = array();
		$arr_rec = array();
		$i = 0;
		foreach($list_add as $row)
		{
			$arr_add[$i]['sub_title'] = $row['sub_title'];
			$arr_add[$i]['text'] = $row['text'];
			++$i;
		}

		$arr_add = array_pad($arr_add,4,array('sub_title' => '', 'text' => ''));

		$list_rec = $model_rec->get_list_data($config_rec);
		$i = 0;
		foreach($list_rec as $row)
		{
			$arr_rec[$i]['sub_title'] = $row['sub_title'];
			$arr_rec[$i]['text'] = $row['text'];
			++$i;
		}

		$arr_rec = array_pad($arr_rec,9,array('sub_title' => '', 'text' => ''));

		$arr_employment_mark = array();

		foreach(Constants::$employment_mark as $key => $val)
		{
			if(substr_count($arr_db['employment_mark'],','.$key.','))
			{
				$arr_employment_mark[] = '['.$val.']';
			}
		}

		$arr_employment_mark = array_pad($arr_employment_mark,6,'');

        /*Get m.group_name,ss_name*/
        $arr_db['sale_name'] = '';
        $arr_db['base_code'] = '';
        $arr_db['ss_name'] = '';
        $arr_db['group_name'] = '';
        if($arr_db['sssale_id'])
        {
            $sssale = Model_Sssale::find_by_pk($arr_db['sssale_id']);
            $arr_db['sale_name'] = Constants::$sale_type[$sssale['sale_type']];
        }

        if($arr_db['ss_id'])
        {
            $ss = Model_Mss::find_by_pk($arr_db['ss_id']);
            $arr_db['base_code'] = $ss['base_code'];
            $arr_db['ss_name'] = $ss['ss_name'];
            $partner = Model_Mpartner::find_by_pk($ss['partner_code']);
            $group = Model_Mgroups::find_by_pk($partner['m_group_id']);
            $arr_db['group_name'] = $group['name'];
            $arr_db['lat'] = $ss['lat'];
            $arr_db['lon'] = $ss['lon'];
        }

		$def = ' ';
		$trouble_check = '●';

		return array(
			'No'								=> $def,
			'WEB得＆HP'							=> self::get_field_json('WEB得＆HP',$arr_json),
			'自由入力②'							=> $arr_db['base_code'],
			'自由入力③'							=> self::get_field_json('自由入力③',$arr_json),
			'自由入力④'							=> self::get_field_json('自由入力④',$arr_json),
			'自由入力⑤'							=> $arr_db['job_id'],
			'◆HOPE進行No'						=> self::get_field_json('◆HOPE進行No',$arr_json),
			'●商品CD'							=> self::get_field_json('●商品CD',$arr_json),
			'●掲載開始号CD'						=> self::get_field_json('●掲載開始号CD',$arr_json),
			'●制作企画CD'						=> self::get_field_json('●制作企画CD',$arr_json),
			'●明細CD'							=> self::get_field_json('●明細CD',$arr_json),
			'▲メモ'								=> self::get_field_json('▲メモ',$arr_json),
			'文字_1'								=> $def,
			'●営業担当CD'						=> self::get_field_json('●営業担当CD',$arr_json),
			'●制作担当CD'						=> self::get_field_json('●制作担当CD',$arr_json),
			'●受注先顧客コード'					=> self::get_field_json('●受注先顧客コード',$arr_json),
			'●掲載先顧客コード'					=> self::get_field_json('●掲載先顧客コード',$arr_json),
			'●掲載社名'							=> $arr_db['post_company_name'],
			'文字_2'								=> $def,
			'▲ホームページリンク'				=> $arr_db['url_home_page'],
			'▲郵便番号'							=> $arr_db['zipcode'],
			'●掲載住所'							=> $arr_db['location'],
			'文字_3'								=> $def,
			'●交通'								=> $arr_db['traffic'],
			'文字_4'								=> $def,
			'店舗名（紹介の場合）'				=> $arr_db['store_name'],
			'●勤務地 表示方式CD'					=> Constants::$job_work_location_display_type[$arr_db['work_location_display_type']],
			'勤務地 （派遣・契約の場合）'			=> $arr_db['work_location'],
			'文字_50'							=> $def,
			'▲勤務地カセット式タイトル'			=> $arr_db['work_location_title'],
			'文字_5'								=> $def,
			'▲（勤）地図補足'					=> self::get_field_json('▲（勤）地図補足',$arr_json),
			'文字_6'								=> $def,
			'●雇用形態CD'						=> Constants::$employment_type[(string)$arr_db['employment_type']],
			'雇用形態マーク※プルダウンで選択_1'	=> $arr_employment_mark['0'],
			'雇用形態マーク※プルダウンで選択_2'	=> $arr_employment_mark['1'],
			'雇用形態マーク※プルダウンで選択_3'	=> $arr_employment_mark['2'],
			'雇用形態マーク※プルダウンで選択_4'	=> $arr_employment_mark['3'],
			'雇用形態マーク※プルダウンで選択_5'	=> $arr_employment_mark['4'],
			'雇用形態マーク※プルダウンで選択_6'	=> $arr_employment_mark['5'],
			'職種'								=> $arr_db['job_category'],
			'文字_7'								=> $def,
			'●職種CD　大項目'						=> self::get_field_json('●職種CD　大項目',$arr_json),
			'●職種CD　小項目'					=> isset(Occupation::$rows[$arr_db['occupation']]) ? Occupation::$rows[$arr_db['occupation']]['name'] : '',
			'FAナビ検索職種(大)'					=> self::get_field_json('FAナビ検索職種(大)',$arr_json),
			'FAナビ検索職種(小)'					=> self::get_field_json('FAナビ検索職種(小)',$arr_json),
			'●給与形態CD'						=> Constants::$salary_type[$arr_db['salary_type'] == 0 ? '' : $arr_db['salary_type']],
			'●給与'								=> $arr_db['salary_des'],
			'文字_8'								=> $def,
			'◆最低給与金額'						=> $arr_db['salary_min'],
			'●キャッチ'							=> $arr_db['catch_copy'],
			'文字_9'								=> $def,
			'●リード'							=> $arr_db['lead'],
			'文字_10'							=> $def,
			'◆勤務時間帯 朝（7～12）'			=> substr_count($arr_db['work_time_view'],',1,') ? '表示' : '表示しない' ,
			'◆勤務時間帯 昼（12～17）'			=> substr_count($arr_db['work_time_view'],',2,') ? '表示' : '表示しない' ,
			'◆勤務時間帯 夕方・夜（17～22）'		=> substr_count($arr_db['work_time_view'],',3,') ? '表示' : '表示しない' ,
			'◆勤務時間帯 深夜・早朝（22～7）'	=> substr_count($arr_db['work_time_view'],',4,') ? '表示' : '表示しない' ,
			'▲週あたり最低勤務日数'				=> (int)$arr_db['work_day_week'].'日',
			'●勤務曜日・時間'					=> $arr_db['work_time_des'],
			'文字_11'							=> $def,
			'▲資格'								=> $arr_db['qualification'],
			'文字_12'							=> $def,
			'●採用予定人数CD'					=> Constants::$employment_people[$arr_db['employment_people'] == 0 ? '' : $arr_db['employment_people']],
			'◆採用予定人数指定'					=> $arr_db['employment_people_num'],
			'▲採用予定人数本文'					=> $arr_db['employment_people_des'],
			'文字_13'							=> $def,
			'●勤務期間CD'						=> Constants::$work_period[$arr_db['work_period'] == 0 ? '' : $arr_db['work_period']],
			'▲勤務期間本文_入力欄'				=> self::get_field_json('▲勤務期間本文_入力欄',$arr_json),
			'紹介予定派遣の場合'					=> $arr_db['employment_type'] == '9' ? '※紹介予定派遣は派遣先と本人の同意が得られた場合のみ紹介/派遣期間：最長6ヵ月' : '' ,
			'▲勤務期間本文＋紹介予定派遣'			=> self::get_field_json('▲勤務期間本文＋紹介予定派遣',$arr_json),
			'文字_14'							=> $def,
			'▲募集追加（1）見出し'				=> $arr_rec['0']['sub_title'],
			'文字_15'							=> $def,
			'待遇'								=> $arr_rec['0']['text'],
			'文字_16'							=> $def,
			'▲募集追加（2）見出し'				=> $arr_rec['1']['sub_title'],
			'文字_17'							=> $def,
			'◆募集追加（2）本文'					=> $arr_rec['1']['text'],
			'文字_18'							=> $def,
			'▲募集追加（3）見出し'				=> $arr_rec['2']['sub_title'],
			'文字_19'							=> $def,
			'◆募集追加（3）本文'					=> $arr_rec['2']['text'],
			'文字_20'							=> $def,
			'▲募集追加（4）見出し'				=> $arr_rec['3']['sub_title'],
			'文字_21'							=> $def,
			'◆募集追加（4）本文'					=> $arr_rec['3']['text'],
			'文字_22'							=> $def,
			'▲募集追加（5）見出し'				=> $arr_rec['4']['sub_title'],
			'文字_23'							=> $def,
			'◆募集追加（5）本文'					=> $arr_rec['4']['text'],
			'文字_24'							=> $def,
			'▲募集追加（6）見出し'				=> $arr_rec['5']['sub_title'],
			'文字_25'							=> $def,
			'◆募集追加（6）本文'					=> $arr_rec['5']['text'],
			'文字_26'							=> $def,
			'▲募集追加（7）見出し'				=> $arr_rec['6']['sub_title'],
			'文字_27'							=> $def,
			'◆募集追加（7）本文'					=> $arr_rec['6']['text'],
			'文字_28'							=> $def,
			'▲募集追加（8）見出し'				=> $arr_rec['7']['sub_title'],
			'文字_29'							=> $def,
			'◆募集追加（8）本文'					=> $arr_rec['7']['text'],
			'文字_30'							=> $def,
			'▲募集追加（9）見出し'				=> $arr_rec['8']['sub_title'],
			'文字_31'							=> $def,
			'◆募集追加（9）本文'					=> $arr_rec['8']['text'],
			'文字_32'							=> $def,
			'募集情報合計行数'					=> $def,
			'●仕事内容'							=> $arr_db['job_description'],
			'文字_33'							=> $def,
			'▲仕事追加（1）見出し'				=> $arr_add['0']['sub_title'],
			'文字_34'							=> $def,
			'◆仕事追加（1）本文'					=> $arr_add['0']['text'],
			'文字_35'							=> $def,
			'▲仕事追加（2）見出し'				=> $arr_add['1']['sub_title'],
			'文字_36'							=> $def,
			'◆仕事追加（2）本文'					=> $arr_add['1']['text'],
			'文字'								=> $def,
			'▲仕事追加（3）見出し'				=> $arr_add['2']['sub_title'],
			'文字_51'							=> $def,
			'◆仕事追加（3）本文'					=> $arr_add['2']['text'],
			'文字_37'							=> $def,
			'▲仕事追加（4）見出し'				=> $arr_add['3']['sub_title'],
			'文字_38'							=> $def,
			'◆仕事追加（4）本文'					=> $arr_add['3']['text'],
			'文字_39'							=> $def,
			'仕事情報合計行数'					=> $def,
			'●事業内容'							=> $arr_db['business_description'],
			'文字_40'							=> $def,
			'▲面接地・他タイトル'				=> self::get_field_json('▲面接地・他タイトル',$arr_json),
			'文字_41'							=> $def,
			'面接地'								=> $arr_db['interview_location'],
			'▲（面）地図補足'					=> self::get_field_json('▲（面）地図補足',$arr_json),
			'文字_42'							=> $def,
			'●応募方法'							=> self::get_field_json('●応募方法',$arr_json),
			'●応募後のプロセス'					=> self::get_field_json('●応募後のプロセス',$arr_json),
			'文字_43'							=> $def,
			'◆携帯版電話応募ボタンCD'			=> self::get_field_json('◆携帯版電話応募ボタンCD',$arr_json),
			'●代表電話（1）名称'					=> $arr_db['phone_name1'],
			'文字_44'							=> $def,
			'●代表電話（1）（市外局番）'			=> isset($arr_phone_number['0']) ? (string)$arr_phone_number['0'] : '',
			'●代表電話（1）（市内局番）'			=> isset($arr_phone_number['1']) ? (string)$arr_phone_number['1'] : '',
			'●代表電話（1）（加入者番号）'		=> isset($arr_phone_number['2']) ? (string)$arr_phone_number['2'] : '',
			'▲代表電話（2）名称'					=> self::get_field_json('▲代表電話（2）名称',$arr_json),
			'文字_45'							=> $def,
			'▲代表電話（2）（市外局番）'			=> self::get_field_json('▲代表電話（2）（市外局番）',$arr_json),
			'◆代表電話（2）（市内局番）'			=> self::get_field_json('◆代表電話（2）（市内局番）',$arr_json),
			'◆代表電話（2）（加入者番号）'		=> self::get_field_json('◆代表電話（2）（加入者番号）',$arr_json),
			'▲問合せ補足'						=> self::get_field_json('▲問合せ補足',$arr_json),
			'文字_46'							=> $def,
			'●WEB応募受付CD'					=> self::get_field_json('●WEB応募受付CD',$arr_json),
			'応募先'								=> self::get_field_json('応募先',$arr_json),
			'◆応募シートタイプCD'				=> self::get_field_json('◆応募シートタイプCD',$arr_json),
			'▲応募シート自由質問'				=> self::get_field_json('▲応募シート自由質問',$arr_json),
			'文字_47'							=> $def,
			'◆自動返信メールCD'					=> self::get_field_json('◆自動返信メールCD',$arr_json),
			'◆自動返信メール件名'				=> self::get_field_json('◆自動返信メール件名',$arr_json),
			'文字_48'							=> $def,
			'◆自動返信メール本文'				=> self::get_field_json('◆自動返信メール本文',$arr_json),
			'文字_49'							=> $def,
            '単発・1日OK'                         => substr_count($arr_db['trouble'],',onday,') ? $trouble_check :  '',
            '短期'                                => substr_count($arr_db['trouble'],',short,') ? $trouble_check :  '',
            '長期歓迎'                            => substr_count($arr_db['trouble'],',long,') ? $trouble_check :  '',
            '春・夏・冬休み期間限定'               => substr_count($arr_db['trouble'],',vacation,') ? $trouble_check :  '',
            '日払い'                              => substr_count($arr_db['trouble'],',daily,') ? $trouble_check :  '',
            '週払い'                              => substr_count($arr_db['trouble'],',weekly,') ? $trouble_check :  '',
            '高収入・高額'                        => substr_count($arr_db['trouble'],',earns,') ? $trouble_check :  '',
            '扶養内勤務OK'                        => substr_count($arr_db['trouble'],',support,') ? $trouble_check :  '',
            '給与前払いOK'                        => substr_count($arr_db['trouble'],',prepay,') ? $trouble_check :  '',
            '高校生応援'                          => substr_count($arr_db['trouble'],',school,') ? $trouble_check :  '',
            '大学生歓迎'                          => substr_count($arr_db['trouble'],',college,') ? $trouble_check :  '',
            '主婦･主夫歓迎'                       => substr_count($arr_db['trouble'],',housewife,') ? $trouble_check :  '',
            '未経験・初心者OK'                     => substr_count($arr_db['trouble'],',beginner,') ? $trouble_check :  '',
            '経験者・有資格者歓迎'                 => substr_count($arr_db['trouble'],',skillful,') ? $trouble_check :  '',
            '副業・WワークOK'                      => substr_count($arr_db['trouble'],',doublework,') ? $trouble_check :  '',
            'ミドル活躍中'                         => substr_count($arr_db['trouble'],',middle,') ? $trouble_check :  '',
            'シニア応援'                           => substr_count($arr_db['trouble'],',senior,') ? $trouble_check :  '',
            '学歴不問'                             => substr_count($arr_db['trouble'],',education,') ? $trouble_check :  '',
            '留学生歓迎'                           => substr_count($arr_db['trouble'],',international,') ? $trouble_check :  '',
            'フリーター歓迎'                       => substr_count($arr_db['trouble'],',free,') ? $trouble_check :  '',
            'ブランクOK'                           => substr_count($arr_db['trouble'],',blank,') ? $trouble_check :  '',
            '時間や曜日が選べる・シフト自由'        => substr_count($arr_db['trouble'],',choice,') ? $trouble_check :  '',
            'シフト制'                             => substr_count($arr_db['trouble'],',shiftsys,') ? $trouble_check :  '',
            '平日のみOK'                           => substr_count($arr_db['trouble'],',weekday,') ? $trouble_check :  '',
            '土日祝のみOK'                         => substr_count($arr_db['trouble'],',weekend,') ? $trouble_check :  '',
            '週1日からOK'                          => substr_count($arr_db['trouble'],',week1,') ? $trouble_check :  '',
            '週2、3日からOK'                       => substr_count($arr_db['trouble'],',week2,') ? $trouble_check :  '',
            '週4日以上OK'                          => substr_count($arr_db['trouble'],',week4,') ? $trouble_check :  '',
            '早朝・朝の仕事'                       => substr_count($arr_db['trouble'],',morning,') ? $trouble_check :  '',
            '昼からの仕事'                         => substr_count($arr_db['trouble'],',noon,') ? $trouble_check :  '',
            '夕方からの仕事'                       => substr_count($arr_db['trouble'],',afternoon,') ? $trouble_check :  '',
            '夜からの仕事'                         => substr_count($arr_db['trouble'],',evening,') ? $trouble_check :  '',
            '深夜・夜勤の仕事'                     => substr_count($arr_db['trouble'],',night,') ? $trouble_check :  '',
            '短時間勤務(1日4h以内)'                => substr_count($arr_db['trouble'],',shorttime,') ? $trouble_check :  '',
            'フルタイム歓迎'                       => substr_count($arr_db['trouble'],',fulltime,') ? $trouble_check :  '',
            '時間固定シフト制'                     => substr_count($arr_db['trouble'],',fixedtime,') ? $trouble_check :  '',
            '交通費支給'                          => substr_count($arr_db['trouble'],',transportation,') ? $trouble_check :  '',
            'まかない・食事補助あり'               => substr_count($arr_db['trouble'],',food,') ? $trouble_check :  '',
            '寮・社宅・住宅手当あり'               => substr_count($arr_db['trouble'],',house,') ? $trouble_check :  '',
            '資格取得支援制度'                     => substr_count($arr_db['trouble'],',license,') ? $trouble_check :  '',
            'ボーナス・賞与あり'                   => substr_count($arr_db['trouble'],',bonus,') ? $trouble_check :  '',
            '社員登用あり'                        => substr_count($arr_db['trouble'],',employment,') ? $trouble_check :  '',
            '社割あり'                            => substr_count($arr_db['trouble'],',discount,') ? $trouble_check :  '',
            '送迎あり'                            => substr_count($arr_db['trouble'],',shuttle,') ? $trouble_check :  '',
            '産休・育休制度実績あり'               => substr_count($arr_db['trouble'],',maternity,') ? $trouble_check :  '',
            '長期休暇あり'                        => substr_count($arr_db['trouble'],',longvacation,') ? $trouble_check :  '',
            '髪型・髪色自由'                      => substr_count($arr_db['trouble'],',hair,') ? $trouble_check :  '',
            'オープニングスタッフ'                 => substr_count($arr_db['trouble'],',openning,') ? $trouble_check :  '',
            '英語が活かせる'                      => substr_count($arr_db['trouble'],',english,') ? $trouble_check :  '',
            '車通勤OK'                            => substr_count($arr_db['trouble'],',car,') ? $trouble_check :  '',
            'バイク通勤OK'                        => substr_count($arr_db['trouble'],',bike,') ? $trouble_check :  '',
            '服装自由'                            => substr_count($arr_db['trouble'],',fashion,') ? $trouble_check :  '',
            'リゾート'                            => substr_count($arr_db['trouble'],',resort,') ? $trouble_check :  '',
            '在宅'                                => substr_count($arr_db['trouble'],',homework,') ? $trouble_check :  '',
            '髭・ネイル・ピアスOK'                 => substr_count($arr_db['trouble'],',nail,') ? $trouble_check :  '',
            '制服あり'                            => substr_count($arr_db['trouble'],',uniform,') ? $trouble_check :  '',
            '託児所あり'                          => substr_count($arr_db['trouble'],',child,') ? $trouble_check :  '',
            '駅チカ･駅ナカ'                       => substr_count($arr_db['trouble'],',nearstation,') ? $trouble_check :  '',
            '残業なし'                            => substr_count($arr_db['trouble'],',overtime,') ? $trouble_check :  '',
            '研修あり'                            => substr_count($arr_db['trouble'],',training,') ? $trouble_check :  '',
            '履歴書不要'                          => substr_count($arr_db['trouble'],',resume,') ? $trouble_check :  '',
            '入社祝い金支給'                      => substr_count($arr_db['trouble'],',money,') ? $trouble_check :  '',
            '友達と応募OK'                        => substr_count($arr_db['trouble'],',friend,') ? $trouble_check :  '',
            '即日勤務OK'                          => substr_count($arr_db['trouble'],',now,') ? $trouble_check :  '',
            '無期雇用派遣'                        => substr_count($arr_db['trouble'],',tempstaff,') ? $trouble_check :  '',
            'こだわり条件数'                      => $def,
            '●プレビューアクセス番号（市外局番）'   => self::get_field_json('プレビューアクセス番号（市外局番）',$arr_json),
            '●プレビューアクセス番号（市内局番）'   => self::get_field_json('●プレビューアクセス番号（市内局番）',$arr_json),
            '●プレビューアクセス番号（加入者番号）' => self::get_field_json('●プレビューアクセス番号（加入者番号）',$arr_json),
            '運転免許なしOK'                      => substr_count($arr_db['trouble'],',no_licenses,') ? $trouble_check :  '',
            '女性活躍中'                          => substr_count($arr_db['trouble'],',female,') ? $trouble_check :  '',
            'セルフSS希望'                        => substr_count($arr_db['trouble'],',self,') ? $trouble_check :  '',
            'フルサービスSS希望'                  => substr_count($arr_db['trouble'],',full,') ? $trouble_check :  '',
            '会社名'                              => $arr_db['group_name'],
            'SS名'                                => $arr_db['ss_name'],
            '勤務形態'                            => $arr_db['sale_name'],
            '緯度'                                => $arr_db['lat'],
            '経度'                                => $arr_db['lon'],
		);
	}

	static public function person_field($data)
	{
		$model_post = new Model_Mpost();
		$model_order = new Model_Orders();
		$model_media = new Model_Mmedia();
		$model_user = new Model_Muser();
		$model_partner = new Model_Mpartner();
		$cl_23 = '';
		$p_l_1 = '';
		$p_l_2 = '';
		$p_l_3 = '';
		$w_t   = '';

		if($data['order_id'] != null)
		{
			$cl_3 = 'オーダー';
		}
		elseif ($data['job_id'] != null)
		{
			$cl_3 = '求人情報';
		}
		else
		{
			$cl_3 = 'その他';
		}

		$arr_media_id = array();
		$arr_media_name = array();
		//$arr_sales_user_id = array();
		$config_post['where'][] = array(
			'post_id',
			'=',
			$data['post_id'],
		);

		$list_media_id = $model_post->get_list_data($config_post);
		foreach($list_media_id as $row)
		{
			$arr_media_id = $row['m_media_id'];
		}
		$media_name = $model_media->get_media_name($arr_media_id);

		foreach($media_name as $row)
		{
			$arr_media_name = $row['media_name'];
		}

		$u_name = '';
		$t_name = '';
		$i_name = '';
		$business_user_name = $model_user->get_user_name($data['business_user_id']);
		if(count($business_user_name))
		{
			$u_name= $business_user_name['0']['name'];
		}

		$interview_user_name = $model_user->get_user_name($data['interview_user_id']);
		if(count($interview_user_name))
		{
			$i_name= $interview_user_name['0']['name'];
		}

		$training_user_name = $model_user->get_user_name($data['training_user_id']);
		if(count($training_user_name))
		{
			$t_name= $training_user_name['0']['name'];
		}

		$transportation = explode(',',$data['transportation']);
		foreach($transportation as $key => $value)
		{
			if(isset(\Constants::$transportation[$value]))
			$cl_23 .= \Constants::$transportation[$value].'、';
		}
		$cl_23 = rtrim($cl_23,'、');

		$license1 = explode(',',$data['license1']);
		foreach($license1 as $key => $value)
		{
			if(isset(\Constants::$person_licenses[1][$value]))
			$p_l_1 .= \Constants::$person_licenses[1][$value].'、';
		}
		$p_l_1 = rtrim($p_l_1,'、');

		$license2 = explode(',',$data['license2']);
		foreach($license2 as $key => $value)
		{
			if(isset(\Constants::$person_licenses[2][$value]))
			$p_l_2 .= \Constants::$person_licenses[2][$value].'、';
		}
		$p_l_2 = rtrim($p_l_2,'、');

		$license3 = explode(',',$data['license3']);
		foreach($license3 as $key => $value)
		{
			if(isset(\Constants::$person_licenses[3][$value]))
			$p_l_3 .= \Constants::$person_licenses[3][$value].'、';
		}
		$p_l_3 = rtrim($p_l_3,'、');

		$work_type = explode(',',$data['work_type']);
		foreach($work_type as $key => $value)
		{
			if(isset(\Constants::$work_type[$value]))
			$w_t .= \Constants::$work_type[$value].'、';
		}
		$w_t = rtrim($w_t,'、');
		if($data['application_date'] != null)
		{
			$application_date = date_create($data['application_date']);
			$a_d = date_format($application_date,"Y-m-d");
		}
		else
		{
			$a_d = '';
		}
		$data['is_failure_existence'] == 1 ? $is_failure_existence = 'あり' : $is_failure_existence = 'なし';
		$data['is_country'] == 1 ? $is_country = '○' : $is_country = '空欄';
		return array(
			'応募者ID' => $data['person_id'],
			'応募日時' => $a_d,
			'実績区分' => $cl_3,
			'オーダーID' => $data['order_id'],
			'求人情報ID' => $data['job_id'],
			'媒体' => count($arr_media_name) !== 0 ? $arr_media_name : '',
			'氏名' => $data['p_name'],
			'ふりがな' => $data['name_kana'],
			'生年月日' => $data['birthday'],
			'応募時年齢' => $data['age'] ? $data['age'] : self::birthday($data['birthday'],''),
			'現在年齢' => self::birthday($data['birthday'],$data['application_date']),
			'性別' => $data['gender'] != null ? $data['gender'] == 0 ? '男':'女' :'',
			'郵便番号' => $data['zipcode'],
			'都道府県' => $data['addr1'] ? \Constants::$address_1[$data['addr1']] : '',
			'市区町村' => $data['addr2'],
			'以降の住所' => $data['addr3'],
			'携帯電話' => $data['mobile'],
			'固定電話' => $data['tel'],
			'メールアドレス1' => $data['mail_addr1'],
			'メールアドレス2' => $data['mail_addr2'],
			'現在職業' => \Constants::$occupation_now[$data['occupation_now']],
			'現在職業補足' => $data['repletion'],
			'交通手段' => $cl_23,
			'通勤時間' => $data['walk_time'],
			'保有資格1' => $p_l_1,
			'保有資格2' => $p_l_2,
			'保有資格3' => $p_l_3,
			'勤務可能時間帯'	=> $w_t,
			'就業可能時期' => $data['employment_time'],
			'健康状態' => $data['health'],
			'障害有無' => $is_failure_existence,
			'障害部位' => $data['failure_existence'],
			'国籍（外国籍' => $is_country,
			'国籍・会話など' => $data['country'],
			'メモ1' => $data['memo_1'],
			'メモ2' => $data['memo_2'],
			'取引先グループ' => $data['g_name'],
			'取引先' => $data['branch_name'],
			'SS' => $data['ss_name'],
			'営業所' => isset(\Constants::$department[$data['department_id']]) ? \Constants::$department[$data['department_id']] :'',
			'部門コード' => $data['department_id'],
			'売上形態' => isset(\Constants::$sale_type[$data['sale_type']]) ? \Constants::$sale_type[$data['sale_type']] :'',
			'連絡結果' => isset(\Constants::$_contact_result[$data['contact_result']]) ? \Constants::$_contact_result[$data['contact_result']]:'',
			'面接日' => $data['review_date'],
			'面接結果' => isset(\Constants::$_review_result[$data['review_result']]) ? \Constants::$_review_result[$data['review_result']]:'',
			'採否結果' => isset(\Constants::$_adoption_result[$data['adoption_result']]) ? \Constants::$_adoption_result[$data['adoption_result']]:'',
			'登録有効期限' => $data['registration_expiration'],
			'登録ランク' => isset(\Constants::$_rank[$data['rank']]) ? \Constants::$_rank[$data['rank']]:'',
			'登録更新日' => $data['register_date'],
			'契約締結日' => $data['contract_date'],
			'契約結果' => isset(\Constants::$_contract_result[$data['contract_result']]) ? \Constants::$_contract_result[$data['contract_result']]:'',
			'入社日' => $data['hire_date'],
			'勤務確認' => isset(\Constants::$_work_confirmation[$data['work_confirmation']]) ? \Constants::$_work_confirmation[$data['work_confirmation']]:'',
			'社員コード' => $data['employee_code'],
			'社員コード登録日' => $data['code_registration_date'],
			'営業担当者' => $u_name,
			'面接担当者' => $i_name,
			'研修担当者' => $t_name,
		);

	}
	static public function birthday($bithdayDate,$n)
	{
		$date = new DateTime($bithdayDate);
		if($n == '')
		{
			$now = new DateTime();
		}
		else
		{
			$now = new DateTime($n);
		}
		$interval = $now->diff($date);
		return $interval->y ? $interval->y : '';
	}
}
