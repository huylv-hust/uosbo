<?php

class Constants
{
	static $address_1 = array(
		''   => '全て',
		'1'  => '北海道',
		'2'  => '青森県',
		'3'  => '岩手県',
		'4'  => '宮城県',
		'5'  => '秋田県',
		'6'  => '山形県',
		'7'  => '福島県',
		'8'  => '茨城県',
		'9'  => '栃木県',
		'10' => '群馬県',
		'11' => '埼玉県',
		'12' => '千葉県',
		'13' => '東京都',
		'14' => '神奈川県',
		'15' => '新潟県',
		'16' => '富山県',
		'17' => '石川県',
		'18' => '福井県',
		'19' => '山梨県',
		'20' => '長野県',
		'21' => '岐阜県',
		'22' => '静岡県',
		'23' => '愛知県',
		'24' => '三重県',
		'25' => '滋賀県',
		'26' => '京都府',
		'27' => '大阪府',
		'28' => '兵庫県',
		'29' => '奈良県',
		'30' => '和歌山県',
		'31' => '鳥取県',
		'32' => '島根県',
		'33' => '岡山県',
		'34' => '広島県',
		'35' => '山口県',
		'36' => '徳島県',
		'37' => '香川県',
		'38' => '愛媛県',
		'39' => '高知県',
		'40' => '福岡県',
		'41' => '佐賀県',
		'42' => '長崎県',
		'43' => '熊本県',
		'44' => '大分県',
		'45' => '宮崎県',
		'46' => '鹿児島県',
		'47' => '沖縄県',
	);

	static function get_search_address()
	{
		return array('' => '全て') + self::$address_1;
	}
	static function get_create_address()
	{
		return array('' => '都道府県を選択して下さい') + self::$address_1;
	}

	static $sale_type = array(
		''  => '',
		'1' => '直接雇用',
		'2' => '職業紹介',
		'3' => '派遣',
		'4' => '紹介予定派遣',
		'5' => '請負',
		'6' => '求人代行',
		//'7' => '有料職業紹介',
	);

	static function get_search_sale_type()
	{
		return array('' => '全て') + self::$sale_type;
	}

	static $hours = array(
		''   => '00',
		'01' => '01',
		'02' => '02',
		'03' => '03',
		'04' => '04',
		'05' => '05',
		'06' => '06',
		'07' => '07',
		'08' => '08',
		'09' => '09',
		'10' => '10',
		'11' => '11',
		'12' => '12',
		'13' => '13',
		'14' => '14',
		'15' => '15',
		'16' => '16',
		'17' => '17',
		'18' => '18',
		'19' => '19',
		'20' => '20',
		'21' => '21',
		'22' => '22',
		'23' => '23',
	);

	static $minutes = array(
		''   => '00',
		'05' => '05',
		'10' => '10',
		'15' => '15',
		'20' => '20',
		'25' => '25',
		'30' => '30',
		'35' => '35',
		'40' => '40',
		'45' => '45',
		'50' => '50',
		'55' => '55',
	);

	static $media_classification = array(
		''   => '',
		'1'  => 'CM',
		'2'  => 'web',
		'3'  => 'うさ',
		'4'  => '折込',
		'5'  => '学ポ',
		'6'  => '学校',
		'7'  => '公共',
		'8'  => '冊子',
		'9'  => '紹介',
		'10' => 'その他',
		'11' => '転籍',
		'12' => '店チ',
		'13' => '店テ',
		'14' => '店頭',
		'15' => '店の',
		'16' => '店ポ',
		'17' => '店看',
		'18' => '店レ',
		'19' => '登録',
		'20' => '不明',
	);

	public static function get_search_media_classification()
	{
		return array('' => '全て') + self::$media_classification;
	}

	public static function get_create_media_classification()
	{
		return array('' => '') + self::$media_classification;
	}

	static $employment_type = array(
		''  => '',
		'1' => '派遣',
		'2' => '契約社員',
		'3' => '正社員',
		'4' => '業務委託',
		'5' => '有料職業紹介',
		'6' => '代理店・FC',
		'7' => 'アルバイト',
		'8' => 'パート',
		'9' => '紹介予定派遣',
	);

