$.validator.addMethod("dateformat", function (value, element) {
    if (value == '') {
        return true;
    }
    if (value.match(/^\d{4}-\d{2}-\d{2}$/)) {

        var arr_date = value.split('-');
        if (arr_date['1'] > 12 || arr_date['2'] > 31)
        {
            return false;
        }
        return true;
    } else {
        return false;
    }
}, "利用の期間が正しくありません");

$.validator.addMethod("emailformat", function (value, element) {
    if(value =='')
        return true;
    var emailReg = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return emailReg.test( value );
}, "メールアドレスが正しくありません");


$.validator.addMethod("kanji", function (value, element) {
    if(/^([一-龥]|\s)+$/.test(value)) {
        return true;
    }
    return false;
}, "漢字を入力してください");

$.validator.addMethod("kana", function (value, element) {
    if(/^([ぁ-んー　]|\s)+$/.test(value)) {
        return true;
    }
    return false;
}, "かなを入力してください");

$.validator.addMethod("check_order_id", function (value, element) {
    if(value.trim() == '')
    {
        $("#detail_order_id").html('');
        return true;
    };
    var result = false;
    var request = $.ajax({
        type: 'post',
        data: {order_id:value},
        url: baseUrl + 'job/person/check_order',
        async:false,
        dataType:'json'
    });
    var response = request.done(function(data){
        if(data.message != undefined) {
            result = data.message;
            if(result){
                $("#detail_order_id").html('<a href="'+baseUrl+'job/order?order_id='+value+'" target="_blank" class="btn btn-sm btn-info">オーダー内容を確認</a>');
            }
            else
            {
                $("#detail_order_id").html('');
            }
        }

    });
    return result;
}, "入力したオーダーＩＤが存在していません。");

