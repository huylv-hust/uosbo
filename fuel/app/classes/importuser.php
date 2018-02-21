<?php

use Fuel\Core\DB;

class Importuser
{
    public $error = array();
    public $no_update = array();
    private $muser;

    function __construct()
    {
        $this->muser = new Model_Muser();
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
            '0' => 'ID',
            '1' => '所属',
            '2' => '権限区分',
            '3' => '氏名',
            '4' => 'ログインID',
            '5' => 'メールアドレス',
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
        if (mb_detect_encoding($data, 'UTF-8', true) === false) {
            $encode_ary = array(
                'ASCII',
                'JIS',
                'eucjp-win',
                'sjis-win',
                'EUC-JP',
                'UTF-8',
            );
            $data = mb_convert_encoding($data, 'UTF-8', $encode_ary);
        }

        $fp = tmpfile();
        fwrite($fp, $data);
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
        $fp = self::convert_utf8($file);
        $header = fgetcsv($fp);
        if(count($header) != 6)
        {
            $this->error[0]['title']['type'] = '1行目:CSVファイルのフォーマットが正しくありません。';
        }
        $arr_data = array();
        $index = 2;
        while (($data = fgetcsv($fp, 10000, ',')) !== false) {
            $arr_data[$index] = $data;
            $index++;
        }

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
    static public function set_mes_overlength($key, $index, $num)
    {
        $all_field = self::all_field();
        return $index . '行目:' . $all_field[$key] . 'は' . $num . '文字以内で入力して下さい。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_error_data($key, $index)
    {
        $all_field = self::all_field();
        return $index . '行目:' . $all_field[$key] . 'が正しくありません。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_required($key, $index)
    {
        $all_field = self::all_field();
        return $index . '行目:' . $all_field[$key] . 'を入力して下さい。';
    }

    /**
     * @author huylv6635
     * set message for validate
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_not_exist($key, $index)
    {
        $all_field = self::all_field();
        return $index . '行目:' . $all_field[$key] . 'が存在しません。';
    }

    /**
     * @author huylv6635
     * @param $key
     * @param $index
     * @return string
     */
    static public function set_mes_exist($key, $index)
    {
        $all_field = self::all_field();
        return $index . '行目:' . $all_field[$key] . 'が存在しました。';
    }

    /**
     * @author huylv6635
     * validate latin
     * @param $data
     * @return int
     */
    static public function check_latin($data)
    {
        if (trim($data) == '') {
            return false;
        }
        return preg_match('/^[0-9a-zA-Z]+$/', $data);
    }

    /**
     * @author huylv6635
     * validate email
     * @param $data
     * @return bool|string
     */
    static public function check_mail($data)
    {
        if (trim($data) == '') {
            return trim($data);
        }
        $mail = '';
        $mail_temp = explode(',', $data);
        foreach ($mail_temp as $k => $v) {
            if ($v == '' || filter_var($v, FILTER_VALIDATE_EMAIL)) {
                $mail .= $v . ',';
            } else {
                return false;
            }
        }
        return trim($mail, ',');
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
        if (count($data) != 6) {
            $this->error[$index]['file_error']['type'] = $index . '行目のフォーマットが正しくありません。';

            return array();
        }

        //validate: user_id
        if (trim($data[0]) != '') {
            $result = $this->muser->find_by_pk($data[0]);
            if (!$result) {
                $this->error[$index]['user_id']['exist'] = self::set_mes_not_exist(0, $index);
            }
        }

        //validate: department_id
        if ($data[1] == '') {
            $this->error[$index]['department_id']['required'] = self::set_mes_required(1, $index);
        } elseif (!array_search($data[1], Constants::$department)) {
            $this->error[$index]['department_id']['exist'] = self::set_mes_not_exist(1, $index);
        }

        //validate: division_type
        if ($data[2] == '') {
            $this->error[$index]['division_type']['required'] = self::set_mes_required(2, $index);
        } elseif (!array_search($data[2], Constants::$division_type)) {
            $this->error[$index]['division_type']['exist'] = self::set_mes_not_exist(2, $index);
        }

        //validate: name
        if (trim($data[3]) == '') {
            $this->error[$index]['name']['required'] = self::set_mes_required(3, $index);
        } elseif (strlen(trim($data[3])) > 100) {
            $this->error[$index]['name']['length'] = self::set_mes_overlength(3, $index, 100);
        }

        //validate: login_id
        if (trim($data[4]) == '') {
            $this->error[$index]['login_id']['required'] = self::set_mes_required(4, $index);
        }elseif (strlen($data[4]) > 8) {
            $this->error[$index]['login_id']['length'] = self::set_mes_overlength(4, $index, 8);
        }elseif (!self::check_latin($data[4])) {
            $this->error[$index]['login_id']['type'] = self::set_mes_error_data(4, $index);
        } else {
            //check unique
            if (!$this->muser->validate_unique_login_id($data[4], $data[0])) {
                $this->error[$index]['login_id']['exist'] = self::set_mes_exist(4, $index);
            }
        }

        //validate: mail
        if (self::check_mail($data[5]) === false) {
            $this->error[$index]['mail']['type'] = self::set_mes_error_data(5, $index);
        }

        if (count($this->error)) {
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
        // get data from csv
        $data = $this->get_file_csv($file);
        if (!count($data)) {
            return false;
        }

        // start validate data
        foreach ($data as $index => $row) {
            $this->validate($row, $index);
        }

        if (count($this->error)) {
            return false;
        }

        // start save data
        DB::start_transaction();
        try {
            foreach ($data as $index => $row) {
                //set email
                $row[5] = self::check_mail($row[5]);

                $result = $this->muser->update_data_csv($row);
                if (!$result) {
                    $this->error[$index]['update']['error'] = $index . '行目:更新完了しません。';
                    DB::rollback_transaction();
                    return false;
                }
            }
            DB::commit_transaction();
            return true;
        } catch (Exception $e) {
            // rollback pending transactional queries
            DB::rollback_transaction();
            throw $e;
        }
    }
}
