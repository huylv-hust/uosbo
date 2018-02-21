var job = function(){
    /* SCREEN CREATE JOB */
    // validate form job

    var validate = function(){
        jQuery.validator.addMethod("name_method", function(value,element) {
        },'入力した期間が正しくありません');
        jQuery.validator.addMethod("check_date", function(value,element) {
            var form = $(element).closest('form'),
                start = form.find('[name=start_date]').val(),
                end = form.find('[name=end_date]').val(),
                start_int = parseInt(start.replace(/-/g,"")),
                end_int = parseInt(end.replace(/-/g,""))
                ;

            if((start == '' && end == '') ||
                (start == '' && end != '') ||
                (start != '' && end == '') ||
                (start != '' && end != '' && start_int <= end_int))
                return true;

            return false;
        });
        jQuery.validator.addMethod("check_date_pickup", function(value,element) {
            var form = $(element).closest('form'),
                start = form.find('[name=pickup_start_date]').val(),
                end = form.find('[name=pickup_end_date]').val(),
                start_int = parseInt(start.replace(/-/g,"")),
                end_int = parseInt(end.replace(/-/g,""));

            if((start == '' && end == '') ||
                (start == '' && end != '') ||
                (start != '' && end == '') ||
                (start != '' && end != '' && start_int <= end_int))
                return true;

            return false;
        });
        jQuery.validator.addMethod("check_date_conscription", function(value,element) {
            var form = $(element).closest('form'),
                start = form.find('[name=conscription_start_date]').val(),
                end = form.find('[name=conscription_end_date]').val(),
                start_int = parseInt(start.replace(/-/g,"")),
                end_int = parseInt(end.replace(/-/g,""));

            if((start == '' && end == '') ||
                (start == '' && end != '') ||
                (start != '' && end == '') ||
                (start != '' && end != '' && start_int <= end_int))
                return true;

            return false;
        });
        $.validator.addMethod("dateformat", function(value,element)
        {
            if(value == '' || value == null) return true;
            if(value.match(/^\d{4}-\d{2}-\d{2}$/)){
                return true;
            }else{
                return false;
            }
        },"利用の期間が正しくありません");
        $('#job_form').validate({
            errorPlacement: function (error, element) {

                var err = element.parents('td');
                $(err).append(error);
                var err1 = element.parents('.job_error');
                $(err1).append(error);


            },
            groups: {
                zipcode: 'zipcode_first zipcode_last',
                phone_number1:'phone_number1_1 phone_number1_2 phone_number1_3',
                phone_number2:'phone_number2_1 phone_number2_2 phone_number2_3',
                date_check_input:'start_date end_date',
                conscription_date:'conscription_start_date conscription_end_date',
                pickup_date:'pickup_start_date pickup_end_date',
            },
            rules: {
                addr_is_view:{
                    required:true
                },
                salary_des:{
                    required:true,
                    maxlength_sjis: 36
                },
                post_company_name:{
                    required:true,
                    maxlength_sjis: 28
                },
                start_date:{
                    date:true,
                    check_date:true,
                    date_format:true
                },
                end_date:{
                    date:true,
                    check_date:true,
                    date_format:true
                },
                conscription_start_date: {
                    date_format:true,
                    check_date_conscription:true
                },
                conscription_end_date: {
                    date_format:true,
                    check_date_conscription:true
                },
                pickup_start_date: {
                    date_format:true,
                    check_date_pickup:true
                },
                pickup_end_date: {
                    date_format:true,
                    check_date_pickup:true
                },
                sssale_id:{
                    required: true
                },
                zipcode_first: {
                    required: {
                        depends: function (element) {

                            if($("#form_zipcode_first").val() == '' && $("#form_zipcode_last").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits: true,
                    minlength: 3,
                    maxlength: 3
                },
                zipcode_last: {
                    required: {
                        depends: function (element) {

                            if($("#form_zipcode_first").val() == '' && $("#form_zipcode_last").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits: true,
                    minlength: 4,
                    maxlength: 4
                },
                url_home_page:{
                    maxlength:50
                },
                url_youtube:{
                    maxlength:255
                },

                work_location_display_type:{
                    required: true,
                    check_all_space:true
                },
                work_location:{
                    required: true,
                    maxlength_sjis: 20
                },
                location:{
                    maxlength_sjis:32
                },
                work_location_title:{
                    maxlength_sjis:10
                },

                traffic:{
                    maxlength_sjis:50
                },
                store_name:{
                    maxlength_sjis:50,
                },
                job_category:{
                    maxlength_sjis:32
                },
                catch_copy:
                {
                    maxlength_sjis: 45
                },
                lead:
                {
                    maxlength_sjis: 60
                },
                business_description:
                {
                    maxlength_sjis: 40
                },
                work_time_des:{
                    maxlength_sjis:100
                },
                interview_des:{
                    maxlength_sjis:60
                },
                apply_method:{
                    maxlength_sjis:100
                },
                phone_name1:{
                    maxlength_sjis:20
                },
                phone_name2:{
                    maxlength_sjis:20
                },
                contact:{
                    maxlength_sjis:60
                },
                apply_process:{
                    maxlength_sjis:100
                },
                is_apply_by_mobile:{
                    required: false
                },
                is_web_receipt:{
                    required: true
                },
                employment_people_num:{
                    digits:true
                },
                phone_number1_1:{
                    required: {
                        depends: function (element) {


                            if($("#form_phone_number1_2").val() == '' && $("#form_phone_number1_3").val() == '')
                            {
                                return false;
                            }
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:5,
                    minlength:1
                },
                phone_number1_2:{
                    required: {
                        depends: function (element) {

                            if($("#form_phone_number1_1").val() == '' && $("#form_phone_number1_3").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:4,
                    minlength:1
                },
                phone_number1_3:{
                    required: {
                        depends: function (element) {

                            if($("#form_phone_number1_1").val() == '' && $("#form_phone_number1_2").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:4,
                    minlength:1
                },
                phone_number2_1:{
                    required: {
                        depends: function (element) {

                            if($("#form_phone_number2_2").val() == '' && $("#form_phone_number2_3").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:4,
                    minlength:1
                },
                phone_number2_2:{
                    required: {
                        depends: function (element) {

                            if($("#form_phone_number2_1").val() == '' && $("#form_phone_number2_3").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:4,
                    minlength:1
                },
                phone_number2_3:{
                    required: {
                        depends: function (element) {

                            if($("#form_phone_number2_1").val() == '' && $("#form_phone_number2_2").val() == '')
                                return false;
                            else
                                return true;
                        }
                    },
                    digits:true,
                    maxlength:4,
                    minlength:1
                },
                employment_people_num:{
                    max:127
                },
                employment_people_des: {
                    maxlength_sjis:100
                },
                work_day_week:{
                    max: 127
                },
                salary_min:{
                    max: 2147483647
                },
                work_location_map:{
                    maxlength:100
                },
                qualification:{
                    maxlength_sjis: 100
                },
                employment_des:{
                    maxlength: 100
                },
                dispatch_placement_des:{
                    maxlength:100
                }
                ,
                interview_location:{
                    maxlength:100
                },
                work_time_des:{
                    maxlength_sjis:100
                }



            },
            messages: {

                post_company_name:{
                    required:'掲載社名を入力して下さい'
                },
                addr_is_view:{
                    required:'住所表示を入力して下さい'
                },
                salary_des:{
                    required:'給与を入力して下さい'
                },
                work_time_des:{
                    maxlength:'勤務曜日・時間について100文字以内で入力'
                },
                interview_location:{
                    maxlength:'面接地は100文字以内で入力して下さい'
                },
                dispatch_placement_des:{
                    maxlength:'紹介予定派遣の場合は100文字以内で入力して下さい'
                },
                employment_des:{
                    maxlength: '採用予定人数については100文字以内で入力して下さい'
                },
                start_date:{
                    date:"日付の指定が正しくありません",
                    check_date:"入力した期間が正しくありません",
                    date_format:"日付の指定が正しくありません"
                },
                end_date:{
                    date:"日付の指定が正しくありません",
                    check_date:"入力した期間が正しくありません",
                    date_format:"日付の指定が正しくありません"
                },
                conscription_start_date: {
                    date_format:'日付の指定が正しくありません',
                    check_date_conscription:'入力した期間が正しくありません'
                },
                conscription_end_date: {
                    date_format:'日付の指定が正しくありません',
                    check_date_conscription:'入力した期間が正しくありません'
                },
                pickup_start_date: {
                    date_format:'日付の指定が正しくありません',
                    check_date_pickup:'入力した期間が正しくありません'
                },
                pickup_end_date: {
                    date_format:'日付の指定が正しくありません',
                    check_date_pickup:'入力した期間が正しくありません'
                },
                sssale_id:{
                    required: '売上形態を入力して下さい'
                },
                zipcode_first: {
                    required: '郵便番号を入力して下さい',
                    digits: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    check_all_space:'郵便番号を入力してください',
                    maxlength: '郵便番号の指定が正しくありません'
                },
                zipcode_last: {
                    required: '郵便番号を入力して下さい',
                    digits: '郵便番号の指定が正しくありません',
                    minlength: '郵便番号の指定が正しくありません',
                    check_all_space:'郵便番号を入力してください',
                    maxlength: '郵便番号の指定が正しくありません'
                },
                url_home_page: {
                    maxlength: 'ホームページURLは50文字以内で入力して下さい'
                },
                url_youtube: {
                    maxlength:'YouTube URLは255文字以内で入力して下さい'
                },
                work_location_display_type:{
                    required: '勤務地表示方式を入力して下さい',
                    check_all_space:'勤務地表示方式を入力してください'
                },
                location:{
                    maxlength: '掲載住所は32文字以内で入力して下さい'
                },
                work_location:{
                    required: '勤務地（派遣・契約の場合)を入力して下さい',
                    check_all_space:'勤務地（派遣・契約の場合)を入力して下さい',
                    maxlength: '勤務地（派遣・契約の場合)は20文字以内で入力して下さい'
                },
                work_location_title: {
                    maxlength: '勤務地カセット式タイトルは10文字以内で入力して下さい'
                },
                work_location_map:{
                    maxlength: '(勤)地図補足は100文字以内で入力して下さい'
                },
                traffic: {
                    maxlength: '交通は50文字以内で入力して下さい'
                },
                store_name: {
                    maxlength: '店舗名は50文字以内で入力して下さい'
                },
                job_category: {
                    maxlength: '職種は32文字以内で入力して下さい'
                },
                catch_copy:
                {
                    maxlength: 'キャッチコピーは45文字以内で入力して下さい'
                },
                qualification:{
                    maxlength: '資格は100文字以内で入力して下さい'
                },
                lead:
                {
                    maxlength: 'リードは60文字以内で入力して下さい'
                },
                business_description:
                {
                    maxlength: '事業内容は40文字以内で入力して下さい'
                },
                work_time_des: {
                    maxlength: '勤務曜日・時間については100文字以内で入力して下さい'
                },
                interview_des: {
                    maxlength: '面接地・他タイトルは60文字以内で入力して下さい'
                },
                apply_method: {
                    maxlength: '応募方法は100文字以内で入力して下さい'
                },
                phone_name1: {
                    maxlength: '代表電話(1)名称は20文字以内で入力して下さい'
                },
                phone_name2: {
                    maxlength: '代表電話(2)名称は20文字以内で入力して下さい'
                },
                contact: {
                    maxlength: '問い合せ捕捉は60文字以内で入力して下さい'
                },
                apply_process: {
                    maxlength: '応募方法のプロセスは100文字以内で入力して下さい'
                },
                is_apply_by_mobile:{
                    required: '携帯電話応募ボタン入力して下さい'
                },
                is_web_receipt:{
                    required: 'WEB応募受付を入力して下さい'
                },
                employment_people_num:{
                    digits:'採用予定人数が正しくありません'
                },
                phone_number1_1:{

                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'

                },
                phone_number1_2:{

                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'
                },
                phone_number1_3:{

                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'
                },
                phone_number2_1:{
                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'
                },
                phone_number2_2:{
                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'
                },
                phone_number2_3:{
                    required: '代表電話を入力して下さい',
                    digits:'代表電話が正しくありません',
                    maxlength:'1桁~4桁以内を入力してください。',
                    minlength:'1桁~4桁以内を入力してください。'
                },
                employment_people_num:{
                    max: '範囲内の数値を入力してください。'
                },
                work_day_week:{
                    max: '範囲内の数値を入力してください。'
                },
                salary_min:{
                    max: '範囲内の数値を入力してください。'
                }


            }
        });
        $('#job_form input.job_recruit_sub_title').each(function(){
            $(this).rules("add", {
                maxlength_sjis: 7,
                messages: {
                    maxlength: '募集追加の見出しは7文字以内で入力して下さい'
                }
            });
        });
        $('#job_form input.job_add_sub_title').each(function(){
            $(this).rules("add", {
                maxlength_sjis: 12,
                messages: {
                    maxlength: '仕事追加の見出しは12文字以内で入力して下さい'
                }
            });
        });

    };

    // event submit form ss
    var submit = function(){
        var form = $('#job_form'),
            valid;
        form.on('submit', function()
        {

            var counter = 0;
            $('input[name^=trouble]:checked').each(function()
            {
                if ($(this).parents('label:first').find('span.for-recruit').size() > 0)
                {
                    counter++;
                }
            });

            if(counter > 16){
                $("#job_form td.trouble").append('<label class="error">*マークのこだわり選択は16件以内を選択して下さい。</label>');
                return false;
            }

            valid = form.valid();
            if(valid == false)
                return false;

            if(confirm('保存します、よろしいですか？'))
                return true;

            return false;
        });
    };
    var recruit_add_count = $('#job_form .recruit').length;
    var click_recruit_add_btn = function(){
        $('.recruit_add_btn').click(function(){
            if(recruit_add_count == 9) return;
            recruit_add_count = recruit_add_count + 1;
            var next_index = ($('#job_form .recruit').length == 0) ? 0 : parseInt($('#job_form .recruit:last').find('.post_index_recruit').val()) + 1;
            var html = '<div class="panel panel-default recruit">'
                + '<input type="hidden" class="post_index_recruit" value="' + next_index + '">'
                + '<div class="panel-heading text-right">'
                + '<button name="recruit_remove_btn" class="btn btn-default btn-sm recruit_remove_btn " type="button">'
                + '<i class="glyphicon glyphicon-remove icon-white"></i>'
                + '</button>'
                + '</div>'
                + '<div class="panel-body">'
                + '<div class="job_error">'
                + '<div class="input-group">'
                + '<div style="width: 100px" class="input-group-addon">見出し</div>'
                + '<input type="text" value=""  name="job_recruit_sub_title[' + next_index + ']" size="83" class="form-control job_recruit_sub_title"  length="7">'
                + '</div>'
                + '</div>'
                +'<p></p>'
                + '<div class="input-group">'
                + '<div style="width: 100px" class="input-group-addon">本文</div>'
                + '<textarea name="job_recruit_text[' + next_index + ']" rows="3" cols="80" class="form-control"></textarea>'
                + '</div>'
                + '</div>'
                + '</div>';

            $(html).appendTo($(this).closest('tr').find('#job_recruit'));
            validate();
        });
    };
    var click_remove_recruit_add = function(){
        $(document).on('click','.recruit_remove_btn', function(){
            $(this).closest('.panel-default').remove();
            recruit_add_count = recruit_add_count - 1;
        });
    };
    /*add work(add)*/
    var add_count = $('#job_form .work').length;
    var click_add_add_btn = function(){
        $(document).on('click','.work_add_btn', function(){
            if(add_count == 4) return;
            add_count = add_count+1;
            var next_index = ($('#job_form .work').length == 0) ? 0 : parseInt($('#job_form .work:last').find('.post_index_add').val()) + 1;
            var html = '<div class="panel panel-default work">'
                +'<input type="hidden" value="' + next_index + '" class="post_index_add">'
                +'<div class="panel-heading text-right">'
                +'<button name="work_remove_btn" class="btn btn-default btn-sm work_remove_btn" type="button">'
                +'<i class="glyphicon glyphicon-remove icon-white"></i>'
                +'</button>'
                +'</div>'
                +'<div class="panel-body">'
                +'<div class="job_error">'
                +'<div class="input-group">'
                +'<div style="width: 100px" class="input-group-addon">見出し</div>'
                +'<input type="text" value=""  name="job_add_sub_title[' + next_index + ']" size="83" class="form-control job_add_sub_title" length="12">'
                +'</div>'
                +'</div>'
                +'<p></p>'
                +'<div class="input-group">'
                +'<div style="width: 100px" class="input-group-addon">本文</div>'
                +'<textarea name="job_add_text[' + next_index + ']" rows="3" cols="80" class="form-control"></textarea>'
                +'</div>'
                +'</div>'
                +'</div>';
            if(add_count > 4) return;
            $(html).appendTo($(this).closest('tr').find('#job_add'));
            validate();
        });
    };
    var click_remove_add_add = function(){
        $(document).on('click','.work_remove_btn', function(){
            $(this).closest('.panel-default').remove();
            add_count -= 1;
        });
    };
    var convert_zen2han = function() {
        $('#form_zipcode_first').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_zipcode_last').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_salary_min').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_work_day_week').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_employment_people_num').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number1_1').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number1_2').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number1_3').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number2_1').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number2_2').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_phone_number2_3').on('change',function(){
            utility.zen2han(this);
        });
        $('#form_work_day_week').on('change',function(){
            utility.zen2han(this);
        });
    };

    /* END SCREEN SS LIST */

    var change_sssale = function() {
        $('#form_sssale_id').on('change', function(){
            var sssale_id = $(this).val();
            get_work_type(sssale_id);
        });
    };

    var get_work_type = function(sssale_id) {
        var sssale_id = $('#form_sssale_id').val();
        if(sssale_id == '') {
            $('#show-work').hide();
            return;
        }
        var param = {
            sssale_id: sssale_id
        };
        var request = $.ajax({
            type: 'post',
            data: param,
            url: baseUrl + 'ajax/job/worktype'
        });
        var response = request.done(function(data){
            $('#show-work, #show-work .panel-body').show();
            $('#show-work .panel-body').html(data);
        });
    };

    var onChangeEmploymentType = function() {
        $('select[name=employment_type]').on('change', function() {
            var val = $(this).val();
            if (val == 5) {
                $('input[name=phone_number1_1]').val('0120');
                $('input[name=phone_number1_2]').val('351');
                $('input[name=phone_number1_3]').val('451');
            } else if (val == 3 || val == 4 || val == 6) {
                $('input[name=phone_number1_1]').val('');
                $('input[name=phone_number1_2]').val('');
                $('input[name=phone_number1_3]').val('');
            } else {
                $('input[name=phone_number1_1]').val('0120');
                $('input[name=phone_number1_2]').val('464');
                $('input[name=phone_number1_3]').val('533');
            }
        });
    };

    return {
        init:function(){
            validate();
            click_recruit_add_btn();
            click_remove_recruit_add();
            click_add_add_btn();
            click_remove_add_add();
            convert_zen2han();
            submit();
            change_sssale();
            get_work_type();
            onChangeEmploymentType();
        }
    };
}();

$(function(){
    job.init();

});
