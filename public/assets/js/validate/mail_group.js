var mail_group = function () {
    //validate
    var validate = function () {
        $('#mail_group_form').validate({
            rules: {
                mail_group_name: {
                    required: true
                }
            },
            messages: {
                mail_group_name: {
                    required: 'メールグループ名を入力して下さい'
                }
            }
        });

        $('select.select_sale_type').each(function(){
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "売上形態を入力して下さい"
                }
            });
        });
    };

    //submit
    var submit = function () {
        var form = $('#mail_group_form'),
            valid;
        form.on('submit', function () {
            valid = form.valid();
            if (valid == false)
                return false;

            if (confirm(message_confirm_save))
                return true;

            return false;
        });
    };

    //open search user modal
    var open_modal_user = function () {
        $('button[name=adduser-btn]').on('click', function () {
            $('#userfinder').modal();
            return false;
        });
    };

    //search user
    var search_user = function () {
        $('#user_search').on('click', function () {
            var keyword = $('#userfinder .modal_keyword').val();
            $.ajax({
                url: baseUrl + 'ajax/common/searchUser',
                method: 'POST',
                data: {keyword: keyword},
                dataType: 'json'
            }).success(function (data) {
                var html = '';
                $.each(data, function (key, value) {
                    html += '<span class="list-group-item" user-id="' + value.user_id + '">' + value.name + '</span>';
                });

                $('#userfinder .list_user').html(html);
                if (data.length == 0) {
                    alert('見つかりませんでした');
                }
            });
        });
    };

    //get user from search modal
    var get_user = function () {
        $(document).on('click', '.list-group span.list-group-item', function () {
            var user_id = $(this).attr('user-id'),
                user_name = $(this).text();
            var html = '<div class="user-block">' +
                '<span class="user-name">' + user_name + '</span>' +
                '<input type="hidden" name="users[]" value="' + user_id + '">' +
                '<button type="button" class="btn btn-danger btn-sm" name="remove-user-btn">' +
                '<i class="glyphicon glyphicon-trash icon-white"></i></button></div>';
            $('#users').append(html);
            $('#userfinder').modal('hide');
            return false;
        });
    };

    //remove user
    var remove_user = function () {
        $('#users').on('click', 'button[name=remove-user-btn]', function () {
            $(this).parents('div.user-block:first').remove();
            return false;
        });
    };

    //open search partner modal
    var open_modal_partner = function () {
        $('button[name=addpartner-btn]').on('click', function () {
            $('#partnerfinder').modal();
            return false;
        });
    };

    //search partner
    var search_partner = function () {
        $('#partner_search').on('click', function () {
            var keyword = $('#partnerfinder .modal_keyword').val();
            $.ajax({
                url: baseUrl + 'ajax/common/searchPartner',
                method: 'POST',
                data: {
                    keyword: keyword,
                    type: 1
                },
                dataType: 'json'
            }).success(function (data) {
                var html = '';
                $.each(data, function (key, value) {
                    html += '<span class="list-group-item" partner-code="' + value.partner_code + '">' + value.group_name + ' ' + value.branch_name + '</span>';
                });

                $('#partnerfinder .list_partner').html(html);
                if (data.length == 0) {
                    alert('見つかりませんでした');
                }
            });
        });
    };

    //remove partner
    var remove_partner = function () {
        $('#partners').on('click', 'button[name=remove-partner-btn]', function () {
            $(this).parents('div.partner-block:first').remove();
            return false;
        });
    };

    //get partner
    var get_partner = function () {
        $('#partnerfinder').on('click', '.list-group span.list-group-item', function () {
            var next_index = ($('#partners .partner-block').length == 0) ? 0 : parseInt($('#partners .partner-block:last').attr('attr-index')) + 1;
            var select_sale_type = '<select id="form_sale_type[' + next_index + ']" class="form-control select_sale_type" name="sale_type[' + next_index + ']">' +
                                '<option value="">選択して下さい</option>';

            for(var i = 1; i <= count_sale_type; i ++) {
                if(sale_type[i] != undefined) {
                    select_sale_type += '<option value="' + i + '">' + sale_type[i] + '</option>';
                }
            }
            select_sale_type += '</select>';

            var html = '<div class="partner-block" attr-index="' + next_index + '">' +
                    '<input type="hidden" name="partner_code[' + next_index + ']" value="' + $(this).attr('partner-code') + '"/>' +
                    '<span class="partner-name">' + $(this).text() + '</span> ' +
                    '<div class="input-group">' +
                    '<div class="input-group-addon">勤務形態</div>' +
                    select_sale_type +
                    '</div> ' +
                    '<button type="button" class="btn btn-danger btn-sm" name="remove-partner-btn">' +
                    '<i class="glyphicon glyphicon-trash icon-white"></i></button>' +
                    '<label id="form_sale_type[' + next_index + ']-error" class="error" for="form_sale_type[' + next_index + ']"></label>' +
                    '</div>';

            $('#partners').append(html);
            $('#partnerfinder').modal('hide');
            validate();
            return false;
        });
    };

    //delete mail group
    var delete_group = function() {
        $('a.delete_mail_group').on('click', function() {
            if(confirm(message_confirm_del))
            {
                $(this).closest('form').submit();
            }
        });
    };

    //change limit mail group
    var change_limit_group = function() {
        $(".limit_group").on('change',function(){
            var val = $(this).val();
            $("input[name='limit_group']").val(val);
            $("#form_mail_group").submit();
        });
    };

    //change limit partner
    var change_limit_partner = function() {
        $(".limit_partner").on('change',function(){
            var val = $(this).val();
            $("input[name='limit_partner']").val(val);
            $("#form_mail_group").submit();
        });
    };

    return {
        init: function () {
            validate();
            submit();
            open_modal_user();
            search_user();
            get_user();
            remove_user();
            open_modal_partner();
            search_partner();
            remove_partner();
            get_partner();
            delete_group();
            change_limit_group();
            change_limit_partner();
        }
    };
}();

$(function () {
    mail_group.init();

    $('div.modal-body form').on('submit', function() {
        $(this).find('button:first').trigger('click');
        return false;
    });
});