	static $occupation = array(
		''   => '',
		'1'  => '事務職関連職種',
		'2'  => '専門的職種',
		'3'  => '営業関連職種',
		'4'  => '販売関連職種',
		'5'  => 'フード関連職種',
		'6'  => 'アルコール主体職種・FC',
		'7'  => 'ファーストフーード関連職種',
		'8'  => '運輸・物流関連職種',
		'9'  => '現場作業関連職種',
		'10' => 'サービス関連職種',
		'11' => '芸能関連職種',
		'12' => '紹介職種',
		'13' => '派遣職種',
		'14' => 'その他',
	);

	static $trouble = array(
		'1'  => '駅チカ･駅ナカ',
		'2'  => '車・バイクOK',
		'3'  => '未経験OK',
		'4'  => '大学生歓迎',
		'5'  => 'まかない・食事',
		'6'  => '服装自由',
		'7'  => '高校生可',
		'8'  => '髪型自由',
		'9'  => '日払い・週払い',
		'10' => '土日祝日のみ',
		'11' => '即日勤務OK',
		'12' => 'フリーター歓迎',
		'13' => '高収入',
		'14' => '英語を使う',
		'15' => '主婦・主夫歓迎',
		'16' => '副業OK',
		'17' => '運転免許なし',
		'18' => '女性活躍',
		'19' => 'セルフ希望',
		'20' => 'フルサービス希望',
		'21' => '深夜限定',
		'22' => '短期OK',
		'23' => '交通費支給',
		'24' => 'シフト制',
		'25' => '社員登用あり',
		'26' => 'オープニング',
	);

	static $trouble4recruit = array(
		'26', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '23', '24', '25'
	);

	static $employment_mark = array(
		'1' => '派',
		'2' => '契',
		'3' => '社',
		'4' => '委',
		'5' => '紹',
		'6' => '代',
		'7' => 'A',
		'8' => 'P',
	);
	static $work_time_view = array(
		'1' => '朝（7～12）',
		'2' => '昼（12～17）',
		'3' => '夕方・夜（17～22）',
		'4' => '深夜・早朝（22～7）',
	);
	static $salary_type = array(
		''   => '',
		'1'  => '時給',
		'2'  => '日給',
		'3'  => '月給',
		'4'  => '一勤務制',
		'5'  => '時給＋歩合',
		'6'  => '日給＋歩合',
		'7'  => '月給＋歩合',
		'8'  => '一勤務＋歩合',
		'9'  => '完全歩合制',
		'10' => 'その他',
	);
	static $employment_people = array(
		''  => '',
		'1' => '1～5名',
		'2' => '5～10名',
		'3' => '10名以上',
		'4' => '20名以上',
		'5' => '非公開',
		'6' => '未定',
		'7' => '人数入力',
	);
	static $work_period = array(
		''   => '',
		'1'  => '半日以内',
		'2'  => '1日以内',
		'3'  => '3日以内',
		'4'  => '5日以内',
		'5'  => '10日以内',
		'6'  => '1ヶ月以内',
		'7'  => '2ヶ月以内',
		'8'  => '3ヶ月以内',
		'9'  => '3ヶ月以上',
		'10' => '6ヶ月以上',
		'11' => '1年以上',
		'12' => '勤務期間項目を表示しない',
		'13' => '空白',
	);

	static $department = array(
		'100' => '本社',
		'201' => '事業部',
		'203' => '求人チーム',
		'210' => '東北営業所',
		'211' => '東北営業所（北海道駐在所）',
		'220' => '上信越営業所',
		'230' => '東京営業所',
		'240' => '東海営業所',
		'241' => '東海営業所（中部駐在所）',
		'242' => '東海営業所（北陸駐在所）',
		'250' => '関西営業所',
		'260' => '山陽営業所',
		'270' => '九州営業所',
	);

	static function get_search_department($title = false)
	{
		if($title)
		{
			return array('' => $title) + self::$department;
		}

		return array('' => '全て') + self::$department;
	}

	static function get_create_department()
	{
		return array('' => '部門を選択して下さい') + self::$department;
	}
	 static $plan_between_date = array(
		 'month' => '10',
		 'day'   => '1',
	 );

	static $_status_partner = array(
		'approval' => '0',
		'pending'  => '1',
	);

	static $_status_person = array(
		'approval' => '1',
		'pending'  => '0',
	);

