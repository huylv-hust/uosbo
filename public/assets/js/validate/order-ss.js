$(document).ready(function(){
    var optionElement = '<option value=""></option>';

    //get media list partner
    $(document).off('change').on('change' ,'select.media-group:enabled' ,function() {
        var stt = $(this).attr('datastt');
        var group_id = $(this).val();
        var object = $('select.media-group');
        var result_object = 'select.media-partner';
        $('select.media-item'+stt+':enabled').html('<option value="">媒体を選択して下さい</option>');
        get_list_partner(object, stt, 2, group_id, result_object);
    });

    //get ss list partner
    $(document).on('change' ,'select.ss-group' ,function() {
        var stt = $(this).attr('datastt');
        var group_id = $(this).val();
        var object   = $('select.ss-group');
        var result_object = 'select.ss-partner';
        $('select.ss-item'+stt).html('<option value="">SSを選択して下さい</option>');
        if(group_id == '' || group_id == 0){
            $('select.ss-partner'+stt+':enabled').html('<option value="">取引先を選択して下さい</option>');
            $('select.ss-item'+stt+':enabled').html('<option value="">SSを選択して下さい</option>');
            return false;
        }
        get_list_partner(object, stt, 1, group_id, result_object);
    });

    //get list partner
    function get_list_partner(object, stt, type, group_id, result_object){
        if(group_id == '' || group_id == 0){
            $('select.media-partner'+stt+':enabled').html('<option value="">取引先を選択して下さい</option>');
            $('select.media-item'+stt+':enabled').html('<option value="">媒体を選択して下さい</option>');
            return false;
        }
        $.post(baseUrl + 'filtergroups/partner_list',{group_id: group_id, type: type}, function(data){
            var result = jQuery.parseJSON(data);
            var partners = result['partners'];
            var strString = '<option value="">取引先を選択して下さい</option>';
            for (var i = 0; i < partners.length; i++) {
                strString += '<option value=' + partners[i].partner_code + '>' + partners[i].branch_name + '</option>';
            }
            $(result_object+stt+':enabled').html(strString);
        });
    }

    //get list media id
    $(document).on('change' ,'select.media-partner:enabled' ,function() {
        var stt = $(this).attr('datastt');
        var partner_id = $(this).val();
        if(partner_id == '' || partner_id == 0){
            $('select.media-item'+stt+':enabled').html('<option value="">媒体を選択して下さい</option>');
            return false;
        }
        $.post(baseUrl + 'filtergroups/media_list',{partner_id: partner_id}, function(data){
            var result = jQuery.parseJSON(data);
            var media = result['list_media'];
            var strString = '<option value="">媒体を選択して下さい</option>';
            for (var i = 0; i < media.length; i++) {
                strString += '<option value=' + media[i].m_media_id + '>' + media[i].media_name + '</option>';
            }
            $('.media-item'+stt +':enabled').html(strString);
        });
    });

    //get list sscode
    $(document).on('change' ,'select.ss-partner' ,function() {
        var stt = $(this).attr('datastt');
        var partner_id = $(this).val();
        if(partner_id == '' || partner_id == 0){
            $('select.ss-item'+stt+':enabled').html('<option value="">SSを選択して下さい</option>');
            return false;
        }
        $.post(baseUrl + 'filtergroups/ss_list',{partner_id: partner_id}, function(data){
            var result = jQuery.parseJSON(data);
            var sscode = result['list_ss'];
            var strString = '<option value="">SSを選択して下さい</option>';
            for (var i = 0; i < sscode.length; i++) {
                strString += '<option value=' + sscode[i].ss_id + '>' + sscode[i].ss_name + '</option>';
            }
            $('.ss-item'+stt).html(strString);
        });
    });

    var listgroup = null;

    $.post(baseUrl + 'filtergroups/group_list',{some_data:null}, function(data){
        var result = jQuery.parseJSON(data);
        var listall = result['listgroup'];
        for (var i = 0; i < listall.length; i++) {
            listgroup += '<option value=' + listall[i].m_group_id + '>' + listall[i].name + '</option>';
        }
    });

    //append media
    $('button[name=add-media-btn]:enabled').off('click').on('click',function(){
        var lengitem = $('div.media-append div.media').length,
        count = (lengitem == 0) ? 1 : parseInt($('div.media-append > .media:last').find('.stt').val()) + 1;
        var elementMedia = '<div class="media"><input class="stt" type="hidden" value="'+ count +'"><div class="input-group"><div class="input-group-addon">取引先グループ</div><select class="form-control media-group" datastt="'+count+'"><option value="">取引先グループを選択して下さい</option>'+listgroup+'</select></div> <div class="input-group"><div class="input-group-addon">取引先(発注先)</div><select class="form-control media-partner media-partner'+count+'" datastt="'+count+'"><option value="">取引先を選択して下さい</option></select></div> <div class="input-group"><div class="input-group-addon">媒体</div><select name="media_list[]" class="form-control media-item'+count+'"><option value="">媒体を選択して下さい</option></select></div> <button type="button" class="btn btn-danger btn-sm" name="remove-media-btn"><i class="glyphicon glyphicon-remove"></i></button></div>';
        $('div.media-append').append(elementMedia);
    });
    //append ss
    $('button[name=add-ss-btn]:enabled').off('click').on('click',function(){
        var lengitem = $('td#copy-ss div.ss-block').length;
        count = (lengitem == 0) ? 1 : parseInt($('td#copy-ss > .ss-block:last').find('.stt').val()) + 1;
        var elementSS = '<div class="ss-block"><input class="stt" type="hidden" value="'+ count +'"><div class="input-group"><div class="input-group-addon">グループ</div><select class="form-control ss-group" datastt="'+count+'"><option value="">グループを選択して下さい</option>'+listgroup+'</select></div> <div class="input-group"><div class="input-group-addon">取引先(受注先)</div><select class="form-control ss-partner ss-partner'+count+'" datastt="'+count+'"><option value="">取引先を選択して下さい</option></select></div> <div class="input-group"><div class="input-group-addon">SS</div><select name="ss_list[]" class="form-control ss-item'+count+'"><option value="">SSを選択して下さい</option></select></div> <button type="button" class="btn btn-danger btn-sm" name="remove-ss-btn"><i class="glyphicon glyphicon-trash icon-white"></i></button></div>';
        $('#copy-ss').append(elementSS);
    });
    //remove media
    $(document).on('click', 'button[name=remove-media-btn]', function(){
        var length = $('td#medias .media-append div.media').length;
        if(length == 1){
            alert('全てを削除は出来ません');
            $(this).parent().find('select option').prop('selected', false);
            return false;
        }
        $(this).parent().remove();
    });
     //remove ss
    $(document).on('click', 'button[name=remove-ss-btn]', function(){
        $(this).parent().remove();
    });
});

