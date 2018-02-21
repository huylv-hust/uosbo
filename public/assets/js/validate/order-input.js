$.validator.messages.required = '必須です';
$.validator.messages.number = '数字のみで入力して下さい';
$.validator.addMethod("dateformat", function(value,element) {
    if(value != ''){
        if(value.match(/^\d{4}-\d{2}-\d{2}$/)){
            var arr_date = value.split('-');
            if(arr_date['1'] > 12 || arr_date['2'] > 31)
            {
                return false;
            }
            return true;
        }else{
            return false;
        }
    }
    return true;
},"日付が正しくありません");
$.validator.addMethod("postdate", function(value,element){
	if(order_id != '' && value == '' && order_status == 2 && action != 'copy' && division_type == 1){
		return false;
	}else{
        return true;
	}
},"必須です");
$.validator.addMethod("validateworktype", function(value,element){
        var length = $('div.panel-body input[type=checkbox]:checked').length;
        if(length < 1){
           return false;
	}else{
            return true;
	}
},"必須です");
$.validator.addMethod("validateint11", function(value,element){
        if(value >= 2147483647){
           return false;
	}else{
            return true;
	}
},"正しくありません");
$.validator.addMethod("validatetiny4", function(value,element){
        if(value > 127){
           return false;
	}else{
            return true;
	}
},"正しくありません");

//validation
(function ($, W, D)
{
    var validation = {};

    validation.util =
            {
                setupFormValidation: function ()
                {
                    //form validation rules
                    $("#order-input").validate({
                        errorPlacement: function (error, element){

                            var err = element.parents('td');
                            $(err).append(error);
                            var err1 = element.parents('.col-md-3');
                            $(err1).append(error);
							var err2 = element.parents('.workerr');
							$(err2).append(error);
                        },
                        ignore:'',
                        rules: {
                            apply_date: {
                                required: true,
                                date_format: true
                            },
                            post_date: {
                                postdate: true,
                                date_format: true,
                                required:function(){
                                    if(order_status == 2)
                                        return true;
                                    else
                                        return false;
                                }
                            },
                            close_date: {
                                postdate: true,
                                date_format: true,
                                required:function(){
                                    if(order_status == 2)
                                        return true;
                                    else
                                        return false;
                                },
                                period: function() {
                                    return $('input[name=post_date]').val();
                                }
                            },
                            ss_id: {
                                required: true
                            },
                            agreement_type: {
                                required: true
                            },
                            location: {
                                maxlength: 100
                            },
                            access: {
                                maxlength: 100
                            },
                            apply_detail: {
                                maxlength: 50
                            },
                            request_date: {
                                date_format: true
                            },
                            work_date: {
                                required: true
                            },
                            request_people_num: {
                                number: true,
                                validateint11: true
                            },
                            work_time_of_month: {
                                number: true,
                                max: 180
                            },
                            work_days_of_week: {
                                number: true,
                                max: 7
                            },
                            price: {
                                required: true,
                                number: true
                            },
                            require_des: {
                                maxlength: 30
                            },
                            require_experience: {
                                maxlength: 30
                            },
                            require_other: {
                                maxlength: 30
                            },
                            require_age: {
                                maxlength: 30
                            },
                            require_gender: {
                               maxlength: 30
                            },
                            require_w: {
                                maxlength: 30
                            },
                            interview_user_id: {
                                required: true
                            },
                            agreement_user_id: {
                                required: true
                            },
                            notes: {
                                maxlength_textarea: 500
                            },
                            list_post: {
                                required: true
                            },
                            price: {
                                digits: true,
                                max: 2147483647
                            }
                        },
                        messages: {
                            apply_date: {
                                date_format: "日付が正しくありません"
                            },
                            post_date: {
                                date_format: "日付が正しくありません"
                            },
                            close_date: {
                                date_format: "日付が正しくありません"
                            },
                            location: {
                                maxlength: "100文字以内で入力してください"
                            },
                            access: {
                                maxlength: "100文字以内で入力してください"
                            },
                            request_date: {
                                date_format: "日付が正しくありません"
                            },
                            apply_detail: {
                                maxlength: "50文字以内で入力してください"
                            },
                            require_des: {
                                maxlength: "30文字以内で入力してください"
                            },
                            require_experience: {
                                maxlength: "30文字以内で入力してください"
                            },
                            require_w: {
                                maxlength: "30文字以内で入力してください"
                            },
							require_age: {
								maxlength: "30文字以内で入力してください"
							},
							require_gender: {
								maxlength: "30文字以内で入力してください"
							},
                            require_other: {
                                maxlength: "30文字以内で入力してください"
                            },
                            notes: {
                                maxlength_textarea: "500文字以内で入力してください"
                            },
                            list_post: {
                                required: '必須です'
                            },
                            price: {
                                digits: '掲載金額は数字で入力してください',
                                max: '掲載金額は数字で入力してください。'
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
            }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        validation.util.setupFormValidation();
    });

})(jQuery, window, document);
