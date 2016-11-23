<?php
class Import
{
	public $error = array();
	public $no_update = array();
	public static $not_exits = 'X';
	function __construct()
	{
	}
	public function get_errors()
	{
		return $this->error;
	}

	static public function field_json($data)
	{
		return array(
			'No',
			'WEB得＆HP',
			'自由入力②',
			'自由入力③',
			'自由入力④',
			'◆HOPE進行No',
			'●商品CD',
			'●掲載開始号CD',
			'●制作企画CD',
			'●明細CD',
			'▲メモ',
			'●営業担当CD',
			'●制作担当CD',
			'●受注先顧客コード',
			'●掲載先顧客コード',
			'▲（勤）地図補足',
			'●職種CD　小項目',
			'FAナビ検索職種(大)',
			'FAナビ検索職種(小)',
			'▲勤務期間本文_入力欄',
			'▲勤務期間本文＋紹介予定派遣',
			'募集情報合計行数',
			'仕事情報合計行数',
			'▲（面）地図補足',
			'●応募方法',
			'●応募後のプロセス',
			'◆携帯版電話応募ボタンCD',
			'▲代表電話（2）名称',
			'▲代表電話（2）（市外局番）',
			'◆代表電話（2）（市内局番）',
			'◆代表電話（2）（加入者番号）',
			'▲問合せ補足',
			'●WEB応募受付CD',
			'応募先',
			'◆応募シートタイプCD',
			'▲応募シート自由質問',
			'◆自動返信メールCD',
			'◆自動返信メール件名',
			'◆自動返信メール本文',
			'こだわり条件数',
			'●プレビューアクセス番号（市外局番）',
			'●プレビューアクセス番号（市内局番）',
			'●プレビューアクセス番号（加入者番号）',
		);
	}

