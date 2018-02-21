var password = function () {
    /* SCREEN CREATE/EDIT USER */
    var validate = function () {
        jQuery.validator.addMethod("check_latin", function (value, element) {
            if (value == '') {
                return true;
            }
            if (value.match(/^[a-zA-Z0-9]+$/)) {
                return true;
            }

            return false;
        }, '8桁の半角英数字以内で入力してください');

        $('#password_form').validate({
            rules: {
                password: {
                    required: true,
                    check_latin: true,
                    minlength: 6
                },
                confirm: {
                    required: true,
                    check_latin: true,
                    minlength: 6
                }
            },
            messages: {
                password: {
                    required: 'パスワードを入力してください',
                    check_latin: 'パスワードは半角文字で入力してください',
                    minlength: '桁数が足りません'
                },
                confirm: {
                    required: 'パスワード(確認用)を入力してください',
                    check_latin: 'パスワードは半角文字で入力してください',
                    minlength: '桁数が足りません'
                }
            }
        });
    };
    var submit = function () {
        var form = $('#password_form'),
            valid;
        form.on('submit', function () {
            valid = form.valid();
            if (valid == false) {
                return false;
            }

            if (confirm(message_confirm_save)) {
                return true;
            }

            return false;
        });
    };
    return {
        init: function () {
            validate();
            submit();
        }
    };
}();

$(function () {
    password.init();
});