	static $_type_partner = array(
		''  => '全て',
		'1' => '受注先',
		'2' => '発注先',
	);

	static $occupation_now = array(
		'0'  => '',
		'1'  => '高校生',
		'2'  => '通信学生',
		'3'  => '専門学生',
		'4'  => '大学生',
		'5'  => '正社員',
		'6'  => '契約社員',
		'7'  => 'パート/アルバイト',
		'8'  => '派遣',
		'9'  => '自営',
		'10' => '主婦（夫）',
		'11' => '無職',
		'12' => 'その他',
	);
	public static $url_loged = '/';

	public static $num_links = 10;
	static $default_limit_pagination = 10;
	static $default_num_links = 5;

	static $message_create_success = '保存しました';
	static $message_create_error = '保存に失敗しました。';
	static $message_delete_success = '削除しました。';
	static $message_delete_error = '削除に失敗しました';
	static $message_approval_success = '承認しました。';
	static $message_approval_error = '承認に失敗しました。';

	static $order_status = array(
		'unapproved'  => 0,  //未承認
		'nonapproved' => -1, //非承認
		'approved'    => 1,  //承認済
		'confirmed'   => 2,  //確定
		'stop'        => 3,  //停止
	);
	static $order_status_lable = array(
		'0'  => '未承認',  //未承認
		'-1' => '非承認', //
		'1'  => '承認済',  //承認済
		'2'  => '確定',  //確定
		'3'  => '停止',  //
	);

	static $order_status_class = array(
		'0'  => 'danger',  //未承認
		'-1' => 'default', // 非承認
		'1'  => 'info',  //承認済
		'2'  => 'success',  //確定
		'3'  => 'warning',  //
	);

	static $job_public_type = array(
		'1' => 'UOS',
		'8' => '宇佐美',
	);
	static $job_work_location_display_type = array(
		'1' => 'カセット式',
		'2' => 'テキスト',
	);
	static $job_is_apply_by_mobile = array(
		'1' => '利用する',
		'2' => '利用しない',
	);
	static $job_is_web_receipt = array(
		'1' => '利用する',
		'2' => '利用しない',
	);

	static $media_type = array(
		''  => '全て',
		'1' => '自力',
		'2' => '他力',
	);

	static $division_type = array(
		'1' => '管理者',
		'2' => '承認者',
		'3' => '一般',
		'4' => '宇佐美鉱油',
	);

	public static $person_licenses = array(
		'1' => array(
			'1' => '普自MT', '2' => '普自AT', '3' => '大型', '4' => '原付', ' 5' => '二輪小', '6' => '二輪中', '7' => '二輪大'
		),
		'2' => array(
			'1' => '危険物 丙種', '2' => '危険物 乙4', '3' => '危険物 乙他', '4' => '危険物 甲種', '5' => '高圧ガス責任者'
		),
		'3' => array(
			'1' => '3級シャシ', '2' => '3級ガソリン', ' 3' => '3級ディーゼル', '4' => '2級ガソリン', '5' => '2級ディーゼル', '6' => '自動車検査員'
		)
	);

	static $_status_save = array(
		'save_error'   => '0',
		'save_success' => '1',
		'value_exist'  => '-2',
		'id_not_exist' => '-1',
	);

	static $_personfile = array(
		'1' => array('免許証(表)' => 1),
		'2' => array('学生証' => 1),
		'3' => array('銀行口座通帳' => 1),
		'4' => array('自賠責' => 1),
		'5' => array('任意保険' => 1)
	);

	public static function list_year()
	{
		$list_year = array('' => '選択');
		for($i = 2000; $i >= 1940; $i--)
		{
			$list_year[$i] = $i;
		}

		return $list_year;
	}

	public static function list_year_jp()
	{
		$list_year = self::list_year();
		foreach ($list_year as $year => $val)
		{
			if (strlen($year) > 0)
			{
				$list_year[$year] = self::to_jp_date($year);
			}
		}

		return $list_year;
	}

	public static function list_month()
	{
		$list_month = array('' => '選択');
		for($i = 1; $i <= 12; $i++)
		{
			$month = $i < 10 ? '0'.$i : $i;
			$list_month[$month] = $month;
		}

		return $list_month;
	}