	static public function field_db()
	{
		return array(
			'job_id'                     => '自由入力⑤',
			'post_company_name'          => '●掲載社名',
			'url_home_page'              => '▲ホームページリンク',
			'zipcode'                    => '▲郵便番号',
			'location'                   => '●掲載住所',
			'traffic'                    => '●交通',
			'store_name'                 => '店舗名（紹介の場合）',
			'work_location_display_type' => '●勤務地 表示方式CD',
			'work_location'              => '勤務地 （派遣・契約の場合）',
			'work_location_title'        => '▲勤務地カセット式タイトル',
			'employment_type'            => '●雇用形態CD',
			'employment_mark'            => '雇用形態マーク※プルダウンで選択',
			'job_category'               => '職種',
			'occupation'                 => '●職種CD　大項目',
			'salary_type'                => '●給与形態CD',
			'salary_des'                 => '●給与',
			'salary_min'                 => '◆最低給与金額',
			'catch_copy'                 => '●キャッチ',
			'lead'                       => '●リード',
			'work_time_view_1'           => '◆勤務時間帯 朝（7～12）',
			'work_time_view_2'           => '◆勤務時間帯 昼（12～17）',
			'work_time_view_3'           => '◆勤務時間帯 夕方・夜（17～22）',
			'work_time_view_4'           => '◆勤務時間帯 深夜・早朝（22～7）',
			'work_day_week'              => '▲週あたり最低勤務日数',
			'work_time_des'              => '●勤務曜日・時間',
			'qualification'              => '▲資格',
			'employment_people'          => '●採用予定人数CD',
			'employment_people_num'      => '◆採用予定人数指定',
			'employment_people_des'      => '▲採用予定人数本文',
			'work_period'                => '●勤務期間CD',
			'rec.sub_title_1'            => '▲募集追加（1）見出し',
			'rec.text_1'                 => '待遇',
			'rec.sub_title_2'            => '▲募集追加（2）見出し',
			'rec.text_2'                 => '◆募集追加（2）本文',
			'rec.sub_title_3'            => '▲募集追加（3）見出し',
			'rec.text_3'                 => '◆募集追加（3）本文',
			'rec.sub_title_4'            => '▲募集追加（4）見出し',
			'rec.text_4'                 => '◆募集追加（4）本文',
			'rec.sub_title_5'            => '▲募集追加（5）見出し',
			'rec.text_5'                 => '◆募集追加（5）本文',
			'rec.sub_title_6'            => '▲募集追加（6）見出し',
			'rec.text_6'                 => '◆募集追加（6）本文',
			'rec.sub_title_7'            => '▲募集追加（7）見出し',
			'rec.text_7'                 => '◆募集追加（7）本文',
			'rec.sub_title_8'            => '▲募集追加（8）見出し',
			'rec.text_8'                 => '◆募集追加（8）本文',
			'rec.sub_title_9'            => '▲募集追加（9）見出し',
			'rec.text_9'                 => '◆募集追加（9）本文',
			'job_description'            => '●仕事内容',
			'add.sub_title_1'            => '▲仕事追加（1）見出し',
			'add.text_1'                 => '◆仕事追加（1）本文',
			'add.sub_title_2'            => '▲仕事追加（2）見出し',
			'add.text_2'                 => '◆仕事追加（2）本文',
			'add.sub_title_3'            => '▲仕事追加（3）見出し',
			'add.text_3'                 => '◆仕事追加（3）本文',
			'add.sub_title_4'            => '▲仕事追加（4）見出し',
			'add.text_4'                 => '◆仕事追加（4）本文',
			'business_description'       => '●事業内容',
			'interview_location'         => '面接地',
			'phone_name1'                => '●代表電話（1）名称',
			'phone_number11'            => '●代表電話（1）（市外局番）',
			'phone_number12'            => '●代表電話（1）（市内局番）',
			'phone_number13'            => '●代表電話（1）（加入者番号）',
			'trouble_23'                 => '交通費支給',
			'trouble_24'                 => 'シフト制',
			'trouble_25'                 => '社員登用あり',
			'trouble_26'                 => 'オープニング',
			'trouble_1'                  => '駅チカ･駅ナカ',
			'trouble_2'                  => '車・バイクOK',
			'trouble_3'                  => '未経験OK',
			'trouble_4'                  => '大学生歓迎',
			'trouble_5'                  => 'まかない・食事',
			'trouble_6'                  => '服装自由',
			'trouble_7'                  => '高校生可',
			'trouble_8'                  => '髪型自由',
			'trouble_9'                  => '日払い・週払い',
			'trouble_10'                 => '土日祝日のみ',
			'trouble_11'                 => '即日勤務OK',
			'trouble_12'                 => 'フリーター歓迎',
			'trouble_13'                 => '高収入',
			'trouble_14'                 => '英語を使う',
			'trouble_15'                 => '主婦・主夫歓迎',
			'trouble_16'                 => '副業OK',
		);
	}
	static public function all_field()
	{
		return array(
			'0'   => 'No',
			'1'   => 'WEB得＆HP',
			'2'   => '自由入力②',
			'3'   => '自由入力③',
			'4'   => '自由入力④',
			'5'   => '自由入力⑤|job_id',
			'6'   => '◆HOPE進行No',
			'7'   => '●商品CD',
			'8'   => '●掲載開始号CD',
			'9'   => '●制作企画CD',
			'10'  => '●明細CD',
			'11'  => '▲メモ',
			'12'  => '文字',
			'13'  => '●営業担当CD',
			'14'  => '●制作担当CD',
			'15'  => '●受注先顧客コード',
			'16'  => '●掲載先顧客コード',
			'17'  => '●掲載社名|post_company_name',
			'18'  => '文字',
			'19'  => '▲ホームページリンク|url_home_page',
			'20'  => '▲郵便番号|zipcode',
			'21'  => '●掲載住所|location',
			'22'  => '文字',
			'23'  => '●交通|traffic',
			'24'  => '文字',
			'25'  => '店舗名（紹介の場合）|store_name',
			'26'  => '●勤務地 表示方式CD|work_location_display_type',
			'27'  => '勤務地 （派遣・契約の場合）|work_location',
			'28'  => '文字',
			'29'  => '▲勤務地カセット式タイトル|work_location_title',
			'30'  => '文字',
			'31'  => '▲（勤）地図補足',
			'32'  => '文字',
			'33'  => '●雇用形態CD|employment_type',
			'34'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'35'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'36'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'37'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'38'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'39'  => '雇用形態マーク※プルダウンで選択|employment_mark',
			'40'  => '職種|job_category',
			'41'  => '文字',
			'42'  => '●職種CD　大項目|occupation',
			'43'  => '●職種CD　小項目',
			'44'  => 'FAナビ検索職種(大)',
			'45'  => 'FAナビ検索職種(小)',
			'46'  => '●給与形態CD|salary_type',
			'47'  => '●給与|salary_des',
			'48'  => '文字',
			'49'  => '◆最低給与金額|salary_min',
			'50'  => '●キャッチ|catch_copy',
			'51'  => '文字',
			'52'  => '●リード|lead',
			'53'  => '文字',
			'54'  => '◆勤務時間帯 朝（7～12）|work_time_view',
			'55'  => '◆勤務時間帯 昼（12～17）|work_time_view',
			'56'  => '◆勤務時間帯 夕方・夜（17～22）|work_time_view',
			'57'  => '◆勤務時間帯 深夜・早朝（22～7）|work_time_view',
			'58'  => '▲週あたり最低勤務日数|work_day_week',
			'59'  => '●勤務曜日・時間|work_time_des',
			'60'  => '文字',
			'61'  => '▲資格|qualification',
			'62'  => '文字',
			'63'  => '●採用予定人数CD|employment_people',
			'64'  => '◆採用予定人数指定|employment_people_num',
			'65'  => '▲採用予定人数本文|employment_people_des',
			'66'  => '文字',
			'67'  => '●勤務期間CD|work_period',
			'68'  => '▲勤務期間本文_入力欄',
			'69'  => '紹介予定派遣の場合',
			'70'  => '▲勤務期間本文＋紹介予定派遣',
			'71'  => '文字',
			'72'  => '▲募集追加（1）見出し|rec.sub_title',
			'73'  => '文字',
			'74'  => '待遇|rec.text',
			'75'  => '文字',
			'76'  => '▲募集追加（2）見出し|rec.sub_title',
			'77'  => '文字',
			'78'  => '◆募集追加（2）本文|rec.text',
			'79'  => '文字',
			'80'  => '▲募集追加（3）見出し|rec.sub_title',
			'81'  => '文字',
			'82'  => '◆募集追加（3）本文|rec.text',
			'83'  => '文字',
			'84'  => '▲募集追加（4）見出し|rec.sub_title',
			'85'  => '文字',
			'86'  => '◆募集追加（4）本文|rec.text',
			'87'  => '文字',
			'88'  => '▲募集追加（5）見出し|rec.sub_title',
			'89'  => '文字',
			'90'  => '◆募集追加（5）本文|rec.text',
			'91'  => '文字',
			'92'  => '▲募集追加（6）見出し|rec.sub_title',
			'93'  => '文字',
			'94'  => '◆募集追加（6）本文|rec.text',
			'95'  => '文字',
			'96'  => '▲募集追加（7）見出し|rec.sub_title',
			'97'  => '文字',
			'98'  => '◆募集追加（7）本文|rec.text',
			'99'  => '文字',
			'100' => '▲募集追加（8）見出し|rec.sub_title',
			'101' => '文字',
			'102' => '◆募集追加（8）本文|rec.text',
			'103' => '文字',
			'104' => '▲募集追加（9）見出し|rec.sub_title',
			'105' => '文字',
			'106' => '◆募集追加（9）本文|rec.text',
			'107' => '文字',
			'108' => '募集情報合計行数',
			'109' => '●仕事内容|job_description',
			'110' => '文字',
			'111' => '▲仕事追加（1）見出し|add.sub_title',
			'112' => '文字',
			'113' => '◆仕事追加（1）本文|add.text',
			'114' => '文字',
			'115' => '▲仕事追加（2）見出し|add.sub_title',
			'116' => '文字',
			'117' => '◆仕事追加（2）本文|add.text',
			'118' => '文字',
			'119' => '▲仕事追加（3）見出し|add.sub_title',
			'120' => '文字',
			'121' => '◆仕事追加（3）本文|add.text',
			'122' => '文字',
			'123' => '▲仕事追加（4）見出し|add.sub_title',
			'124' => '文字',
			'125' => '◆仕事追加（4）本文|add.text',
			'126' => '文字',
			'127' => '仕事情報合計行数',
			'128' => '●事業内容|business_description',
			'129' => '文字',
			'130' => '▲面接地・他タイトル',
			'131' => '文字',
			'132' => '面接地|interview_location',
			'133' => '▲（面）地図補足',
			'134' => '文字',
			'135' => '●応募方法',
			'136' => '●応募後のプロセス',
			'137' => '文字',
			'138' => '◆携帯版電話応募ボタンCD',
			'139' => '●代表電話（1）名称|phone_name1',
			'140' => '文字',
			'141' => '●代表電話（1）（市外局番）|phone_number1',
			'142' => '●代表電話（1）（市内局番）|phone_number1',
			'143' => '●代表電話（1）（加入者番号）|phone_number1',
			'144' => '▲代表電話（2）名称',
			'145' => '文字',
			'146' => '▲代表電話（2）（市外局番）',
			'147' => '◆代表電話（2）（市内局番）',
			'148' => '◆代表電話（2）（加入者番号）',
			'149' => '▲問合せ補足',
			'150' => '文字',
			'151' => '●WEB応募受付CD',
			'152' => '応募先',
			'153' => '◆応募シートタイプCD',
			'154' => '▲応募シート自由質問',
			'155' => '文字',
			'156' => '◆自動返信メールCD',
			'157' => '◆自動返信メール件名',
			'158' => '文字',
			'159' => '◆自動返信メール本文',
			'160' => '文字',
			'161' => '交通費支給|trouble',
			'162' => 'シフト制|trouble',
			'163' => '社員登用あり|trouble',
			'164' => 'オープニング|trouble',
			'165' => '駅チカ･駅ナカ|trouble',
			'166' => '車・バイクOK|trouble',
			'167' => '未経験OK|trouble',
			'168' => '大学生歓迎|trouble',
			'169' => 'まかない・食事|trouble',
			'170' => '服装自由|trouble',
			'171' => '高校生可|trouble',
			'172' => '髪型自由|trouble',
			'173' => '日払い・週払い|trouble',
			'174' => '土日祝日のみ|trouble',
			'175' => '即日勤務OK|trouble',
			'176' => 'フリーター歓迎|trouble',
			'177' => '高収入|trouble',
			'178' => '英語を使う|trouble',
			'179' => '主婦・主夫歓迎|trouble',
			'180' => '副業OK|trouble',
			'181' => 'こだわり条件数',
			'182' => '●プレビューアクセス番号（市外局番）',
			'183' => '●プレビューアクセス番号（市内局番）',
			'184' => '●プレビューアクセス番号（加入者番号）',
		);
	}
	static public function convert_utf8($file)
	{
		$data = file_get_contents($file);
		//$data = file_get_contents(DOCROOT.'tmp/job_list_20151119.csv');
		if(mb_detect_encoding($data,'UTF-8',true) === false)
		{
			$encode_ary = array(
				'ASCII',
				'JIS',
				'eucjp-win',
				'sjis-win',
				'EUC-JP',
				'UTF-8',
			);
			$data = mb_convert_encoding($data,'UTF-8',$encode_ary);
		}

		$fp = tmpfile();
		fwrite($fp,$data);
		rewind($fp);
		return $fp;
	}
	public function get_employment_mark($data,$_not_exist)
	{
		$employment_mark = '';
		$check = false;
		foreach(Constants::$employment_mark as $key => $val)
		{
			if($data != '' && $data == '['.$val.']')
			{
				$employment_mark .= ','.$key;
				$check = true;
				break;
			}
		}

		if( ! $check && $data != '')
			$employment_mark .= $_not_exist.',';

		return $employment_mark;

	}
	public function get_file_csv($file)
	{
		$all_field = self::all_field();
		$trouble_check = '●';
		$_not_exist = self::$not_exits;
		$arr_data = array();
		$fp = self::convert_utf8($file);
		$k = 0;
		while(($data = fgetcsv($fp, 10000, ',')) !== false)
		{
			$num = count($data);
			if($num != 185)
			{
				$this->error['0']['file_error'] = 'ＣＳＶのフォーマットが正しくありません';
				return array();
			}

			if($k > 0)
			{
				for ($i = 0; $i < $num; $i++)
				{
					if(substr_count($all_field[$i],'|')) // db
					{
						$arr_field_lable = explode('|',$all_field[$i]);
						if($i == 26)// work_location_display_type
						{
							$check = false;
							foreach(Constants::$job_work_location_display_type as $key => $val)
							{
								if($data[$i] == $val)
								{
									$arr_data[$k][$arr_field_lable['1']] = $key;
									$check = true;
									break;
								}
							}

							if( ! $check)
								$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
						}

						elseif($i == 33)
						{
							$check = false;
							foreach(Constants::$employment_type as $key => $val)
							{
								if($data[$i] == $val)
								{
									$arr_data[$k][$arr_field_lable['1']] = $key;
									$check = true;
									break;
								}
							}

							if( ! $check)
								$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
						}

						elseif($i > 33 && $i < 40) // employment_mark
						{
							if($i == 34) // run one
							{
								$arr_data[$k][$arr_field_lable['1']] = '';
								$employment_mark = '';
								for($j = 34; $j < 40; ++$j)
								{
									$employment_mark .= $this->get_employment_mark($data[$j], $_not_exist);
								}

								if(trim($employment_mark,',') != '')
									$arr_data[$k][$arr_field_lable['1']] = ','.trim($employment_mark,',').',';

							}
						}

						elseif($i > 53 && $i < 58) // work_time_views
						{
							if($i == 54)
							{
								$work_time_views = ',';
								if($data['54'] == '表示')
									$work_time_views .= '1,';
								else
								{
									if($data['54'] == '表示しない')
										$work_time_views .= ',';
									elseif($data['54'] == '')
										$work_time_views .= 'R';
									else
										$work_time_views .= $_not_exist.',';
								}

								if($data['55'] == '表示')
									$work_time_views .= '2,';
								else
								{
									if($data['55'] == '表示しない')
										$work_time_views .= ',';
									elseif($data['55'] == '')
										$work_time_views .= 'R';
									else
										$work_time_views .= $_not_exist.',';
								}

								if($data['56'] == '表示')
									$work_time_views .= '3,';
								else
								{
									if($data['56'] == '表示しない')
										$work_time_views .= ',';
									elseif($data['56'] == '')
										$work_time_views .= 'R';
									else
										$work_time_views .= $_not_exist.',';
								}

								if($data['57'] == '表示')
									$work_time_views .= '4,';
								else
								{
									if($data['57'] == '表示しない')
										$work_time_views .= ',';
									elseif($data['57'] == '')
										$work_time_views .= 'R';
									else
										$work_time_views .= $_not_exist.',';
								}

								$arr_data[$k][$arr_field_lable['1']] = $work_time_views;
							}
						}

						elseif($i == 58)
						{
							$arr_data[$k][$arr_field_lable['1']] = trim($data[$i],'日');
						}

						elseif($i == 63)
						{
							$arr_data[$k][$arr_field_lable['1']] = null;
							$check = false;
							foreach(Constants::$employment_people as $key => $val)
							{
								if($data[$i] == $val)
								{
									$arr_data[$k][$arr_field_lable['1']] = $key;
									$check = true;
									break;
								}
							}

							if( ! $check)
								$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
						}

						elseif($i == 67)
						{
							$check = false;
							foreach(Constants::$work_period as $key => $val)
							{
								if($data[$i] == $val)
								{
									$arr_data[$k][$arr_field_lable['1']] = $key;
									$check = true;
									break;
								}
							}

							if( ! $check)
								$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
						}

						elseif($i > 71 && $i < 107) // job_rec
						{
							$arr_data[$k]['job_rec'][$arr_field_lable['1']][] = $data[$i];
						}

						elseif($i > 110 && $i < 126) // job_add
						{
							$arr_data[$k]['job_add'][$arr_field_lable['1']][] = $data[$i];
						}

						elseif($i == 141 || $i == 142 || $i == 143) // phone number 1
						{
							$arr_data[$k][$arr_field_lable['1']] = $data['141'].','.$data['142'].','.$data['143'];
						}

						elseif($i > 160 && $i < 181)// trouble
						{
							if($i == 161) // run one
							{
								$trouble = ',';
								if($data['161'] == $trouble_check)
									$trouble .= '23,';
								else
									$trouble .= ',';

								if($data['162'] == $trouble_check)
									$trouble .= '24,';
								else
									$trouble .= ',';

								if($data['163'] == $trouble_check)
									$trouble .= '25,';
								else
									$trouble .= ',';

								if($data['164'] == $trouble_check)
									$trouble .= '26,';
								else
									$trouble .= ',';

								if($data['165'] == $trouble_check)
									$trouble .= '1,';
								else
									$trouble .= ',';

								if($data['166'] == $trouble_check)
									$trouble .= '2,';
								else
									$trouble .= ',';

								if($data['167'] == $trouble_check)
									$trouble .= '3,';
								else
									$trouble .= ',';

								if($data['168'] == $trouble_check)
									$trouble .= '4,';
								else
									$trouble .= ',';

								if($data['169'] == $trouble_check)
									$trouble .= '5,';
								else
									$trouble .= ',';
								if($data['170'] == $trouble_check)
									$trouble .= '6,';
								else
									$trouble .= ',';
								if($data['171'] == $trouble_check)
									$trouble .= '7,';
								else
									$trouble .= ',';
								if($data['172'] == $trouble_check)
									$trouble .= '8,';
								else
									$trouble .= ',';
								if($data['173'] == $trouble_check)
									$trouble .= '9,';
								else
									$trouble .= ',';
								if($data['174'] == $trouble_check)
									$trouble .= '10,';
								else
									$trouble .= ',';
								if($data['175'] == $trouble_check)
									$trouble .= '11,';
								else
									$trouble .= ',';
								if($data['176'] == $trouble_check)
									$trouble .= '12,';
								else
									$trouble .= ',';
								if($data['177'] == $trouble_check)
									$trouble .= '13,';
								else
									$trouble .= ',';
								if($data['178'] == $trouble_check)
									$trouble .= '14,';
								else
									$trouble .= ',';

								if($data['179'] == $trouble_check)
									$trouble .= '15,';
								else
									$trouble .= ',';

								if($data['180'] == $trouble_check)
									$trouble .= '16,';
								else
									$trouble .= ',';

								$arr_data[$k][$arr_field_lable['1']] = $trouble;
							}
						}

						else
						{
							if($arr_field_lable['1'] == 'occupation')
							{
								$check = false;
								foreach(Constants::$occupation as $key => $val)
								{
									if($val == $data[$i])
									{
										$arr_data[$k][$arr_field_lable['1']] = $key;
										$check = true;
										break;
									}
								}

								if( ! $check)
									$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
							}

							elseif($arr_field_lable['1'] == 'salary_type')
							{
								$check = false;
								foreach(Constants::$salary_type as $key => $val)
								{
									if($val == $data[$i])
									{
										$arr_data[$k][$arr_field_lable['1']] = $key;
										$check = true;
										break;
									}
								}

								if( ! $check)
									$arr_data[$k][$arr_field_lable['1']] = $_not_exist;
							}

							else
								$arr_data[$k][$arr_field_lable['1']] = $data[$i];
						}
					}

					else
					{
						$arr_data[$k]['csv'][$all_field[$i]] = $data[$i];
					}
				}
			}
			++$k;
		}

		return $arr_data;
	}

