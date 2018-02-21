<?php

use Fuel\Core\DB;

class Importpartner
{
    public $error = array();
    public $no_update = array();
    private $mpartner;
    private $mgroup;

    function __construct()
    {
        $this->mgroup = new Model_Mgroups();
        $this->mpartner = new Model_Mpartner();
    }
    public function get_errors()
    {
        return $this->error;
    }

    /**
     * @author huylv6635
     * @return array
     */
    static public function all_field()
    {
        return array(
            '0'   => '取引先コード',
            '1'   => '取引先区分',
            '2'   => 'Staff2000顧客マスタ番号',
            '3'   => '所属',
            '4'   => '取引先(支店)名',
            '5'   => '郵便番号',
            '6'   => '都道府県',
            '7'   => '市区町村',
            '8'   => '以降の住所',
            '9'   => '電話番号',
            '10'  => 'FAX',
            '11'  => '担当部門',
            '12'  => '請求先部署',
            '13'  => '請求先電話番号',
            '14'  => '請求先FAX',
            '15'  => '請求先〆日',
            '16'  => '支払日',
            '17'  => '取引開始年月日',
            '18'  => '銀行名',
            '19'  => '銀行支店名',
            '20'  => '銀行口座種別',
            '21'  => '銀行口座番号',
            '22'  => '備考',
            '23'  => '宇佐美支店番号',
            '24'  => '営業担当',
        );
    }

