var support = function(){
    var change_status = function(){
        $('.concierges-change-0').click(function(){
            if( ! confirm('対応済にします、よろしいですか？')) return;
            var register_id = $(this).attr('value');
            $('#form-status').attr('value', '0');
            $('#form-register_id').attr('value', register_id);
            $('#list-concierges').attr('method','post');
            $('#list-concierges').attr('action', baseUrl+'support/concierges/change_status');
            $('#list-concierges').submit();

        });
        $('.concierges-change-1').click(function(){
            if( ! confirm('未対応に戻します、よろしいですか？')) return;
            var register_id = $(this).attr('value');
            $('#form-status').attr('value', '1');
            $('#form-register_id').attr('value', register_id);
            $('#list-concierges').attr('method','post');
            $('#list-concierges').attr('action', baseUrl+'support/concierges/change_status');
            $('#list-concierges').submit();
        });

        $('.contact-change-0').click(function(){
            if( ! confirm('対応済にします、よろしいですか？')) return;
            var contact_id = $(this).attr('value');
            $('#form-status').attr('value', '0');
            $('#form-contact_id').attr('value', contact_id);
            $('#list-contact').attr('method','post');
            $('#list-contact').attr('action', baseUrl+'support/contacts/change_status');
            $('#list-contact').submit();
        });

        $('.contact-change-1').click(function(){
            if( ! confirm('未対応に戻します、よろしいですか？')) return;
            var contact_id = $(this).attr('value');
            $('#form-status').attr('value', '1');
            $('#form-contact_id').attr('value', contact_id);
            $('#list-contact').attr('method','post');
            $('#list-contact').attr('action', baseUrl+'support/contacts/change_status');
            $('#list-contact').submit();
        });
    };

    return {
        init:function(){
            change_status();
        }
    };
}();

$(function(){
    support.init();
});