	static public function set_mes_overlenngth($field,$index,$num)
	{
		$field_db = self::field_db();
		return $index.'行目:'.$field_db[$field].'は'.$num.'文字以内で入力して下さい';

	}
	static public function set_mes_not_in($field,$index)
	{
		$field_db = self::field_db();
		return  $index.'行目:'.$field_db[$field].'を入力して下さい';
	}
	static public function set_mes_error_data($field,$index)
	{
		$field_db = self::field_db();
		return  $index.'行目:'.$field_db[$field].'が正しくありません';
	}

	static public function set_mes_require($field,$index)
	{
		$field_db = self::field_db();
		return  $index.'行目:'.$field_db[$field].'を入力して下さい';
	}

	private function get_length($str)
	{
		return mb_strwidth(mb_convert_encoding($str, 'SJIS')) / 2;
	}

	public function validate($data,$data_add,$data_rec,$index)
	{
		if($this->get_length($data['traffic']) > 50)
		{
			$this->error[$index]['traffic'] = self::set_mes_overlenngth('traffic',$index,50);
		}

		if($this->get_length($data['store_name']) > 50)
		{
			$this->error[$index]['store_name'] = self::set_mes_overlenngth('store_name',$index,50);
		}

		if($this->get_length($data['job_category']) > 32)
		{
			$this->error[$index]['job_category'] = self::set_mes_overlenngth('job_category',$index,32);
		}

		if($this->get_length($data['work_location']) == 0)
		{
			$this->error[$index]['work_location'] = self::set_mes_require('work_location', $index);
		}

		if($this->get_length($data['work_location']) > 20)
		{
			$this->error[$index]['work_location'] = self::set_mes_overlenngth('work_location',$index,20);
		}

		if($this->get_length($data['work_location_title']) > 10)
		{
			$this->error[$index]['work_location_title'] = self::set_mes_overlenngth('work_location_title',$index,10);
		}

		if($data['work_location_display_type'] == '')
		{
			$this->error[$index]['work_location_display_type'] = self::set_mes_require('work_location_display_type', $index);
		}
		else
		{

			if( ! is_numeric($data['work_location_display_type']))
			{
				$this->error[$index]['work_location_display_type'] = self::set_mes_error_data('work_location_display_type', $index);
			}

		}




		if($this->get_length($data['location']) > 32)
		{
			$this->error[$index]['location'] = self::set_mes_overlenngth('location',$index,32);
		}

		if($this->get_length($data['url_home_page']) > 50)
		{
			$this->error[$index]['url_home_page'] = self::set_mes_overlenngth('url_home_page',$index,50);
		}

		if($this->get_length($data['post_company_name']) == 0)
		{
			$this->error[$index]['post_company_name'] = self::set_mes_require('post_company_name', $index);
		}

		if($this->get_length($data['post_company_name']) > 28)
		{
			$this->error[$index]['post_company_name'] = self::set_mes_overlenngth('post_company_name',$index,28);
		}

		if($this->get_length($data['zipcode']) > 7)
		{
			$this->error[$index]['zipcode'] = self::set_mes_overlenngth('zipcode',$index,7);
		}

		if($data['employment_type'] != '' && ! is_numeric($data['employment_type']))
		{
			$this->error[$index]['employment_type'] = self::set_mes_not_in('employment_type',$index);
		}

		if($data['employment_people'] != '' && ! is_numeric($data['employment_people']))
		{
			$this->error[$index]['employment_people'] = self::set_mes_not_in('employment_people',$index);
		}

		if($data['work_day_week'] && ! is_numeric($data['work_day_week']))
		{
			$this->error[$index]['work_day_week'] = self::set_mes_error_data('work_day_week', $index);
		}

		if($data['employment_people_num'] && ! is_numeric($data['employment_people_num']))
		{
			$this->error[$index]['employment_people_num'] = self::set_mes_error_data('employment_people_num', $index);
		}


		$arr_work_time_view = explode(',',$data['work_time_view']);

		array_shift($arr_work_time_view);
		array_pop($arr_work_time_view);
		for($i = 0; $i < count($arr_work_time_view); ++$i)
		{
			if($arr_work_time_view[$i] && ! array_key_exists($arr_work_time_view[$i], Constants::$work_time_view))
			{
				if($arr_work_time_view[$i] == self::$not_exits) // input error
					$this->error[$index]['work_time_view'][] = self::set_mes_error_data('work_time_view_'.($i + 1),$index);
				elseif($arr_work_time_view[$i] == 'R') // not input
					$this->error[$index]['work_time_view'][] = self::set_mes_require('work_time_view_'.($i + 1),$index);
			}
		}

		if($data['work_period'] && ! array_key_exists($data['work_period'],Constants::$work_period))
		{
			$this->error[$index]['work_period'] = self::set_mes_error_data('work_period',$index);
		}

		if($data['occupation'] && ! array_key_exists($data['occupation'],Constants::$occupation))
		{
			$this->error[$index]['occupation'] = self::set_mes_error_data('occupation',$index);
		}

		if($this->get_length($data['salary_des']) == 0)
		{
			$this->error[$index]['salary_des'] = self::set_mes_require('salary_des', $index);
		}

		if($this->get_length($data['salary_des']) > 36)
		{
			$this->error[$index]['salary_des'] = self::set_mes_overlenngth('salary_des',$index,36);
		}

		if($data['salary_min'] && ($data['salary_min'] > 2147483647 || ! is_numeric($data['salary_min'])))
		{
			$this->error[$index]['salary_min'] = self::set_mes_error_data('salary_min',$index);
		}

		if($this->get_length($data['employment_people_des']) > 100)
		{
			$this->error[$index]['employment_people_des'] = self::set_mes_overlenngth('employment_people_des',$index,100);
		}

		if($this->get_length($data['business_description']) > 40)
		{
			$this->error[$index]['business_description'] = self::set_mes_overlenngth('business_description',$index,40);
		}

		if($this->get_length($data['interview_location']) > 60)
		{
			$this->error[$index]['interview_location'] = self::set_mes_overlenngth('interview_location',$index,60);
		}

		if($this->get_length($data['phone_name1']) > 20)
		{
			$this->error[$index]['phone_name1'] = self::set_mes_overlenngth('phone_name1',$index,20);
		}

		$arr_phone_number1 = explode(',', $data['phone_number1']);

		$count = 0 ;
		for($i = 0; $i < count($arr_phone_number1); ++$i)
		{
			if($arr_phone_number1[$i] != '')
			{
				++$count;
			}

			if( $arr_phone_number1[$i] != '' && ! is_numeric($arr_phone_number1[$i]))
			{
				$this->error[$index]['phone_number1'.($i+1)] = self::set_mes_error_data('phone_number1'.($i+1),$index);
			}

			if($this->get_length($arr_phone_number1[$i]) > 4)
			{
				$this->error[$index]['phone_number1'.($i+1)] = self::set_mes_overlenngth('phone_number1'.($i+1),$index,4);
			}

		}


		if($count == 1 || $count == 2)
		{
			for($i = 0; $i < count($arr_phone_number1); ++$i)
			{
				if($arr_phone_number1[$i] == '')
					$this->error[$index]['phone_number1'.($i+1)] = self::set_mes_require ('phone_number1'.($i+1), $index);
			}
		}

		if($this->get_length($data['catch_copy']) > 45)
		{
			$this->error[$index]['catch_copy'] = self::set_mes_overlenngth('catch_copy',$index,45);
		}

		if($this->get_length($data['lead']) > 60)
		{
			$this->error[$index]['lead'] = self::set_mes_overlenngth('lead',$index,60);
		}

		if($this->get_length($data['work_time_des']) > 100)
		{
			$this->error[$index]['work_time_des'] = self::set_mes_overlenngth('work_time_des',$index,100);
		}

		if($this->get_length($data['qualification']) > 100)
		{
			$this->error[$index]['qualification'] = self::set_mes_overlenngth('qualification',$index,100);
		}

		if($this->get_length($data['employment_people_des']) > 100)
		{
			$this->error[$index]['employment_people_des'] = self::set_mes_overlenngth('employment_people_des',$index,100);
		}




		$arr_trouble = explode(',',$data['trouble']);
		array_shift($arr_trouble);
		array_pop($arr_trouble);
		for($i = 0; $i < count($arr_trouble); $i++)
		{
			if($i == 0) $k = '23';
			elseif($i == 1) $k = '24';
			elseif($i == 2) $k = '25';
			elseif($i == 3) $k = '26';
			else
			{
				$k = $i - 3;
			}

			if($arr_trouble[$i] && ! array_key_exists($arr_trouble[$i], Constants::$trouble))
			{
				$this->error[$index]['trouble'][] = self::set_mes_not_in('trouble_'.$k,$index);
			}
		}

		$arr_employment_mark = explode(',',$data['employment_mark']);
		array_shift($arr_employment_mark);
		array_pop($arr_employment_mark);
		if($count = count($arr_employment_mark))
		{
			for($i = 0; $i < $count; ++$i)
			{
				if($arr_employment_mark[$i] && ! array_key_exists($arr_employment_mark[$i],Constants::$employment_mark))
				{
					$this->error[$index]['employment_mark'][] = self::set_mes_error_data('employment_mark',$index);
				}
			}
		}

		$i = 1 ;
		foreach($data_add as $row)
		{
			if($this->get_length($row['sub_title']) > 12)
			{
				$this->error[$index]['add.sub_title'][] = self::set_mes_overlenngth('add.sub_title_'.$i,$index,12);
			}

			++$i;
		}

		$i = 1;
		foreach($data_rec as $row)
		{
			if($this->get_length($row['sub_title']) > 7)
			{
				$this->error[$index]['rec.sub_title'][] = self::set_mes_overlenngth('rec.sub_title_'.$i,$index,7);
			}

			++$i;
		}

		if(count($this->error))
			return false;

		return true;

	}

