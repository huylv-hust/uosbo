var media = function(){
    /*SCREEN CREATE MEDIA*/
    var validate = function(){
        $('#media_form').validate({
            rules: {
                partner_code: {
                    required: true
                },
                media_name: {
                    required: true,
                    check_all_space: true,
                    maxlength: 20
                },
                media_version_name: {
                    required: true,
                    check_all_space: true,
                    maxlength: 50
                },
                type: {
                    required: true
                },
                classification: {
                    required: true
                },
                budget_type: {
                    required: true
                },
                is_web_reprint: {
                    required: true
                },
                public_description: {
                    maxlength: 20
                },
                deadline_description: {
                    maxlength: 20
                }
            },
            messages: {
                partner_code: {
                    required: '取引先(発注先)入力して下さい'
                },
                media_name: {
                    required: '媒体名を入力して下さい',
                    check_all_space: '媒体名を入力して下さい',
                    maxlength: '媒体名は20文字以内で入力して下さい'
                },
                media_version_name: {
                    required: '版名を入力して下さい',
                    check_all_space: '版名を入力して下さい',
                    maxlength: '版名は50文字以内で入力して下さい'
                },
                type: {
                    required: '自他区分を入力して下さい'
                },
                classification: {
                    required: '分類を選択してください。'
                },
                budget_type: {
                    required: '予算区分を入力して下さい'
                },
                is_web_reprint: {
                    required: 'WEB転載を選択してください。'
                },
                public_description: {
                    maxlength: '掲載・公開については20文字以内で入力して下さい'
                },
                deadline_description: {
                    maxlength: '締め切りについては20文字以内で入力して下さい'
                }
            }
        });

        $('#media_form input.post_name').each(function(){
            $(this).rules("add", {
                required: true,
                maxlength: 20,
                messages: {
                    required: "掲載枠名称を入力して下さい",
                    maxlength: "掲載枠名称は20文字以内で入力して下さい"
                }
            });
        });

        $('#media_form input.post_count').each(function(){
            $(this).rules("add", {
                required: true,
                digits: true,
                max: 2147483647,
                messages: {
                    required: "拠点数を入力して下さい",
                    digits: "拠点数は数字のみで入力して下さい",
                    max: "範囲内の数値を入力してください"
                }
            });
        });

        $('#media_form input.post_price').each(function(){
            $(this).rules("add", {
                required: true,
                digits: true,
                max: 2147483647,
                messages: {
                    required: "単価を入力して下さい",
                    digits: "単価は数字のみで入力して下さい",
                    max: "範囲内の数値を入力してください"
                }
            });
        });

        $('#media_form .post_note').each(function(){
            $(this).rules("add", {
                maxlength_textarea: 100,
                messages: {
                    maxlength_textarea: "備考は100文字以内で入力して下さい"
                }
            });
        });
    };

    var convert_zen2han = function(){
        $(document).on('change','#media_form input.post_price', function(){
            utility.zen2han(this);
        });
        $(document).on('change','#media_form input.post_count', function(){
            utility.zen2han(this);
        });
    };
    //back to media list
    var click_back_to_media_list = function(){
        $('#btn_medias_back').click(function(){
            if(confirm(message_confirm_del))
            {
                $(this).closest('form').submit();
            }
        });
    };

    var submit = function(){
        var form = $('#media_form'),
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

    //add more post panel
    var click_add_post_panel = function(){
        $('#media_post_add_btn').click(function(){
            var next_index = ($('#media_form .panel').length == 0) ? 0 : parseInt($('#media_form .panel:last').find('.post_index').val()) + 1;
            var html = '<div class="panel panel-default">'
                + '<input type="hidden" class="post_index" value="' + next_index + '">'
                + '<div class="panel-heading text-right">'
                + '<button type="button" class="btn btn-default btn-sm remove_post_btn" name="remove-btn">'
                + '<i class="glyphicon glyphicon-remove icon-white"></i>'
                + '</button>'
                + '</div>'
                + '<div class="panel-body">'
                + '<div class="input-group">'
                + '<div class="input-group-addon">名称</div>'
                + '<input type="text"  value="" name="post['+ next_index +'][name]" size="83" class="form-control post_name">'
                + '</div>'
                + '<label for="post['+ next_index +'][name]" class="error" id="post['+ next_index +'][name]-error"></label>'
                + '<p></p>'
                + '<div class="input-group">'
                + '<div class="input-group-addon">拠点数</div>'
                + '<input type="text"  value="" name="post['+ next_index +'][count]" size="5" class="form-control post_count">'
                + '<div class="input-group-addon">点</div>'
                + '</div> '
                + '<label for="post['+ next_index +'][count]" class="error" id="post['+ next_index +'][count]-error"></label>'
                + ' <div class="input-group">'
                + '<div class="input-group-addon">単価</div>'
                + '<input type="text" value="" name="post['+ next_index +'][price]" size="12" class="form-control post_price">'
                + '<div class="input-group-addon">円</div>'
                + '</div>'
                + '<label for="post['+ next_index +'][price]" class="error" id="post['+ next_index +'][price]-error"></label>'
                + '<p></p>'
                + '<div class="input-group">'
                + '<div class="input-group-addon">備考</div>'
                + '<textarea name="post[' + next_index + '][note]" rows="3" cols="80" class="form-control post_note"></textarea>'
                + '</div>'
                + '<label for="post['+ next_index +'][note]" class="error" id="post['+ next_index +'][note]-error"></label>'
                + '</div></div>';

            $(html).appendTo($(this).closest('tr').find('td:nth-child(2)'));
            validate();
        });
    };

    //remove post panel
    var click_remove_post_panel = function(){
        $(document).on('click','.remove_post_btn', function(){
            $(this).closest('.panel-default').remove();
        });
    };

    var focus_media = function(){
        $('input[name=media_name],input[name=media_version_name]').on('focus', function(){
            $(this).autocomplete('search', $(this).val());
        });
    };
    /*END SCREEN CREATE MEDIA*/

    /*SCREEN LIST MEDIA*/
    //move to screen create media
    var click_media_add_btn = function(){
        $('#media_create_btn').click(function(){
            window.location = baseUrl + 'master/media';
        });
    };

    //delete media
    var click_media_delete_btn = function(){
        $('.media_delete_btn').click(function(){
            if(confirm(message_confirm_del))
            {
                var form = $("#form_search_media"),
                    media_id = $(this).closest('ul').find('input[type=hidden]').val();
                form.attr("action", baseUrl + "master/media/delete").attr('method', 'POST');
                $('#m_media_id').val(media_id);
                form.submit();
            }
        });
    };

    //get partner if choose group
    var get_partner = function(){
        $('#medias_group').off('change').on('change',function(){
            _process_get_partner();
        });
    };

    var _process_get_partner = function(){
        var param = {
            m_group_id: $('#medias_group').val()
        };
        var request = $.ajax({
            type: 'post',
            data: param,
            url: baseUrl + 'master/medias/get_partner'
        });
        var response = request.done(function(data){
            data = jQuery.parseJSON(data);
            var option = '';
            $.each(data, function(key, value){
                option += '<option value="' + key + '">' + value + '</option>';
            });
            $('#medias_partner').html(option);
        });
    };
    /*END SCREEN LIST MEDIA*/
    return {
        init:function(){
            validate();
            click_back_to_media_list();
            click_add_post_panel();
            click_remove_post_panel();
            click_media_add_btn();
            click_media_delete_btn();
            convert_zen2han();
            get_partner();
            submit();
            focus_media();
        }
    };
}();

$(function(){
    media.init();
});
