var interview = function(){
    var ready = function(){
        $('input[name=experience_request]').on('change', function()
        {
            if ($(this).val() == "1")
            {
                $('#experience-block input').prop('readonly', false);
            }
            else
            {
                $('#experience-block input').prop('readonly', true).val('');
            }
        });

        if ($('input[name="experience_request"]:checked').val() == "0")
        {
            $('#experience-block input').prop('readonly', true).val('');
        }
    };


    var validate = function(){
        jQuery.validator.addMethod('cheked_night_shift_allowed',function(value, element){
            if($('#form_night_shift_allowed:checked').val() > 0 && (value == null || value == ''))
                return false;
            else
                return true;
        },'Validate check night shift allowed');

        jQuery.validator.addMethod('checked_weekend_is',function(value, element){
            if($('#form_weekend_is:checked').val() > 0 && (value == null || value == ''))
                return false;
            else
                return true;
        },'Validate check weekend');

        jQuery.validator.addMethod('myfloat',function(value,element){
            if(value == '' || value == 0 || value.match(/^(\d)*$/) || value.match(/^\d.\d{1}$/) || value.match(/^(\d)*.\d{1}$/))
            {
                return true;
            }
            else
            {
                return false;
            }
        });
        $.validator.setDefaults({
            ignore: []
            // any other default options and/or rules
        });
        $('#form_interview').validate({
            groups: {
                emergency_contact: "emergency_contact_name relationship mobile",
                emergency_date: "employment_date_day employment_date_hh employment_date_mm",
                commuting_mean: "commuting_mean_train_cost commuting_mean_bus_cost",
                work_possible_week: "work_possible_week_by_time work_possible_week_by_day",
                start_end_time : "start_time_hh  start_time_mm  end_time_hh  end_time_mm",
                weekend_start_end: "weekend_start_time_hh weekend_start_time_mm weekend_end_time_hh weekend_end_time_mm",
                round_work: "round_trip work_location_time"
            },
            rules: {
                interview_date:{
                    date_format: true
                },
                emergency_contact_name: {
                    maxlength: 20
                },
                relationship: {
                    maxlength: 10
                },
                mobile:{
                    maxlength: 11
                },

                commuting_mean_bus_cost: {
                    required: function(element){
                        if($('#form_commuting_mean_bus').is(':checked'))
                            return true;
                        else
                            return false;
                    },
                    digits :true,
                    max: 2147483648,
                    min: 0
                },

                commuting_mean_train_cost: {
                    required: function(element){
                        if($('#form_commuting_mean_train').is(':checked'))
                            return true;
                        else
                            return false;
                    },
                    digits :true,
                    max: 2147483648,
                    min: 0
                },
                work_location: {
                    required: true,
                    maxlength: 30
                },
                round_trip: {
                    digits :true,
                    max: 2147483648,
                    min: 0
                },
                work_location_time: {
                    digits : true,
                    max: 2147483648,
                    min: 0
                },
                'working_arrangements[]': {
                    required: function(element){
                        if($('input[id^="form_weekend"]:checked').length > 0)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                },
                'weekend[]': {
                    required: function(element){
                        if($('input[id^="form_working_arrangements"]:checked').length > 0)
                            return false;
                        else
                            return true;
                    }
                },
                night_shift_allowed: {
                    required: function(element){
                        if($('input[id^="form_working_arrangements"]:checked').length > 0)
                            return true;
                        else
                            return false;
                    }
                },
                weekend_is: {
                    required: function(element){
                        if($('input[id^="form_weekend"]:checked').length > 0)
                            return true;
                        else
                            return false;
                    }
                },
                start_time_hh: {
                    date_hh_format: true,
                    cheked_night_shift_allowed: true
                },
                start_time_mm: {
                    date_mm_format: true,
                    cheked_night_shift_allowed: true
                },
                end_time_hh: {
                    date_hh_format: true,
                    cheked_night_shift_allowed: true
                },
                end_time_mm: {
                    date_mm_format: true,
                    cheked_night_shift_allowed: true
                },
                weekend_start_time_hh: {
                    date_hh_format: true,
                    checked_weekend_is: true
                },
                weekend_start_time_mm: {
                    date_mm_format: true,
                    checked_weekend_is: true
                },
                weekend_end_time_hh: {
                    date_hh_format: true,
                    checked_weekend_is: true
                },
                weekend_end_time_mm:{
                    date_mm_format: true,
                    checked_weekend_is: true
                },
                work_possible_week_by_day: {
                    digits :true,
                    max: 7,
                    min: 0
                },
                work_possible_week_by_time: {
                    digits :true,
                    max: 744,
                    min: 0
                },
                length_of_service: {
                    required: true
                },
                employment_date: {
                    date_time_format: true
                },
                applicants_media: {
                    required: true
                },
                applicants_media_des: {
                    required: function(element){
                        if($('#form_applicants_media:checked').val() == '3')
                            return true;
                        else
                            return false;
                    },
                    maxlength: 30
                },
                request_year_before: {
                    digits: true,
                    max: 2147483648,
                    min: 0
                },
                request_year: {
                    digits: true,
                    max: 2147483648,
                    min: 0
                },
                request_month: {
                    digits: true,
                    max: 2147483648,
                    min: 0
                },
                request_company_name: {
                    maxlength: 50
                },
                normal_license: {
                    required: true
                },
                PC_other: {
                    required: function(element){
                        if($('input[id^="form_PC"]:checked').val() == 3)
                            return true;
                        else
                            return false;
                    },
                    maxlength: 30
                },
                occupation: {
                    required: true
                },
                occupation_other: {
                    maxlength: 20,
                    required: function(element){
                        if($('#form_occupation').val() == '9')
                            return true;
                        else
                            return false;
                    }
                },
                wanted_hourly_wage: {
                    required: true,
                    digits: true,
                    max: 2147483648,
                    min: 0
                },
                height: {
                    digits :true,
                    max: 2147483648,
                    min: 0
                },
                weight: {
                    digits :true,
                    max: 2147483648,
                    min: 0
                },
                safety_boots: {
                    myfloat: true,
                    max: 2147483648,
                    min: 0
                },
                the_loan: {
                    digits :true,
                    max: 2147483648,
                    min: 0
                }
            },
            messages : {
                interview_date:{
                    date_format: '面接日期間の指定が正しくありません'
                },
                emergency_contact_name: {
                    maxlength: '氏名号は20文字以内で入力して下さい'
                },
                relationship: {
                    maxlength: '続柄号は10文字以内で入力して下さい'
                },
                mobile:{
                    maxlength: '電話番号号は10文字以内で入力して下さい'
                },
                commuting_mean_bus_cost: {
                    required: 'バスを入力して下さい',
                    digits :'バスは数字のみで入力して下さい',
                    max: 'バスは範囲内の数値を入力してください',
                    min: 'バスMin 0'
                },
                commuting_mean_train_cost: {
                    required: '電車を入力して下さい',
                    digits :'電車は数字のみで入力して下さい',
                    max: '電車は範囲内の数値を入力してください',
                    min: '電車Min 0'
                },
                work_location: {
                    required: '場所を入力して下さい',
                    maxlength: '場所号は30文字以内で入力して下さい'
                },
                round_trip: {
                    digits: '往復は数字のみで入力して下さい',
                    max: '往復は範囲内の数値を入力してください',
                    min: '往復Min 0'
                },
                work_location_time: {
                    digits: '所要時間は数字のみで入力して下さい',
                    max: '所要時間は範囲内の数値を入力してください',
                    min: '所要時間Min 0'
                },
                'working_arrangements[]': {
                    required: '勤務形態(平日)を入力して下さい'
                },
                'weekend[]': {
                    required: '勤務形態(週末祝祭)を入力して下さい'
                },
                night_shift_allowed: {
                    required: '入力して下さい'
                },
                weekend_is: {
                    required: '入力して下さい'
                },
                start_time_hh: {
                    date_hh_format: '期間の指定が正しくありません',
                    cheked_night_shift_allowed: '期間の指定を入力して下さい'
                },
                start_time_mm: {
                    date_mm_format: '期間の指定が正しくありません',
                    cheked_night_shift_allowed: '期間の指定を入力して下さい'
                },
                end_time_hh: {
                    date_hh_format: '期間の指定が正しくありません',
                    cheked_night_shift_allowed: '期間の指定を入力して下さい'
                },
                end_time_mm: {
                    date_mm_format: '期間の指定が正しくありません',
                    cheked_night_shift_allowed: '期間の指定を入力して下さい'
                },
                weekend_start_time_hh: {
                    date_hh_format: '期間の指定が正しくありません',
                    checked_weekend_is: '期間の指定を入力して下さい'
                },
                weekend_start_time_mm: {
                    date_mm_format: '期間の指定が正しくありません',
                    checked_weekend_is: '期間の指定を入力して下さい'
                },
                weekend_end_time_hh: {
                    date_hh_format: '期間の指定が正しくありません',
                    checked_weekend_is: '期間の指定を入力して下さい'
                },
                weekend_end_time_mm:{
                    date_mm_format: '期間の指定が正しくありません',
                    checked_weekend_is: '期間の指定を入力して下さい'
                },

                work_possible_week_by_day: {
                    digits: '日/週は数字のみで入力して下さい',
                    max: '日/週は範囲内の数値を入力してください',
                    min: '日/週Min 0'
                },
                work_possible_week_by_time: {
                    digits: '時間(h)/週は数字のみで入力して下さい',
                    max: '時間(h)/週は範囲内の数値を入力してください',
                    min: '時間(h)/週Min 0'
                },
                length_of_service: {
                    required: '勤務期間を入力して下さい'
                },
                employment_date: {
                    date_time_format: '就労希望日期間の指定が正しくありません'
                },
                applicants_media: {
                    required: '応募媒体を入力してください'
                },
                applicants_media_des: {
                    required: '応募媒体を入力して下さい',
                    maxlength: '応募媒体号は30文字以内で入力して下さい'
                },
                request_year_before: {
                    digits: '数値のみで入力してください。',
                    max: '年位前範囲内の数値を入力してください。',
                    min: '年位前Min 0'
                },
                request_year: {
                    digits: '数値のみで入力してください。',
                    max: '年の数値を入力してください',
                    min: '年Min 0'
                },
                request_month: {
                    digits: '数値のみで入力してください。',
                    max: 'ヶ月程度の数値を入力してください',
                    min: 'ヶ月程度Min 0'
                },
                request_company_name: {
                    maxlength: 'ヶ月程度号は50文字以内で入力して下さい'
                },
                normal_license: {
                    required: '普通免許を入力して下さい'
                },
                PC_other: {
                    required: 'PC技能を入力して下さい',
                    maxlength: 'PC技能号は30文字以内で入力して下さい'
                },
                occupation: {
                    required: '職業を入力して下さい'
                },
                occupation_other: {
                    maxlength: '職業号は20文字以内で入力して下さい',
                    required: '職業を入力して下さい'
                },
                wanted_hourly_wage: {
                    required:'募集時給を入力して下さい',
                    digits: '募集時給のみで入力して下さい',
                    max: '募集時給の数値を入力してください',
                    min: '募集時給ヶ月程度Min 0'
                },
                height: {
                    digits: '数字のみで入力してください',
                    max: '身長の数値を入力してください',
                    min: '身長ヶ月程度Min 0'
                },
                weight: {
                    digits: '数字のみで入力してください',
                    max: 'Wの数値を入力してください',
                    min: 'Wヶ月程度Min 0'
                },
                safety_boots: {
                    myfloat: '数字のみで入力してください',
                    max: '数字のみで入力してください',
                    min: '安全靴ヶ月程度Min 0'
                },
                the_loan: {
                    digits: '入社時貸出のみで入力して下さい',
                    max: '入社時貸出の数値を入力してください',
                    min: '入社時貸出ヶ月程度Min 0'
                }
            }
        });
        $('#form_interview input.anamnesis').each(function(){
            $(this).rules("add", {
                maxlength: 100,
                messages: {
                    maxlength: '既往症(治療中)は100文字以内で入力して下さい'
                }
            });
        });
        $('#form_interview .sickhistory-block input.year ').each(function(){
            $(this).rules("add", {
                digits :true,
                max: 100,
                messages: {
                    digits :'数値のみで入力してください。',
                    max: '範囲内の数値を入力してください'
                }
            });
        });

        $('#form_interview .opehistory-block input.year ').each(function(){
            $(this).rules("add", {
                digits :true,
                max: 100,
                messages: {
                    digits :'数値のみで入力してください。',
                    max: '範囲内の数値を入力してください'
                }
            });
        });
    };



    var convert_zen2han = function() {
        $('#form_round_trip').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_work_location_time').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_work_possible_week_by_day').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_work_possible_week_by_time').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_request_year_before').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_request_year').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_request_month').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_wanted_hourly_wage').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_height').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_weight').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_safety_boots').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_the_loan').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_weekend_start_time_hh').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_weekend_start_time_mm').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_weekend_end_time_hh').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_weekend_end_time_mm').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_start_time_hh').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_start_time_mm').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_end_time_hh').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_end_time_mm').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_employment_date_hh').on('change', function () {
            utility.zen2han(this);
        });
        $('#form_employment_date_mm').on('change', function () {
            utility.zen2han(this);
        });
    };

    //Event choice employment_date
    var employment_date = function(){
        var day = $('#form_employment_date_day').val();
        var hh = $('#form_employment_date_hh').val();
        var mm = $('#form_employment_date_mm').val();
        if(day != '' || hh != '' || mm != '')
            var employment_date = day+' '+hh+':'+mm+':00';
        else
            var employment_date = '';
        $('#form_employment_date').attr('value',employment_date);
    };
    var update_employment_date = function()
    {
        $('#form_employment_date_day').on('change',function()
        {
            employment_date();
        });
        $('#form_employment_date_hh').on('change',function()
        {
            employment_date();
        });
        $('#form_employment_date_mm').on('change',function()
        {
            employment_date();
        });
    };

    // event submit form
    var submit = function(){
        var form = $('#form_interview'),
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


    return {
        init:function(){
            ready();
            validate();
            submit();
            update_employment_date();
            convert_zen2han();
        }
    };
}();

$(function(){
    interview.init();
});