	public static function list_day()
	{
		$list_day = array('' => '選択');
		for($i = 1; $i <= 31; $i++)
		{
			$day = $i < 10 ? '0'.$i : $i;
			$list_day[$day] = $day;
		}

		return $list_day;
	}

	static $_contact_result = array(
		'0' => '未済',
		'1'	=> '済',
		'2' => '不通',
	);

	static $_review_result = array(
		'0'  => '未済',
		'1'  => '済',
		'2'  => '不来',
		'3'  => '辞退',
		'4'  => '条件断り',
		'5'  => '無資格',
		'6'  => '態度',
		'7'  => '定員',
		'8'  => '他断り',
		'9'  => '条件辞退',
		'10' => '他辞退',
		'11' => '若年',
		'12' => '定年',
		'13' => '髪',
	);

	static $_adoption_result = array(
		'0' => '未決',
		'1'	=> '採用',
		'2' => '不採用',
		'3' => '登録',
	);

	static $_rank = array(
		'0' => '--',
		'1'	=> 'A',
		'2' => 'B',
		'3' => 'ブラック',
	);

	static $_contract_result = array(
		'0' => '未済',
		'1'	=> '済',
		'2' => '不来',
		'3' => '辞退',
	);

	static $_work_confirmation = array(
		'0' => '未済',
		'1'	=> '済',
		'2' => '不来',
		'3' => '辞退',
	);

	static $_classification = array(
		'0' => '--',
		'1'	=> 'UOS',
		'2' => '宇佐美',
		'3' => 'その他',
	);

	static $_commuting_means = array(
		'1' => '徒歩',
		'2' => '自転車',
		'3' => 'バイク',
		'4' => '車',
		'5' => 'バス',
		'6' => '電車',
	);

	static $_ss_match = array(
		'1' => '給油',
		'2' => '軽整備',
		'3' => '販売',
		'4' => 'SSC操作',
		'91' => '事務職',
		'99' => 'その他',
	);

	static $_day_in_week = array(
		'1' => '月曜日',
		'2' => '火曜日',
		'3' => '水曜日',
		'4' => '木曜日',
		'5' => '金曜日',
		'6' => '土曜日',
		'7' => '日・祝',
	);

	public static function to_jp_date($year,$month = 1,$day = 1)
	{
		if( ! checkdate($month, $day, $year) || $year < 1800)
		{
			return false;
		}

		$date = (int) sprintf('%04d%02d%02d', $year, $month, $day);
		if($date >= 19890108)
		{
			$era = '平成';
			$jp_year = $year - 1988;
		}

		elseif($date >= 19261225)
		{
			$era = '昭和';
			$jp_year = $year - 1925;
		}

		elseif($date >= 19120730)
		{
			$era = '大正';
			$jp_year = $year - 1911;
		}

		elseif($date >= 18680125)
		{
			$era = '明治';
			$jp_year = $year - 1867;
		}

		elseif($date >= 18650407)
		{
			$era = '慶応';
			$jp_year = $year - 1864;
		}

		elseif ($date >= 18640220)
		{
			$era = '元治';
			$jp_year = $year - 1863;
		}

		elseif ($date >= 18610219)
		{
		$era = '文久';
		$jp_year = $year - 1860;
		}

		elseif ($date >= 18600318)
		{
			$era = '万延';
			$jp_year = $year - 1859;
		}

		elseif ($date >= 18541127)
		{
			$era = '安政';
			$jp_year = $year - 1853;
		}

		elseif ($date >= 18480228)
		{
			$era = '嘉永';
			$jp_year = $year - 1847;
		}

		elseif ($date >= 18441202)
		{
			$era = '弘化';
			$jp_year = $year - 1843;
		}

		elseif ($date >= 18301210)
		{
			$era = '天保';
			$jp_year = $year - 1829;
		}

		elseif($date >= 18180422)
		{
			$era = '文政';
			$jp_year = $year - 1817;
		}

		elseif($date >= 18040211)
		{
			$era = '文化';
			$jp_year = $year - 1803;
		}

		elseif ($date >= 18010205)
		{
			$era = '享和';
			$jp_year = $year - 1800;
		}

		else
		{
		  $era = '寛政';
		  $jp_year = $year - 1789;
		}

		$wareki = null;
		if ($jp_year == 1)
		{
			$wareki = $year.'年 '.'（'.$era.'元年'.'）';
		}

		else
		{
			$wareki = $year.'年 '.'（'.$era.$jp_year.'年'.'）';
		}

		return $wareki;
	}

