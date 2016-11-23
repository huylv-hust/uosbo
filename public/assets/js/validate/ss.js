var ss = function(){
    /* SCREEN CREATE SS */
    // validate form ss
    var validate = function(){
        jQuery.validator.addMethod("check_latin", function(value,element) {
            if(value == '') return true;
            if(value.match(/^[a-zA-Z0-9]+$/)) {
                return true;
            }
            return false;
        },'7桁の半角英数字以内で入力してください');
        $('#ss_form').validate({
            groups: {
                zipcode: 'zipcode_first zipcode_last',
                address: 'addr1 addr2',
                tel: "tel_1 tel_2 tel_3"
            },
            rules: {
                partner_code: {
                    required: true
                },
                ss_name: {
                    required: true,
                    check_all_space: true,
                    maxlength: 20
                },
                original_sale: {
                    maxlength: 50
                },
                base_code: {
                    check_latin: true,
                    maxlength: 7
                },
                zipcode_first: {
                    required: true,
                    digits: true,
                    minlength: 3,
                    maxlength: 3
                },
                zipcode_last: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4
                },
                addr1: {
                    required: true
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
                access: {
                    maxlength: 22
                },
                station_name1: {
                    maxlength: 20
                },
                station_walk_time1: {
                    digits: true,
                    max: 99
                },
                station_line1: {
                    maxlength: 20
                },
                station_name2: {
                    maxlength: 20
                },
                station_walk_time2: {
                    digits: true,
                    max: 99
                },
                station_line2: {
                    maxlength: 20
                },
                station_name3: {
                    maxlength: 20
                },
                station1: {
                    maxlength: 50
                },
                station2: {
                    maxlength: 50
                },
                station3: {
                    maxlength: 50
                },
                station_walk_time3: {
                    digits: true,
                    max: 99
                },
                station_line3: {
                    maxlength: 20
                },
                mark_info: {
                    maxlength: 100
                },
                notes: {
                    maxlength_textarea: 500
                }
            },
            messages: {
                partner_code: {
                    required: '取引先(発注先)入力して下さい'
                },
                ss_name: {
                    required: 'SS名を入力して下さい',
                    check_all_space: 'SS名を入力して下さい',
                    maxlength: 'SS名は20文字以内で入力して下さい'
                },
                original_sale: {
                    maxlength: '元売は50文字以内で入力して下さい'
                },
                base_code: {
                    maxlength: '拠点コードは7文字以内で入力して下さい'
                },
                zipcode_first: {
                    required: '郵便番号を入力して下さい',
                    digits: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    maxlength: '郵便番号の指定が正しくありません'
                },
                zipcode_last: {
                    required: '郵便番号を入力して下さい',
                    digits: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    maxlength: '郵便番号の指定が正しくありません'
                },
                addr1: {
                    required: '都道府県を入力して下さい'
                },
                addr2: {
                    required: '市区町村を入力して下さい',
                    check_all_space: '市区町村を入力して下さい',
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
                access:{
                    maxlength: 'アクセスは22文字以内で入力して下さい'
                },
                station_name1: {
                    maxlength: '会社は20文字以内で入力して下さい'
                },
                station_walk_time1: {
                    digits: '徒歩は数字のみで入力して下さい',
                    max: '徒歩は2文字以内で入力して下さい'
                },
                station_line1: {
                    maxlength: '線は20文字以内で入力して下さい'
                },
                station_name2: {
                    maxlength: '会社は20文字以内で入力して下さい'
                },
                station_walk_time2: {
                    digits: '徒歩は数字のみで入力して下さい',
                    max: '徒歩は2文字以内で入力して下さい'
                },
                station_line2: {
                    maxlength: '線は20文字以内で入力して下さい'
                },
                station_name3: {
                    maxlength: '会社は20文字以内で入力して下さい'
                },
                station1: {
                    maxlength: '駅は50文字以内で入力して下さい'
                },
                station2: {
                    maxlength: '駅は50文字以内で入力して下さい'
                },
                station3: {
                    maxlength: '駅は50文字以内で入力して下さい'
                },
                station_walk_time3: {
                    digits: '徒歩は数字のみで入力して下さい',
                    max: '徒歩は2文字以内で入力して下さい'
                },
                station_line3: {
                    maxlength: '線は20文字以内で入力して下さい'
                },
                mark_info: {
                    maxlength: '目印情報は100文字以内で入力して下さい'
                },
                notes: {
                    maxlength_textarea: '備考は500文字以内で入力して下さい'
                }
            }
        });
    };

    var convert_zen2han = function() {
        $('#form_base_code').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_zipcode_first').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_zipcode_last').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_tel').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_station_walk_time1').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_station_walk_time2').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_station_walk_time3').on('change',function(){
            utility.zen2han(this);
        });
    };

    // event submit form ss
    var submit = function(){
        var form = $('#ss_form'),
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

    //click btn back to sslist
    var back_to_sslist = function(){
        $('#btn_sslist_back').off('click').on('click',function(){
            if(confirm(message_confirm_del))
            {
                $(this).closest('form').submit();
            }
        });
    };
    /* END SCREEN CREATE SS */

    /* SCREEN SS LIST */
    // click btn add ss
    var click_add_ss_btn = function(){
        $('#ss_add_btn').click(function(){
            window.location = baseUrl + 'master/ss';
        });
    };

    //click btn active ss
    var click_active_ss_btn = function(){
        $('.ss_btn_active').off('click').on('click',function(){
            if(confirm('有効にします、よろしいですか？'))
            {
                var form = $("#form_search_ss"),
                    ss_id = $(this).closest('tr').find('input.ss_id').val();
                form.attr('action', baseUrl + 'master/ss/accept').attr('method', 'POST');
                $('#ss_id_working').val(ss_id);
                form.submit();
            }
        });
    };

    //click btn deactive ss
    var click_deactive_ss_btn = function(){
        $('.ss_btn_deactive').off('click').on('click',function(){
            if(confirm('無効にします、よろしいですか？')) {
                var form = $("#form_search_ss"),
                    ss_id = $(this).closest('tr').find('input.ss_id').val();
                form.attr("action", baseUrl + "master/ss/reject").attr('method', 'POST');
                $('#ss_id_working').val(ss_id);
                form.submit();
            }
        });
    };

    //click btn delete ss
    var click_delete_ss_btn = function(){
        $('.ss_btn_delete').off('click').on('click',function(){
            if(confirm(message_confirm_del))
            {
                var form = $("#form_search_ss"),
                    ss_id = $(this).closest('tr').find('input.ss_id').val();
                form.attr("action", baseUrl + "master/ss/delete").attr('method', 'POST');
                $('#ss_id_working').val(ss_id);
                form.submit();
            }
        });
    };

    //click btn confirm ss
    var click_confirm_ss_btn = function(){
        $('.ss_btn_confirm').off('click').on('click',function(){
            if(confirm(message_approval_confirm))
            {
                var form = $("#form_search_ss"),
                    ss_id = $(this).closest('tr').find('input.ss_id').val();
                form.attr("action", baseUrl + "master/ss/confirm").attr('method', 'POST');
                $('#ss_id_working').val(ss_id);
                form.submit();
            }
        });
    };

    //remove checked if check on other checkbox
    var click_status_checkbox = function(){
        $('input.ss_status_checkbox').off('click').on('click',function(){
            $('input.ss_status_checkbox').not(this).attr('checked',false);
        });
    };
    /* END SCREEN SS LIST */
    return {
        init:function(){
            validate();
            submit();
            click_add_ss_btn();
            click_active_ss_btn();
            click_deactive_ss_btn();
            click_delete_ss_btn();
            click_status_checkbox();
            click_confirm_ss_btn();
            back_to_sslist();
            convert_zen2han();
        }
    };
}();

