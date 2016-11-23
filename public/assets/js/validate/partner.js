var partners = function(){
    // validate form ss
    var ready = function(){
        $(function(){
            $('[name=add-btn]').on('click', function()
            {
                window.location = baseUrl + 'master/partner';
            });
        });
    };

    var validate = function(){
        $('#form_partner').validate({
            groups: {
                zipcode: "zipcode_p1 zipcode_p2",
                addr: "addr1 addr2",
                tel: "tel_1 tel_2 tel_3",
                fax: "fax_1 fax_2 fax_3"
            },
            rules: {
                type:{
                    required: true,
                    check_all_space: true
                },
                master_num: {
                    maxlength: 50,
                    digits: true
                },
                m_group_id: {
                    required: true,
                    check_all_space: true
                },
                branch_name: {
                    required: true,
                    check_all_space: true,
                    maxlength: 20
                },
                zipcode_p1: {
                    required: true,
                    check_all_space: true,
                    minlength: 3,
                    maxlength: 3,
                    digits: true
                },
                user_id: {
                    required: function(){
                        if($('.form_type:checked').val() == 1)
                            return true;
                        else
                            return false;
                    }
                },
                department_id: {
                    required: function(){
                        if($('.form_type:checked').val() == 1)
                            return true;
                        else
                            return false;
                    }
                },
                zipcode_p2: {
                    required: true,
                    check_all_space: true,
                    minlength: 4,
                    maxlength: 4,
                    digits: true
                },
                addr1: {
                    required: true,
                    check_all_space: true
                },
                addr2: {
                    required: true,
                    check_all_space: true,
                    maxlength: 10
                },
                addr3: {
                    maxlength: 50
                },
                tel_1: {
                    required: function() {
                        if ($('#form_tel_2').val() != '' || $('#form_tel_3').val() != '') {
                            return true;
                        }
                        return true;
                    },
                    digits :true,
                },
                tel_2: {
                    required: function() {
                        if ($('#form_tel_1').val() != '' || $('#form_tel_3').val() != '') {
                            return true;
                        }
                        return true;
                    },
                    digits :true,
                },
                tel_3: {
                    required: function() {
                        if ($('#form_tel_2').val() != '' || $('#form_tel_1').val() != '') {
                            return true;
                        }
                        return true;
                    },
                    digits :true,
                },
                fax_1: {
                    required: function() {
                        if ($('#form_fax_2').val() != '' || $('#form_fax_3').val() != '') {
                            return true;
                        }
                        return false;
                    },
                    digits :true,
                },
                fax_2: {
                    required: function() {
                        if ($('#form_fax_1').val() != '' || $('#form_fax_3').val() != '') {
                            return true;
                        }
                        return false;
                    },
                    digits :true,
                },
                fax_3: {
                    required: function() {
                        if ($('#form_fax_2').val() != '' || $('#form_fax_1').val() != '') {
                            return true;
                        }
                        return false;
                    },
                    digits :true,
                },
                billing_department: {
                    maxlength: 10
                },
                billing_tel: {
                    maxlength: 11,
                    digits: true,
                    tel_format: true
                },
                billing_fax: {
                    maxlength: 11,
                    digits: true
                },
                billing_deadline_day: {
                    digits: true,
                    max: 99
                },
                payment_day: {
                    digits: true,
                    max: 99
                },
                billing_start_date: {
                    date_format: true
                },
                bank_name: {
                    maxlength: 10
                },
                bank_branch_name: {
                    maxlength: 10
                },
                bank_account_number: {
                    digits: true,
                    maxlength: 7
                },
                notes: {
                    maxlength_textarea: 500
                },
                usami_branch_code: {
                    minlength: 2,
                    digits: true
                }
            },
            messages: {
                type:{
                    required: '取引先区分を入力して下さい'
                },
                master_num: {
                    maxlength: '顧客マスタ番号は50文字以内で入力して下さい',
                    digits: '顧客マスタ番号は数字のみで入力して下さい'
                },
                m_group_id: {
                    required: '所属を入力して下さい'
                },
                branch_name: {
                    required: '取引先(支店)名を入力して下さい',
                    maxlength: '取引先(支店)名は20文字以内で入力して下さい'
                },
                zipcode_p1: {
                    required: '郵便番号を入力して下さい',
                    maxlength: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    digits: '郵便番号は数字のみで入力して下さい'
                },
                zipcode_p2: {
                    required: '郵便番号を入力して下さい',
                    maxlength: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    digits: '郵便番号は数字のみで入力して下さい'
                },
                user_id: {
                    required: '担当営業を入力して下さい'
                },
                department_id: {
                    required: '担当部門を入力して下さい'
                },
                addr1: {
                    required: '都道府県を入力して下さい'
                },
                addr2: {
                    required: '市区町村を入力して下さい',
                    maxlength: '市区町村は10文字以内で入力して下さい'
                },
                addr3: {
                    maxlength: '以降の住所は50文字以内で入力して下さい'
                },
                tel_1: {
                    required: "電話番号を入力してください",
                    digits: '数字のみで入力して下さい'
                },
                tel_2: {
                    required: "電話番号を入力してください",
                    digits: '数字のみで入力して下さい'
                },
                tel_3: {
                    required: "電話番号を入力してください",
                    digits: '数字のみで入力して下さい'
                },
                fax_1: {
                    required: 'FAXを入力してください',
                    digits: 'FAXは数字のみで入力して下さい'
                },
                fax_2: {
                    required: 'FAXを入力してください',
                    digits: 'FAXは数字のみで入力して下さい'
                },
                fax_3: {
                    required: 'FAXを入力してください',
                    digits: 'FAXは数字のみで入力して下さい'
                },
                billing_department: {
                    maxlength: '請求先部署は10文字以内で入力して下さい'
                },
                billing_tel: {
                    maxlength: '請求先電話番号は11文字以内で入力して下さい',
                    digits: '請求先電話番号は数字のみで入力して下さい'
                },
                billing_fax: {
                    maxlength: '請求先FAXは11文字以内で入力して下さい',
                    digits: '請求先FAXは数字のみで入力して下さい'
                },
                billing_deadline_day: {
                    digits: '請求先〆日は数字のみで入力して下さい',
                    max: '請求先〆日は範囲内の数値を入力してください'
                },
                payment_day: {
                    digits: '支払日は数字のみで入力して下さい',
                    max: '支払日は範囲内の数値を入力してください'
                },
                billing_start_date: {
                    date_format: '日付の指定が正しくありません'
                },
                bank_name: {
                    maxlength: '銀行名は10文字以内で入力して下さい'
                },
                bank_branch_name: {
                    maxlength: '銀行支店名は10文字以内で入力して下さい'
                },
                bank_account_number: {
                    digits: '銀行口座番号を入力して下さい',
                    maxlength: '銀行口座番号は7文字以内で入力して下さい'
                },
                notes: {
                    maxlength_textarea: '備考は500文字以内で入力して下さい'
                },
                usami_branch_code: {
                    minlength: '宇佐美支店番号が正しくありません',
                    digits: '宇佐美支店番号が正しくありません'
                }
            }
        });
    };

    var convert_zen2han = function() {
        $('#form_master_num').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_master_num').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_zipcode_p1').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_zipcode_p2').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_tel_1, #form_tel_2, #form_tel_3').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_fax_1, #form_fax_2, #form_fax_3').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_billing_tel').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_billing_fax').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_billing_deadline_day').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_payment_day').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_bank_account_number, #form_usami_branch_code').on('change', function () {
            utility.zen2han(this);
        });
    };

    var zip_code = function(){
        $('#form_zipcode_p1').keyup(function(){
            var zipcode1 = $(this).val();
            if(zipcode1.length === 3){
                $('#form_zipcode_p2').focus();
            }
        });
    };


    //event change department
    var change_department = function(){
        $('#form_department').on('change',function(){
            $('#form_user_id').html('<option value="">担当者を選択してください</option>');
            var department_id = $(this).val();
            $.ajax({
                url: baseUrl+'master/partner/change_department',
                method: 'post',
                data: {department_id: department_id},
                dataType: 'json'
            })
                .success(function(data){
                    var strString = '<option value="">担当者を選択してください</option>';
                    $.each(data,function(k,v){
                        strString += '<option value="'+ v.user_id+'">'+ v.name +'</option>';
                    });
                    $('#form_user_id').html(strString);
                });
        });

        $('#form_department_id').on('change',function(){
            var department_id = $(this).val();
            if($('#form_department').val() == '')
            {
                $('#form_department').val(department_id);
                $('#form_department').trigger('change');
            }
        });
    };

    // event submit form
    var submit = function(){
        var form = $('#form_partner'),
            valid;
        form.on('submit', function() {
            valid = form.valid();
            if(valid == false)
                return false;

            if(confirm(message_confirm_save))
                return true;

            return false;
        });
    };


    var edit = function(){
        $('.edit_partner').click(function(){
            var partner_code = $(this).attr('value');
            var url = baseUrl + 'master/partner/index/'+partner_code;
            window.location = url;
        });
    };
    var approval = function(){
        $('.approval_partner').click(function() {
            if( ! confirm(message_approval_confirm)) return false;
            var partner_code = $(this).attr('value');
            var url = baseUrl + 'master/partner/approval';
            $('#action_partner_code').val(partner_code);
            $('#form-partner-list').attr('method','post');
            $('#form-partner-list').attr('action',url);
            $('#form-partner-list').submit();
        });
    };
    var deletes = function(){
        $('.delete_partner').click(function(){
            if( ! confirm(message_confirm_del)) return false;
            var partner_code = $(this).attr('value');
            var url = baseUrl + 'master/partner/delete';
            $('#action_partner_code').val(partner_code);
            $('#form-partner-list').attr('method','post');
            $('#form-partner-list').attr('action',url);
            $('#form-partner-list').submit();
        });
    };
    return {
        init:function(){
            ready();
            zip_code();//Check event keyup of zip code 1, if equal 4 char jump zip code 2
            change_department();
            validate();
            submit();
            edit();
            approval();
            deletes();
            convert_zen2han();
        }
    };
}();

$(function(){
    partners.init();
});
