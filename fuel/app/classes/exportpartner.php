<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 12/6/2016
 * Time: 1:07 PM
 */
class Exportpartner
{
    static function title()
    {
        $title = array(
            '0'  => '取引先コード',
            '1'  => '取引先区分',
            '2'  => 'Staff2000顧客マスタ番号',
            '3'  => '所属',
            '4'  => '取引先(支店)名',
            '5'  => '郵便番号',
            '6'  => '都道府県',
            '7'  => '市区町村',
            '8'  => '以降の住所',
            '9'  => '電話番号',
            '10' => 'FAX',
            '11' => '担当部門',
            '12' => '請求先部署',
            '13' => '請求先電話番号',
            '14' => '請求先FAX',
            '15' => '請求先〆日',
            '16' => '支払日',
            '17' => '取引開始年月日',
            '18' => '銀行名',
            '19' => '銀行支店名',
            '20' => '銀行口座種別',
            '21' => '銀行口座番号',
            '22' => '備考',
            '23' => '宇佐美支店番号',
            '24' => '担当営業',
        );

        return $title;
    }

    static function set_data($row)
    {
        $data = array(
            '0' => $row['partner_code'],
            '1' => Constants::$_type_partner[$row['type']],
            '2' => $row['master_num'],
            '3' => $row['group_name'],
            '4' => $row['branch_name'],
            '5' => $row['zipcode'],
            '6' => Constants::$address_1[$row['addr1']],
            '7' => $row['addr2'],
            '8' => $row['addr2'],
            '9' => $row['tel'],
            '10' => trim($row['fax'], '-') == '' ? '' : $row['fax'],
            '11' => isset(Constants::$department[$row['partner_department_id']]) ? Constants::$department[$row['partner_department_id']] : '',
            '12' => $row['billing_department'],
            '13' => $row['billing_tel'],
            '14' => $row['billing_fax'],
            '15' => $row['billing_deadline_day'],
            '16' => $row['payment_day'],
            '17' => $row['billing_start_date'],
            '18' => $row['bank_name'],
            '19' => $row['bank_branch_name'],
            '20' => Constants::$bank_type[$row['bank_type']],
            '21' => $row['bank_account_number'],
            '22' => $row['notes'],
            '23' => $row['usami_branch_code'],
            '24' => $row['user_name'],
        );

        return $data;
    }
}