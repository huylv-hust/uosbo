/*
* params: JS using presenter
 */
var sale_type = {'1':'直接雇用','2':'職業紹介','3':'派遣','4':'紹介予定派遣','5':'請負','6':'求人代行'};

var plz_choice = '<option value="">----</option>';
var pgroup = function(){
    var ready = function(){
    };
    var filterpartners = function(){
        var group_id = $('#form_m_group_id').val();
        $.ajax({
           url: baseUrl+'filtergroups/partner_list',
           method: 'POST',
           data: {group_id: group_id,type: type},
           dataType: 'json'
        })
                .success(function(data){
                    var partners = data.partners;
                    var strString = '<option value="">取引先を選択して下さい</option>';
                    for(var i = 0;i < partners.length;i++){
                        strString += '<option value='+partners[i].partner_code+'>'+((partners[i].branch_name != null) ? partners[i].branch_name : '')+'</option>';
                    }
                    $('#form_partner_code').html(strString);
        });
    };
    var filterSs = function(){
        var partner_id = $('#form_partner_code').val();
        $.ajax({
            url: baseUrl+'filtergroups/ss_list',
            method: 'POST',
            data: {partner_id: partner_id},
            dataType: 'json'
        })
                .success(function(data){
                    var ss = data.list_ss;
                    var strString = '<option value="">SSを選択して下さい</option>';
                    for(var i = 0;i < ss.length;i++){
                        strString += '<option value='+ss[i].ss_id+'>'+((ss[i].ss_name != null) ? ss[i].ss_name : '')+'</option>';
                    }
                    $('#form_ss_id').html(strString);
        });
    };
    var filterSssalte = function(){
        var ss_id = $('#form_ss_id').val();
        $.ajax({
            url: baseUrl+'filtergroups/ss_sale_list',
            method: 'POST',
            data: {ss_id:ss_id},
            dataType: 'json'
        })
                .success(function(data){
                    var sssale = data.list_ss_sale;

                    var strString = '<option value="">売上形態を選択して下さい</option>';
                    for(var i = 0;i < sssale.length;i++)
                    {
                        strString += '<option value='+sssale[i].sssale_id+'>'+((sssale[i].sale_type != null) ? sale_type[sssale[i].sale_type] : '') +' '+ ((sssale[i].sale_name != null) ? sssale[i].sale_name : '')+'</option>';
                    }
                    $('#form_sssale_id').html(strString);
        });
    };
    var filter = function(){
        $('#form_m_group_id').change(function(){
            $('#show-work, #show-work .panel-body').hide();
            $('#form_partner_code').html('<option value="">取引先を選択して下さい</option>');
            $('#form_ss_id').html('<option value="">SSを選択して下さい</option>');
            $('#form_sssale_id').html('<option value="">売上形態を選択して下さい</option>');
            filterpartners();
        });
        $('#form_partner_code').change(function(){
            $('#show-work, #show-work .panel-body').hide();
            $('#form_ss_id').html('<option value="">SSを選択して下さい</option>');
            $('#form_sssale_id').html('<option value="">売上形態を選択して下さい</option>');
            filterSs();
        });
        $('#form_ss_id').change(function(){
            $('#show-work, #show-work .panel-body').hide();
            $('#form_sssale_id').html('<option value="">売上形態を選択して下さい</option>');
            filterSssalte();
        });
    };

    return{
        init : function(){
            filter();
        }
    };
}();
$(function(){
   pgroup.init();
});