var sssale = function(){

    var init_datepicker = function(){
        $('.dateform').datepicker();
    };

    //click btn add
    var click_sssale_add_btn = function(){
        $('#sssale_add_btn').off('click').on('click',function(){
            $('#panel_hidden .dateform').removeClass('hasDatepicker').attr('id','');
            var next_index = ($('#sales .panel').length == 0) ? 0 : parseInt($('#sales .panel:last').find('input[name=panel_index]').val()) + 1;
            $('#panel_hidden input[name=panel_index]').val(next_index);
            var html = $('#panel_hidden').html();
            $(html).appendTo($('div#sales'));
            init_datepicker();
            hide_message();
            validate();
        });
    };

    //click btn delete sssale
    var click_sssale_delete_btn = function(){
        $('.sssale_data_delete_btn').click(function(){
            if(confirm(message_confirm_del))
            {
                $(this).closest('form').submit();
            }
            hide_message();
        });
    };

    var submit = function(){
        $('button[type=submit]').off('click').on('click', function(){
            hide_message();
        });
        $('input[type=text]').off('keypress').on('keypress', function(e){
            if(e.keycode == 13 || e.which == 13) {
                hide_message();
            }
        });
        $(document).on('submit', '.sssale_form', function(){
            var valid = $(this).valid();
            if(valid == false)
                return false;

            if(confirm(message_confirm_save))
                return true;

            return false;
        });
    };

    var validate = function(){
        $('form.sssale_form').each(function () {
            jQuery.validator.addMethod("check_date_sssale", function(value,element) {
                var form = $(element).closest('form'),
                    start = form.find('[name=apply_start_date]').val(),
                    end = form.find('[name=apply_end_date]').val(),
                    start_int = parseInt(start.replace(/-/g,"")),
                    end_int = parseInt(end.replace(/-/g,"")),
                    current = new Date(),
                    current_date = String(current.getDate()),
                    current_month = (current.getMonth() + 1 > 9) ? current.getMonth() + 1 : '0' + (current.getMonth() + 1),
                    current_year = String(current.getFullYear()),
                    current_int = parseInt(String(current_year) + current_month + current_date);

                if((start == '' && end == '') ||
                    (start == '' && end != '' && end_int >= current_int) ||
                    (start != '' && end == '' && start_int >= current_int) ||
                    (start != '' && end != '' && start_int <= end_int && start_int >= current_int))
                    return true;

                return false;
            });
            var form = $(this).closest('form');
            form.validate({
                groups: {
                    free: "free_start_time_hour free_start_time_minute free_end_time_hour free_end_time_minute",
                    constraint: "constraint_start_time_hour constraint_start_time_minute constraint_end_time_hour constraint_end_time_minute",
                    minor: "minor_start_time_hour minor_start_time_minute minor_end_time_hour minor_end_time_minute",
                    night: "night_start_time_hour night_start_time_minute night_end_time_hour night_end_time_minute",
                    apply_date: "apply_start_date apply_end_date"
                },
                rules: {
                    sale_name: {
                        maxlength: 100
                    },
                    free_hourly_wage: {
                        digits: true,
                        min: 1,
                        max: 2147483647
                    },
                    free_recruit_attr: {
                        maxlength: 20
                    },
                    constraint_hourly_wage: {
                        digits: true,
                        min: 1,
                        max: 2147483647
                    },
                    constraint_recruit_attr: {
                        maxlength: 20
                    },
                    minor_hourly_wage: {
                        digits: true,
                        min: 1,
                        max: 2147483647
                    },
                    minor_recruit_attr: {
                        maxlength: 20
                    },
                    night_hourly_wage: {
                        digits: true,
                        min: 1,
                        max: 2147483647
                    },
                    night_recruit_attr: {
                        maxlength: 20
                    },
                    apply_start_date: {
                        date_format: true,
                        check_date_sssale: true
                    },
                    apply_end_date: {
                        date_format: true,
                        check_date_sssale: true
                    }
                },
                messages: {
                    sale_name: {
                        maxlength: '形態管理名称は100文字以内で入力して下さい'
                    },
                    free_hourly_wage: {
                        digits: '時給は数数字のみで入力して下さい',
                        min: '時給は数数字のみで入力して下さい',
                        max: '範囲内の数値を入力してください。'
                    },
                    free_recruit_attr: {
                        maxlength: '募集属性は20文字以内で入力して下さい'
                    },
                    constraint_hourly_wage: {
                        digits: '時給は数数字のみで入力して下さい',
                        min: '時給は数数字のみで入力して下さい',
                        max: '範囲内の数値を入力してください。'
                    },
                    constraint_recruit_attr: {
                        maxlength: '募集属性は20文字以内で入力して下さい'
                    },
                    minor_hourly_wage: {
                        digits: '時給は数数字のみで入力して下さい',
                        min: '時給は数数字のみで入力して下さい',
                        max: '範囲内の数値を入力してください。'
                    },
                    minor_recruit_attr: {
                        maxlength: '募集属性は20文字以内で入力して下さい'
                    },
                    night_hourly_wage: {
                        digits: '時給は数数字のみで入力して下さい',
                        min: '時給は数数字のみで入力して下さい',
                        max: '範囲内の数値を入力してください。'
                    },
                    night_recruit_attr: {
                        maxlength: '募集属性は20文字以内で入力して下さい'
                    },
                    apply_start_date: {
                        date_format: '利用の期間が正しくありません',
                        check_date_sssale: '入力した期間が正しくありません'
                    },
                    apply_end_date: {
                        date_format: '利用の期間が正しくありません',
                        check_date_sssale: '入力した期間が正しくありません'
                    }
                }
            });
        });
    };

    var hide_message = function(){
        $('div.sssale_message').hide();
    };

    var convert_zen2han = function() {
        $('#form_tel_1, #form_tel_2, #form_tel_3').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_free_hourly_wage').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_constraint_hourly_wage').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_minor_hourly_wage').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_night_hourly_wage').on('change',function(){
            utility.zen2han(this);
        });
    };

    return {
        init:function(){
            click_sssale_add_btn();
            click_sssale_delete_btn();
            validate();
            init_datepicker();
            submit();
            convert_zen2han();
        }
    }
}();

$(function(){
    ss.init();
    sssale.init();
});
