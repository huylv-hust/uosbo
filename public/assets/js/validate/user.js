var user = function(){
    /* SCREEN CREATE/EDIT USER */
    var validate = function(){
        jQuery.validator.addMethod("check_latin", function(value,element) {
            if(value == '') return true;
            if(value.match(/^[a-zA-Z0-9]+$/)) {
                return true;
            }
            return false;
        },'8桁の半角英数字以内で入力してください');
        jQuery.validator.addMethod("my_email", function(value,element) {
            if(value == '') return true;
            if(value.match(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i)) {
                return true;
            }
            return false;
        },'メールアドレスが正しくありません');
        
        $('#user_form').validate({
            rules: {
                department_id: {
                    required: true
                },
                division_type: {
                    required: true
                },
                name: {
                    required: true,
                    check_all_space: true,
                    maxlength: 100
                },
                login_id: {
                    required: true,
                    maxlength: 8,
                    check_latin: true
                },
                pass: {
                    required: true,
                    check_latin: true,
                    minlength: 6
                },
                mail: {
                    my_email: true
                }
            },
            messages: {
                department_id: {
                    required: '所属を選択してください。'
                },
                division_type: {
                    required: '権限区分を選択してください。'
                },
                name: {
                    required: '氏名を入力してください。',
                    check_all_space: '氏名入力して下さい',
                    maxlength: '氏名は100文字以内で入力して下さい '
                },
                login_id: {
                    required: 'ログインIDを入力してください。',
                    maxlength: 'ログインIDは8文字以内で入力して下さい '
                },
                pass: {
                    required: 'パスワードを入力してください。',
                    check_latin : 'パスワードは半角文字で入力してください',
                    minlength: 'パスワードは６桁の文字以降で入力してください'
                },
                mail: {
                    my_email: 'メールアドレスが正しくありません'
                }
            }
        });
        $('input.list_email').each(function(){
            $(this).rules("add", {
                my_email: true,
                messages: {
                     my_email: 'メールアドレスが正しくありません',
                }
            });
        });
        
       
    };

    //btn add user
    var click_btn_add_user = function(){
        $('#users_btn_add').click(function(){
            window.location.href = baseUrl + 'master/user';
        });
    };

    //delete user at screen edit
    var click_btn_back_users = function(){
        $('#btn_users_back').click(function(){
            if(confirm(message_confirm_del))
            {
                var form = $(this).closest('form');
                form.attr("action", baseUrl + "master/user/delete").submit();
            }
        });
    };

    var convert_zen2han = function(){
        $(document).on('click','#form_login_id', function(){
            utility.zen2han(this);
        });
    };
    
    var email = function(){
        $('button[name=add-email-btn]').on('click', function()
        {
                var next_index = $('#emails div.email_div').length == 0 ? 0 : parseInt($('#emails div.email_div:last > input:text').attr('index')) + 1;
                var html = '<div class="email_div">'
                        +'<input index="'+next_index+'" type="text" size="50" class="form-control list_email" name="mail['+next_index+']" value="">'
                        +' <button name="remove-email-btn" class="btn btn-danger btn-sm" type="button">'
                                +' <i class="glyphicon glyphicon-trash icon-white"></i>'
                        +'</button>'
                        +'<label id="mail['+next_index+']-error" class="error" for="mail['+next_index+']"></label>'
                +'</div>';
                $('#emails').append(html);
                validate();
        });

        $('#emails').on('click', 'button[name=remove-email-btn]', function()
        {
                if ($('#emails div').size() < 2)
                {
                        alert('全てを削除することはできません');
                        return false;
                }

                $(this).parent('div').remove();
        });
    }
    
    //submit form user
    var submit = function(){
        var form = $('#user_form'),
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
    /* END SCREEN CREATE/EDIT USER */

    /* SCREEN LIST USER */
    var click_btn_delete_user = function(){
        $('.users_btn_delete').click(function(){
            if(confirm(message_confirm_del))
            {
                var user_id = $(this).closest('td').find('input[type=hidden]').val();
                $('#user_id_working').val(user_id);
                $('#form_search_user').attr('action', baseUrl + 'master/user/delete').attr('method','POST').submit();
            }
        });
    };
    /* END SCREEN LIST USER */

    return {
        init:function(){
            email();
            validate();
            click_btn_add_user();
            click_btn_delete_user();
            click_btn_back_users();
            convert_zen2han();
            submit();
        }
    };
}();

$(function(){
    user.init();
});