	static $_driver_license = array(
		'1' => '普通MT',
		'2' => '普通AT',
		'3' => '大型免許',
		'4' => '原付',
		'5' => '自動二輪(小型)',
		'6' => '自動二輪(中型)',
		'7' => '自動二輪(大型)',
	);

	static $_qualification = array(
		'1' => '丙',
		'2' => '乙',
		'3' => '甲',
		'4' => '高圧ガス第1種販売責任者',
	);

	static $_qualification_b = array(
		''  => '',
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
	);

	static $_qualification_mechanic = array(
		'1' => '２級整備士(ガソリン)',
		'2' => '２級整備士(ジーゼル)',
		'3' => '３級整備士(ガソリン)',
		'4' => '３級整備士(シャーシ)',
		'5' => '３級整備士(ジーゼル)',
		'6' => '自動車検査員',
	);

	static $_pc_skills = array(
		'1' => 'EXCEL',
		'2' => 'WORD',
		'3' => '他',
	);

	static $_occupation_interview = array(
		''   => '',
		'1'  => '学生(昼間・高校)',
		'2'  => '学生(昼間・通信)',
		'3'  => '学生(昼間・大学)',
		'4'  => '学生(夜間・高校)',
		'5'  => '学生(夜間・通信)',
		'6'  => '学生(夜間・大学)',
		'7'  => 'フリーター',
		'8'  => 'パート',
		'9'  => '主婦(夫)',
		'10' => '会社員',
		'11' => '自営業',
		'12' => '無職',
	);

	static $_adoption_person_type = array(
		'1' => '採用',
		'2' => '上記内容を修正し了承後採用',
		'3' => '不採用 ',
		'4' => '面接キャンセル',
		'5' => '辞退',
		'6' => '登録',
	);

	static $_income_tax = array(
		'1' => '収入は、宇佐美が主である。(*1)',
		'2' => '他から収入があるが、宇佐美が主である。(*1)',
		'3' => '他から収入があり、他が主である。(*2)',
		'4' => '自営業である。(*2)',
		'5' => '確定申告を予定している。(*2)',
	);

	static $bank_type = array(
		''  => '選択してください',
		'1' => '総合',
		'2' => '普通',
		'3' => '当座',
	);

	static $transportation = array(
		'0' => '徒歩',
		'1' => '自転車',
		'2' => 'バイク',
		'3' => '車',
		'4' => 'バス',
		'5' => '電車',
	);

	static $work_type = array(
		'0' => '日中',
		'1' => '夕方',
		'2' => '夜間',
	);

	static $media_budget_type = array(
		'1' => '求人費',
		'2' => '販促費',
	);

	static $is_web_reprint = array(
		'1' => 'あり',
		'0' => 'なし',
	);

	static $order_title = array(
		'オーダーID',
		'取引先グループ',
		'取引先',
		'SS',
		'部門',
		'部門コード',
		'営業担当',
		'売上形態',
		'申請日',
		'掲載日',
		'自他区分',
		'予算区分',
		'分類',
		'WEB転載',
		'媒体ID',
		'媒体名',
		'版名',
		'掲載枠名称',
		'発注先',
		'金額',
		'本数(小計)',
		'備考',
	);
	static $part_type = array(
		'' => '',
		'1' => 'Ｗワーカー',
		'2' => '外国人',
		'3' => '外国人（Ｗワーカー）',
		'4' => '外国人（学生）',
		'5' => '外国人（定・通）',
		'6' => '学生',
		'7' => '学生（定・通）',
		'8' => '定年再雇用',
	);

	static $relationship = array(
		''   => '',
		'1'  => 'おじ',
		'2'  => 'おば',
		'3'  => 'その他',
		'4'  => '義父',
		'5'  => '義母',
		'6'  => '兄弟',
		'7'  => '姉妹',
		'8'  => '子（女）',
		'9'  => '子（男）',
		'10' => '祖父母',
		'11' => '配偶者',
		'12' => '父',
		'13' => '母',
	);
}