	public function data_once_csv($data)
	{
		$data['csv'] = json_encode($data['csv']);
		$data_add = array();
		$data_rec = array();
		if(isset($data['job_add']['add.sub_title']))
		{
			$k = 0;
			for($i = 0; $i < count($data['job_add']['add.sub_title']); ++$i)
			{
				$data_add[$k]['sub_title'] = $data['job_add']['add.sub_title'][$i];
				$data_add[$k]['text'] = $data['job_add']['add.text'][$i];
				$data_add[$k]['job_id'] = $data['job_id'];
				++$k;
			}
		}

		if(isset($data['job_rec']['rec.sub_title']))
		{
			$k = 0;
			for($i = 0; $i < count($data['job_rec']['rec.sub_title']); ++$i)
			{
				$data_rec[$k]['sub_title'] = $data['job_rec']['rec.sub_title'][$i];
				$data_rec[$k]['text'] = $data['job_rec']['rec.text'][$i];
				$data_rec[$k]['job_id'] = $data['job_id'];
				++$k;
			}
		}

		unset($data['job_add']);
		unset($data['job_rec']);
		$data_res['job'] = $data;
		$data_res['job_add'] = $data_add;
		$data_res['job_rec'] = $data_rec;
		return $data_res;
	}

	public function update_csv($file)
	{
		$data = $this->get_file_csv($file);
		//array_shift($data);
		if( ! count($data))
		{
			return false;
		}

		$model_job = new Model_Job();
		$model_add = new Model_Jobadd();
		$model_rec = new Model_Jobrecruit();
		$k = 1;
		\DB::start_transaction();
		$check = true;
		$no_update = array();
		try
		{
			foreach($data as $row)
			{
				if( ! $check)
				{
					break;
				}

				$data = self::data_once_csv($row);
				$validate_field = $this->validate($data['job'], $data['job_add'],$data['job_rec'],$k);
				$res = $model_job->update_data_csv($data['job'],$data['job']['job_id'],$validate_field,$no_update,$k);
				if($res === -1)
				{
					$this->error[$k]['job_id'] = $k.'行目:求人情報が存在していません。';
					$check = false;
				}
				else
				{
					if($res && $validate_field)
					{
						$res_delete_add = $model_add->delete_data($data['job']['job_id']);
						if($res_delete_add >= 0)
						{
							if(count($data['job_add']) && ! $model_add->insert_multi_data($data['job_add'], $model_job))
							{
								$check = false;
							}
						}

						$res_delete_rec = $model_rec->delete_data($data['job']['job_id']);

						if($res_delete_rec >= 0)
						{
							if(count($data['job_rec']) && ! $model_rec->insert_multi_data($data['job_rec'],$model_job))
							{
								$check = false;
							}
						}
					}
					else
					{
						$check = false;
					}
				}

				++$k;
			}

			if( ! $check)
			{
				\DB::rollback_transaction();
			}

			else
			{
				\DB::commit_transaction();
			}
		}
		catch (Exception $e)
		{
			// rollback pending transactional queries
			\DB::rollback_transaction();
			throw $e;
		}

		$this->no_update = $no_update;
		return $check;
	}
}