(function ($, W, D)
{
    var validation = {};

    validation.util =
            {
                setupFormValidation: function ()
                {
                    $.validator.setDefaults({
                        ignore: []
                        // any other default options and/or rules
                    });
                    //form validation rules
                    $("#person").validate({
                        errorPlacement: function (error, element) {
                            var err = element.parents('td');
                            $(err).append(error);
                            var err1 = element.parents('.text-info');
                            $(err1).after(error);
                            var err2 = element.parents('.text-info');
                            $(err2).after(error);
                        },
                        rules: {
                            order_id: {
                                digits :true,
                                check_order_id: true
                            },
                            zipcode1: {
                                required: false,
                                rangelength: [3, 3],
                                digits :true
                            },
                            zipcode2: {
                                required: false,
                                rangelength: [4, 4],
                                digits :true
                            },
                            birthday: {
                                date_format: true,
                            },
                            application_date_d: {
                                date: true,
                                date_format: true,
                            },
                            addr2: {
                                maxlength: 20
                            },
                            addr3: {
                                maxlength: 50
                            },
                            mobile_1: {
                                required: function() {
                                    if ($('#form_mobile_2').val() != '' || $('#form_mobile_3').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_tel_1').val() == '' && $('#form_tel_2').val() == '' && $('#form_tel_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            mobile_2: {
                                required: function() {
                                    if ($('#form_mobile_1').val() != '' || $('#form_mobile_3').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_tel_1').val() == '' && $('#form_tel_2').val() == '' && $('#form_tel_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            mobile_3: {
                                required: function() {
                                    if ($('#form_mobile_2').val() != '' || $('#form_mobile_1').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_tel_1').val() == '' && $('#form_tel_2').val() == '' && $('#form_tel_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            tel_1: {
                                required: function() {
                                    if ($('#form_tel_2').val() != '' || $('#form_tel_3').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_mobile_1').val() == '' && $('#form_mobile_2').val() == '' && $('#form_mobile_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            tel_2: {
                                required: function() {
                                    if ($('#form_tel_1').val() != '' || $('#form_tel_3').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_mobile_1').val() == '' && $('#form_mobile_2').val() == '' && $('#form_mobile_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            tel_3: {
                                required: function() {
                                    if ($('#form_tel_2').val() != '' || $('#form_tel_1').val() != '') {
                                        return true;
                                    }
                                    if ($('#form_mobile_1').val() == '' && $('#form_mobile_2').val() == '' && $('#form_mobile_3').val() == '') {
                                        return true;
                                    }
                                    return false;
                                },
                                digits :true,
                            },
                            mail_addr1: {
                                emailformat: true,
                                maxlength: 50
                            },
                            mail_addr2: {
                                emailformat: true,
                                maxlength: 50
                            },
                            walk_time :{
                                digits :true,
                                maxlength: 3
                            },
                            sssale_id: {
                                required: true,
                            },
                            workplace_sssale_id: {
                                required: true,
                            },
                            name: {
                                maxlength: 20
                            },
                            name_kana: {
                                required: true,
                                maxlength: 20,
                                kana:true
                            },
                            repletion:{
                                maxlength: 100
                            },
                            employment_time:{
                                maxlength:50
                            },
                            job_career:{
                                maxlength:500
                            },
                            self_pr:{
                                maxlength:500
                            },
                            notes:{
                                maxlength_textarea:500
                            },
                            application_date_d :{
                                 required: true
                            },
                            age: {
                                digits: true,
                                min:1,
                                max:199
                            }
                        },
                        groups: {
                            username: "zipcode1 zipcode2",
                            phone: "mobile_1 mobile_2 mobile_3 tel_1 tel_2 tel_3",
                        },
                        messages: {
                            order_id: {
                                digits: 'オーダーIDの指定が正しくありません'
                            },
                            zipcode1: {
                                required: "郵便番号を入力してください",
                                rangelength: "郵便番号の指定が正しくありません",
                                digits: '郵便番号の指定が正しくありません',
                            },
                            zipcode2: {
                                required: "郵便番号を入力してください",
                                rangelength: "郵便番号の指定が正しくありません",
                                digits: '郵便番号の指定が正しくありません',
                            },
                            addr2: {
                                maxlength:'都道府県は20文字以内で入力してください'
                            },
                            addr3: {
                                maxlength:'以降の住所は50文字以内で入力してください'
                            },
                            mobile_1: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            mobile_2: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            mobile_3: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            tel_1: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            tel_2: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            tel_3: {
                                required: "電話番号を入力してください",
                                digits: '数字のみで入力して下さい',
                            },
                            birthday: {
                                date_format: "日付の指定が正しくありません",
                            },
                            application_date_d: {
                                date_format: "応募日時の指定が正しくありません",
                            },
                            walk_time : {
                                digits: '数字のみで入力して下さい',
                                maxlength: '徒歩は3文字以内で入力してください'
                            },
                            sssale_id: {
                                required: "必須です",
                            },
                            workplace_sssale_id: {
                                required: "必須です",
                            },
                            name: {
                                maxlength:'漢字は20文字以内で入力してください'
                            },
                            name_kana: {
                                required: "必須です",
                                maxlength:'かなは20文字以内で入力してください'
                            },
                            mail_addr1: {
                                maxlength:'メールアドレス1は50文字以内で入力してください',
                            },
                            mail_addr2: {
                                maxlength:'メールアドレス2は50文字以内で入力してください'
                            },
                            repletion:{
                                maxlength:'現在職業補足は100文字以内で入力してください'
                            },
                            employment_time:{
                                maxlength:'就業可能時期は50文字以内で入力してください'
                            },
                            job_career:{
                                maxlength:'職務経歴は500文字以内で入力してください'
                            },
                            self_pr:{
                                maxlength:'自己PRは500文字以内で入力してください'
                            },
                            notes:{
                                maxlength_textarea:'希望・備考など500文字以内で入力してください'
                            },
                            application_date_d:{
                                required: "必須です"
                            },
                            age: {
                                digits: '年齢は1～199以内の数字で入力してください。',
                                min:'年齢は1～199以内の数字で入力してください。',
                                max:'年齢は1～199以内の数字で入力してください。'
                            }
                        },
                        submitHandler: function (form) {
                            if (!confirm('保存します、よろしいですか？')) {
                                return false;
                            }
                            form.submit();
                        }
                    });
                }
            };

    var update_date = function()
    {
        $('#form_year').on('change',function()
        {
            change_birthday();
            status_input_age();
        });
        $('#form_month').on('change',function()
        {
            change_birthday();
            status_input_age();
        });
        $('#form_day').on('change',function()
        {
            change_birthday();
            status_input_age();
        });
    };

    var status_input_age = function() {
        var form_year = $('#form_year').val(),
            form_month = $('#form_month').val(),
            form_day = $('#form_day').val();

        if(form_year != '' && form_month != '' && form_day != '') {
            $('#form_age').val('').attr('disabled', true);
        } else {
            $('#form_age').attr('disabled', false);
        }
    };

    var change_birthday = function()
    {
        var year = $('#form_year').val();
        var month = $('#form_month').val();
        var day = $('#form_day').val();
        if(year != '' || month != '' || day != '')
            var birthday = year+'-'+month+'-'+day;
        else
            var birthday = '';
        $('#form_birthday').attr('value',birthday);
    };

    var change_status = function()
    {
        $('.person-agree').click(function(){
            if( ! confirm('承認します、よろしいですか？')) return false;
            var person_id = $(this).attr('value');
            $('#form-person_id').attr('value',person_id);
            $('#form-person_status').attr('value',1);
            $('#list-persons').attr('action',baseUrl+'job/person/approval');
            $('#list-persons').attr('method','post');
            $('#list-persons').submit();
        });
        $('.person-invalidation').click(function(){
            if( ! confirm('無効にします、よろしいですか？')) return false;
            var person_id = $(this).attr('value');
            $('#form-person_id').attr('value',person_id);
            $('#form-person_status').attr('value',0);
            $('#list-persons').attr('action',baseUrl+'job/person/approval');
            $('#list-persons').attr('method','post');
            $('#list-persons').submit();
        });
    };

    var convert_zen2han = function () {
        $('#form_mobile_1, #form_mobile_2, #form_mobile_3').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_tel_1, #form_tel_2, #form_tel_3').on('change', function () {
            utility.zen2han(this);
        });

        $('#form_zipcode1').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_zipcode2').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_walk_time').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_order_id').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_age').on('change', function () {
            utility.zen2han(this);
        })
    };

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        change_status();
        update_date();
        validation.util.setupFormValidation();
        convert_zen2han();
        status_input_age();
    });


})(jQuery, window, document);

