//date format
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


(function ($, W, D)
{
    var validation = {};

    validation.util =
            {
                setupFormValidation: function ()
                {
                    jQuery.validator.addMethod("check_latin", function(value,element) {
                        if(value == '') return true;
                        if(value.match(/^[a-zA-Z0-9]+$/)) {
                            return true;
                        }
                        return false;
                    });

                    jQuery.validator.addMethod("validate_obic7_required", function(value,element) {
                        if($('#form_obic7_flag').is(':checked') && $('#form_employee_code').val() == '') {
                            return false;
                        }
                        return true;
                    }, '社員コードが未入力です');

                    jQuery.validator.addMethod("validate_obic7_interview", function(value,element) {
                        var result = true;
                        if($('#form_obic7_flag').is(':checked')) {
                            var param = {
                                person_id: $('#person_id').val()
                            };
                            var request = $.ajax({
                                type: 'post',
                                data: param,
                                url: baseUrl + 'job/employment/check_interview_has_data',
                                async: false
                            });
                            var response = request.done(function(data){
                                data = jQuery.parseJSON(data);
                                if(!data.status) {
                                    result = false;
                                }
                            });
                        }
                        return result;
                    }, '面接票が未設定です');

                    jQuery.validator.addMethod("validate_obic7_emcall", function(value,element) {
                        var result = true;
                        if($('#form_obic7_flag').is(':checked')) {
                            var param = {
                                person_id: $('#person_id').val()
                            };
                            var request = $.ajax({
                                type: 'post',
                                data: param,
                                url: baseUrl + 'job/employment/check_emcall_has_data',
                                async: false
                            });
                            var response = request.done(function (data) {
                                data = jQuery.parseJSON(data);
                                if (!data.status) {
                                    result = false;
                                }
                            });
                        }
                        return result;
                    }, '緊急連絡先が未設定です');
                    //form validation rules
                    $("#employment").validate({
                        errorPlacement: function (error, element) {
                            var err = element.parents('td');
                            $(err).append(error);

                        },
                        rules: {
                            review_date: {
                                date: true,
                                dateformat: true
                            },
                            register_date: {
                                date: true,
                                dateformat: true
                            },
                            contract_date: {
                                date: true,
                                dateformat: true
                            },
                            hire_date: {
                                date: true,
                                dateformat: true
                            },
                            code_registration_date: {
                                date: true,
                                dateformat: true
                            },
                            employee_code: {
                                digits: true,
                                minlength: 8
                            },
                            registration_expiration: {
                                date_format: true,
                                required: true
                            },
                            obic7_flag: {
                                validate_obic7_required: true,
                                validate_obic7_interview: true,
                                validate_obic7_emcall: true
                            }
                        },

                        messages: {

                            review_date: {
                                date: "面接日の指定が正しくありません"
                            },
                            register_date: {
                                date: "登録更新日の指定が正しくありません"
                            },
                            contract_date: {
                                date: "契約締結日の指定が正しくありません"
                            },
                            hire_date: {
                                date: "入社日の指定が正しくありません"
                            },
                            code_registration_date: {
                                date: "社員コード登録日の指定が正しくありません"
                            },
                            employee_code: {
                                digits: '数字8桁で入力して下さい。',
                                minlength: '数字8桁で入力して下さい。'
                            },
                            registration_expiration: {
                                date_format: '登録有効期限は正しくありません。',
                                required: '登録有効期限を入力して下さい'
                            }

                        },

                        submitHandler: function (form) {
                            var value = $('#form_employee_code').val();
                            if (value.length == 8 && value.match(/^[0-9]+$/))
                            {
                                var result = true;

                                var param = {
                                    employee_code: $('#form_employee_code').val(),
                                    person_id: $('#person_id').val()
                                };
                                var request = $.ajax({
                                    type: 'post',
                                    data: param,
                                    url: baseUrl + 'job/employment/check_employee_code',
                                    async: false
                                });
                                var response = request.done(function(data){
                                    data = jQuery.parseJSON(data);
                                    if(!data.status) {
                                        result = false;
                                    }

                                });
                                if(!result) {
                                    $('#form_employee_code-error').html('登録済み社員コードです').show();
                                    return false;
                                }
                            }
                            form.submit();
                        }
                    });
                }
            };
    var convert_zen2han = function(){
        $(document).on('change','#form_employee_code', function(){
            utility.zen2han(this);
        });
    };

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        convert_zen2han();
        validation.util.setupFormValidation();
    });

})(jQuery, window, document);

