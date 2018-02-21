var emcall = function(){
    var hide_message = function(){
        $('div.sssale_message').hide();
    };
    //click btn add
    var click_add_btn = function(){
        $('#add_btn').off('click').on('click',function(){
            var next_index = ($('#sales .panel').length == 0) ? 0 : parseInt($('#sales .panel:last').find('input[name=panel_index]').val()) + 1;
            $('#panel_hidden input[name=panel_index]').val(next_index);
            var html = $('#panel_hidden').html();
            $(html).appendTo($('div#sales'));
            hide_message();
            validate();
        });
    };

    //click btn delete
    var click_delete_btn = function(){
        $('.delete_btn').click(function(){
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
        $(document).on('submit', '.emcall_form', function(){
            var valid = $(this).valid();
            if(valid == false)
                return false;

            if(confirm(message_confirm_save))
                return true;

            return false;
        });
    };

    var validate = function(){
        $.validator.addMethod("kana", function (value, element) {
            if(/^([ぁ-んー　]|\s)+$/.test(value)) {
                return true;
            }
            return false;
        }, "かなを入力してください");
        $('form.emcall_form').each(function () {
            var form = $(this);
            form.validate({
                groups: {
                    zipcode: "zipcode_first zipcode_last",
                    tel: "tel_1 tel_2 tel_3"
                },
                rules: {
                    relationship: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    name_kana: {
                        required: true,
                        kana: true
                    },
                    tel_1: {
                        digits: true,
                        required: function(element) {
                            var form = $(element).closest('form');
                            if(form.find('#form_tel_2').val() != '' || form.find('#form_tel_3').val() != '') {
                                return true;
                            }
                            return false;
                        }
                    },
                    tel_2: {
                        digits: true,
                        required: function(element) {
                            var form = $(element).closest('form');
                            if(form.find('#form_tel_1').val() != '' || form.find('#form_tel_3').val() != '') {
                                return true;
                            }
                            return false;
                        }
                    },
                    tel_3: {
                        digits: true,
                        required: function(element) {
                            var form = $(element).closest('form');
                            if(form.find('#form_tel_1').val() != '' || form.find('#form_tel_2').val() != '') {
                                return true;
                            }
                            return false;
                        }
                    },
                    zipcode_first: {
                        required: function() {
                            if($(form).find('[name=zipcode_last]').val() != '') {
                                return true;
                            }
                            return false;
                        },
                        minlength: 3,
                        digits: true
                    },
                    zipcode_last: {
                        required: function() {
                            if($(form).find('[name=zipcode_first]').val() != '') {
                                return true;
                            }
                            return false;
                        },
                        minlength: 4,
                        digits: true
                    }
                },
                messages: {
                    relationship: {
                        required: '続柄は必要です'
                    },
                    name: {
                        required: '氏名は必要です'
                    },
                    name_kana: {
                        required: '氏名かなは必要です'
                    },
                    tel_1: {
                        digits: '電話番号は数字で入力してください',
                        required: '電話番号を入力してください'
                    },
                    tel_2: {
                        digits: '電話番号は数字で入力してください',
                        required: '電話番号を入力してください'
                    },
                    tel_3: {
                        digits: '電話番号は数字で入力してください',
                        required: '電話番号を入力してください'
                    },
                    zipcode_first: {
                        required: '正しくありません',
                        minlength: '正しくありません',
                        digits: '数字で入力してください'
                    },
                    zipcode_last: {
                        required: '正しくありません',
                        minlength: '正しくありません',
                        digits: '数字で入力してください'
                    }
                }
            });
        });
    };

    var convert_zen2han = function() {
        $(document).on('change', '#form_zipcode_first, #form_zipcode_last, #form_tel_1, #form_tel_2, #form_tel_3', function(){
            utility.zen2han(this);
        });
    };

    return {
        init:function(){
            click_add_btn();
            click_delete_btn();
            validate();
            submit();
            convert_zen2han();
        }
    }
}();

$(function(){
    emcall.init();
});
