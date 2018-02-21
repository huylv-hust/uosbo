var groups = function(){
    var validate = function(){
        var groupval = $('#groupname').val().trim();
        if(groupval === '' || typeof groupval =='undefined'){
            $('#groupform .groupnotice').html('<div class="alert alert-danger" role="alert">&nbsp;グループ名を入力して下さい</div>');
            return false;
        }else{
            if(groupval.length > 100)
            {
                $('#groupform .groupnotice').html('<div class="alert alert-danger" role="alert">&nbsp;グループ名は100文字以内で入力して下さい</div>');
                return false;
            }
            else
            {
                $('#groupform .groupnotice').html('');
                return true;
            }
        }
        return false;
    };
    var modal = function(groupid,groupname){
        var strString = '';
        strString +='<form id="form_groups">';
        strString += '<input id="groupid" type="hidden" value="'+groupid+'">';
        strString += '<div id="groupform" class="form-group form-inline clearfix">';
        strString += '<div class="groupnotice"></div>';
        strString += '<label class="col-md-2 control-label">法人名</label>';
        strString += '<div class="col-md-10">';
        strString += '<input type="text" id="groupname" name="groupname" required value="'+groupname+'" class="form-control" placeholder="法人名を入力" size="50">';
        strString += '<span class="text-info"></span>';
        strString += '</div>';
        strString += '</div>';
        strString += '<div class="form-group text-center">';
        strString += '<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove icon-white"></i> 閉じる</button>　';
        strString += '<button type="button" id="groupsave" class="btn btn-primary">';
        strString += '<i class="glyphicon glyphicon-pencil icon-white"></i>';
        strString += ' 保存';
        strString += '</button>';
        strString += '</div>';
        strString += '</form>';
        $('#uosmodal .modal-body').html(strString);
        $('#uosmodal').modal();
    };

    var keyenter = function(){
        $(document).on('keypress','#groupname',function(e){
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
                return false;
            }
        });
    };

    var create = function(){
        $('#creategroup').click(function(){
            modal('','');
            save();
        });
    };
    var save = function(){
        $('#groupsave').click(function(){
            if(validate() == false)
                return false;
            if (!confirm(message_confirm_save)) return false;
            var groupname = $('#groupname').val();
            $.ajax({
                url: baseUrl+'master/groups/ajaxsave',
                method: 'post',
                data: {groupname: groupname},
                dataType: 'json'
            })
                .success(function(data){
                    if(data.status == -2){
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">指定のグループ名は既に登録されています</div>');
                        return false;
                    }
                    else if(data.status == 1){
                       $('#uosmodal').modal('hide');
                        window.location = baseUrl+'master/groups';
                    }
                    else{
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">保存に失敗しました。</div>');
                        return false;
                    }
                });
        });
    };
    var edit = function(){
        $('.edit_group').click(function(){
            var groupid = $(this).attr('value');
            $.ajax({
                url: baseUrl+'master/groups/edit',
                method: 'post',
                dataType: 'json',
                data: {groupid: groupid}
            })
                .success(function(data){
                    if(data == -1)//If id value not exist
                    {
                        var ourLocation = document.URL;
                        window.location = ourLocation;
                    }

                    var group = data['0'];
                    modal(groupid,group.name);
                    editaction();
                });
        });
    };
    var editaction = function(){
        $('#groupsave').click(function(){
            if(validate() == false)
                return false;
            if (!confirm(message_confirm_save)) return false;
            var groupid = $('#groupid').val();
            var groupname = $('#groupname').val();
            $.ajax({
                url: baseUrl+'master/groups/ajaxsave',
                method: 'post',
                data: {groupid: groupid, groupname: groupname},
                dataType: 'json'
            })
                .success(function(data){
                    if(data.status == -2){
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">指定のグループ名は既に登録されています</div>');
                        return false;
                    }
                    else if(data.status == -1)
                    {
                        $('#uosmodal').modal('hide');
                        var ourLocation = document.URL;
                        window.location = ourLocation;
                    }
                    else if(data.status == 1){
                        setTimeout(function(){
                            $('#uosmodal').modal('hide');
                        }, 100);
                        var ourLocation = document.URL;
                        window.location = ourLocation;
                    }
                    else{
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">保存に失敗しました。</div>');
                    }
                });
        });
    };
    var deletes = function(){
        $('.delete_group').click(function(){
            if( ! confirm(message_confirm_del)) return false;
            var group_id = $(this).attr('value');
            var url = baseUrl+'master/groups/delete';
            $('#action_group').attr('action',url);
            $('#form_group_id').attr('value',group_id);
            $('#action_group').submit();
        });
    };
    /*Form partner add group*/
    var partnercreate = function(){
        $('#partnercreategroup').click(function(){
            modal('','');
            partnersave();
        });
    };
    var partnersave = function(){
        $('#groupsave').click(function(){
            if(validate() == false)
                return false;
            if (!confirm(message_confirm_save)) return false;

            var groupname = $('#groupname').val();
            $.ajax({
                url: baseUrl+'master/groups/ajaxsave',
                method: 'post',
                data: {groupname: groupname},
                dataType: 'json'
            })
                .success(function(data){
                    if(data.status == 2){
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">指定のグループ名は既に登録されています</div>');
                        return false;
                    }
                    else if(data.status == 1){
                        $('.groupnotice').html('<div class="alert alert-success" role="alert">保存しました </div>');
                        setTimeout(function(){
                            $('#uosmodal').modal('hide');
                        }, 1000);
                        var strString = '';
                        strString += '<option value="'+data.group_id+'" selected>'+groupname+'</option>';
                        $('#form_m_group_id').append(strString);
                    }
                    else{
                        $('.groupnotice').html('<div class="alert alert-danger" role="alert">保存に失敗しました。</div>');
                        return false;
                    }
                });
        });
    };

    return{
        init: function(){
            create();
            save();
            edit();
            editaction();
            deletes();
            keyenter();
            /*Partner*/
            partnercreate();
        }
    };
}();

$(function(){
    groups.init();
});