    /**
     * @author huylv6635
     * convert file to utf8
     * @param $file
     * @return resource
     */
    static public function convert_utf8($file)
    {
        $data = file_get_contents($file);
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

    /**
     * @author huylv6635
     * get data csv
     * @param $file
     * @return array
     */
    public function get_file_csv($file)
    {
        $arr_data = array();
        $fp = self::convert_utf8($file);
        $index = 0;
        while(($data = fgetcsv($fp, 10000, ',')) !== false)
        {
            $arr_data[] = $data;
            $index ++;
        }
        unset($arr_data[0]);

        return $arr_data;
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @param $num
     * @return string
     */
    static public function set_mes_overlength($key,$index,$num)
    {
        $all_field = self::all_field();
        return $index.'行目:'.$all_field[$key].'は'.$num.'文字以内で入力して下さい。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_error_data($key,$index)
    {
        $all_field = self::all_field();
        return  $index.'行目:'.$all_field[$key].'が正しくありません。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_required($key,$index)
    {
        $all_field = self::all_field();
        return $index.'行目:'.$all_field[$key].'を入力して下さい。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_not_exist($key,$index)
    {
        $all_field = self::all_field();
        return $index.'行目:'.$all_field[$key].'が存在しません。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $index
     * @return string
     */
    static public function set_mes_not_approved($index)
    {
        return $index.'行目:ステータスが「承認待ち」です。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_not_match($key,$index)
    {
        $all_field = self::all_field();
        return $index.'行目:'.$all_field[$key].'は既存データーと一致しません。';
    }

    /**
     * @author huylv6635
     * validate number
     * @param $data
     * @return int
     */
    static public function check_number($data)
    {
        return preg_match('/^[0-9]+$/',$data);
    }

    /**
     * @author huylv6635
     * validate date
     * @param $data
     * @return bool
     */
    static public function check_date($data)
    {
        return strtotime($data) === false ? false : true;
    }

    /**
     * @author huylv6635
     * @param $data
     * @return string
     */
    static public function convert_tel($data)
    {
        if (self::check_number($data))
        {
            $n = mb_strlen($data);
            $first = '';
            $second = '';
            $third = '';
            for($a=1; $a<=4; $a++){
                for($b=1; $b<=$a; $b++){
                    for($c=1; $c<=$b; $c++){
                        if (($a+$b+$c) == $n){
                            $first = $a;
                            $second = $b;
                            $third = $c;
                        }
                    }
                }
            }

            $data = substr($data,0,$first) . '-' . substr($data,$first,$second) . '-' . substr($data,-$third,$third);
        }

        return $data;
    }

    /**
     * @author huylv6635
     * @param $data
     * @param $index
     * @return array|bool
     */
    public function validate($data, $index)
    {
        //validate: format
        if(count($data) != 25)
        {
            $this->error[$index]['file_error']['type'] = $index.'行目のフォーマットが正しくありません。';

            return array();
        }

        //validate: partner_code
		if (strlen($data[0]))
		{
	        $res = $this->mpartner->get_filter_partner(['partner_code' => $data[0]]);
			if (!$res)
			{
				$this->error[$index]['partner_code']['exist'] = self::set_mes_not_exist(0,$index);
			}
			elseif ($res && $res[0]['status'] == 1)
			{
				$this->no_update[$index] = self::set_mes_not_approved($index);
			}
		}

		{
            //validate: type
            if ($data[1] == '')
            {
                $this->error[$index]['type']['required'] = self::set_mes_required(1,$index);
            }
            else
            {
                if (!array_search($data[1], Constants::$_type_partner))
                {
                    $this->error[$index]['type']['exist'] = self::set_mes_not_exist(1,$index);
                }
                elseif (isset($res) && $res[0]['type'] != array_search($data[1], Constants::$_type_partner))
                {
                    $this->error[$index]['type']['match'] = self::set_mes_not_match(1,$index);
                }
            }

            //validate: master_num
            if (mb_strlen($data[2]) > 50)
            {
                $this->error[$index]['master_num']['length'] = self::set_mes_overlength(2,$index,50);
            }
            if ($data[2] != '' && !self::check_number($data[2]))
            {
                $this->error[$index]['master_num']['type'] = self::set_mes_error_data(2,$index);
            }

            //validate: m_group_id
            if ($data[3] == '')
            {
                $this->error[$index]['m_group_id']['required'] = self::set_mes_required(3,$index);
            }
            else
            {
                $group = $this->mgroup->check_name(null,$data[3]);
                if (!$group)
                {
                    $this->error[$index]['m_group_id']['exist'] = self::set_mes_not_exist(3,$index);
                }
            }

            //validate: branch_name
            if ($data[4] == '')
            {
                $this->error[$index]['branch_name']['required'] = self::set_mes_required(4,$index);
            }
            if (mb_strlen($data[4]) > 20)
            {
                $this->error[$index]['branch_name']['length'] = self::set_mes_overlength(4,$index,20);
            }

            //validate: zipcode
            if ($data[5] == '')
            {
                $this->error[$index]['zipcode']['required'] = self::set_mes_required(5,$index);
            }
            else
            {
                if (!self::check_number($data[5]))
                {
                    $this->error[$index]['zipcode']['type'] = self::set_mes_error_data(5,$index);
                }
                if (mb_strlen($data[5]) > 7)
                {
                    $this->error[$index]['zipcode']['length'] = self::set_mes_overlength(5,$index,7);
                }
                if (mb_strlen($data[5]) < 7)
                {
                    $this->error[$index]['zipcode']['type'] = self::set_mes_error_data(5,$index);
                }
            }

            //validate: addr1
            if ($data[6] == '')
            {
                $this->error[$index]['addr1']['required'] = self::set_mes_required(6,$index);
            }
            elseif (!array_search($data[6], Constants::$address_1))
            {
                $this->error[$index]['addr1']['exist'] = self::set_mes_not_exist(6,$index);
            }

            //validate: addr2
            if ($data[7] == '')
            {
                $this->error[$index]['addr2']['required'] = self::set_mes_required(7,$index);
            }
            if (mb_strlen($data[7]) > 10)
            {
                $this->error[$index]['addr2']['length'] = self::set_mes_overlength(7,$index,10);
            }

            //validate: arrd3
            if (mb_strlen($data[8]) > 50)
            {
                $this->error[$index]['addr3']['length'] = self::set_mes_overlength(8,$index,50);
            }

            //validate: tel
            if ($data[9] == '')
            {
                $this->error[$index]['tel']['required'] = self::set_mes_required(9,$index);
            }
            else if (preg_match('/^(?:[0-9]{1,5}-[0-9]{1,4}-[0-9]{1,4}|[0-9]{1,11})$/', $data[9]) == false)
			{
				$this->error[$index]['tel']['type'] = self::set_mes_error_data(9,$index);
			}

            //validate: fax
            if (
				strlen($data[10]) &&
				preg_match('/^(?:[0-9]{1,5}-[0-9]{1,4}-[0-9]{1,4}|[0-9]{1,11})$/', $data[10]) == false)
			{
                $this->error[$index]['tel']['type'] = self::set_mes_error_data(10,$index);
			}

            //validate: department_id
            if ($data[11] && !in_array($data[11], Constants::$department))
            {
                $this->error[$index]['department_id']['exist'] = self::set_mes_not_exist(11,$index);
            }
            if ($data[11] == '' && $data[1] == Constants::$_type_partner[1])
            {
                $this->error[$index]['department_id']['required'] = self::set_mes_required(11,$index);
            }

            //validate: billing_department
            if ($data[12] && mb_strlen($data[12]) > 10)
            {
                $this->error[$index]['billing_department']['length'] = self::set_mes_overlength(12,$index,10);
            }

            //validate: billing_tell
            if (mb_strlen($data[13]) > 11)
            {
                $this->error[$index]['billing_tell']['length'] = self::set_mes_overlength(13,$index,11);
            }
            if ($data[13] != '' && !(self::check_number($data[13]) && substr($data[13],0,1) == 0 && mb_strlen($data[13]) >= 10))
            {
                $this->error[$index]['billing_tell']['type'] = self::set_mes_error_data(13,$index);
            }

            //validate: billing_fax
            if (mb_strlen($data[14]) > 11)
            {
                $this->error[$index]['billing_fax']['length'] = self::set_mes_overlength(14,$index,11);
            }
            if ($data[14] != '' && !(self::check_number($data[14]) && mb_strlen($data[14]) >= 10))
            {
                $this->error[$index]['billing_fax']['type'] = self::set_mes_error_data(14,$index);
            }

            //validate: billing_deadline_day
            if (mb_strlen($data[15]) > 2)
            {
                $this->error[$index]['billing_deadline_day']['length'] = self::set_mes_overlength(15,$index,2);
            }
            if ($data[15] != '' && !self::check_number($data[15]))
            {
                $this->error[$index]['billing_deadline_day']['type'] = self::set_mes_error_data(15,$index);
            }

            //validate: payment_day
            if (mb_strlen($data[16]) > 2)
            {
                $this->error[$index]['payment_day']['length'] = self::set_mes_overlength(16,$index,2);
            }
            if ($data[16] != '' && !self::check_number($data[16]))
            {
                $this->error[$index]['payment_day']['type'] = self::set_mes_error_data(16,$index);
            }

            //validate: billing_start_date
            if ($data[17] != '' && !self::check_date($data[17]))
            {
                $this->error[$index]['billing_start_date']['type'] = self::set_mes_error_data(17,$index);
            }

            //validate: bank_name
            if (mb_strlen($data[18]) > 10)
            {
                $this->error[$index]['bank_name']['length'] = self::set_mes_overlength(18,$index,10);
            }

            //validate: bank_branch_name
            if (mb_strlen($data[19]) > 10)
            {
                $this->error[$index]['bank_branch_name']['length'] = self::set_mes_overlength(19,$index,10);
            }

            //validate: bank_type
            if ($data[20] != '' && !in_array($data[20], Constants::$bank_type))
            {
                $this->error[$index]['bank_type']['exist'] = self::set_mes_not_exist(20,$index);
            }

            //validate: bank_account_number
            if (mb_strlen($data[21]) > 7)
            {
                $this->error[$index]['bank_account_number']['length'] = self::set_mes_overlength(21,$index,7);
            }
            if ($data[21] != '' && !self::check_number($data[21]))
            {
                $this->error[$index]['bank_account_number']['type'] = self::set_mes_error_data(21,$index);
            }

            //validate: notes
            if (mb_strlen($data[22]) > 500)
            {
                $this->error[$index]['notes']['length'] = self::set_mes_overlength(22,$index,500);
            }

            //validate: usami_branch_code
            if (mb_strlen($data[23]) > 2)
            {
                $this->error[$index]['usami_branch_code']['length'] = self::set_mes_overlength(23,$index,2);
            }
            if ($data[23] != '' && (mb_strlen($data[23]) < 2 || !self::check_number($data[23])))
            {
                $this->error[$index]['usami_branch_code']['type'] = self::set_mes_error_data(23,$index);
            }

            //validate: user_id
            if (strlen($data[24]))
            {
				$user = Model_Muser::find_one_by('name', $data[24]);
                if (!$user)
                {
                    $this->error[$index]['user_id']['exist'] = self::set_mes_not_exist(24,$index);
                }
            }

        }

        if(count($this->error))
        {
            return false;
        }

        return true;
    }

    /**
     * @author huylv6635
     * update db
     * @param $file
     * @return bool
     * @throws Exception
     */
    public function update_csv($file)
    {
        $data = $this->get_file_csv($file);
        if( ! count($data))
        {
            return false;
        }
        foreach ($data as $index => $row) {
            $index = $index + 1;
            $this->validate($row, $index);
        }

        if (count($this->error))
        {
            return false;
        }

        DB::start_transaction();
        try{
            foreach ($data as $index => $row)
            {
                $row[9] = self::convert_tel($row[9]);
                $row[10] = self::convert_tel($row[10]);
                $index = $index + 1;
                $res = $this->mpartner->update_data_csv($row);
                if (!$res)
                {
                    $this->error[$index]['update']['error'] = $index.'行目:更新完了しません。';
                    DB::rollback_transaction();
                    return false;
                }
            }
            DB::commit_transaction();
            return true;
        }
        catch (Exception $e)
        {
            // rollback pending transactional queries
            DB::rollback_transaction();
            throw $e;
        }
    }
}