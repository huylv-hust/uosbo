<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 16/6/2017
 * Time: 1:07 PM
 */
class Exportuser
{
    static function title()
    {
        $title = array(
            '0'  => 'ID',
            '1'  => '所属',
            '2'  => '権限区分',
            '3'  => '氏名',
            '4'  => 'ログインID',
            '5'  => 'メールアドレス',
        );

        return $title;
    }

    static function set_data($row)
    {
        $data = array(
            '0' => $row['user_id'],
            '1' => Constants::$department[$row['department_id']],
            '2' => Constants::$division_type[$row['division_type']],
            '3' => $row['name'],
            '4' => $row['login_id'],
            '5' => isset($row['mail']) ? $row['mail'] : ''
        );

        return $data;
    }
}
