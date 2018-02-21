<style>
    .ui-datepicker {
        z-index: 9999 !important;
    }
</style>
<h3>
    非送信日設定
    <button type="button" class="btn btn-info btn-sm" name="add-btn">
        <i class="glyphicon glyphicon-plus icon-white"></i> 新規追加
    </button>
</h3>
<?php
if(Session::get_flash('add_success')){?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <?php echo Session::get_flash('add_success');?>
</div>
<?php }?>

<?php
if(Session::get_flash('add_error')){?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php echo Session::get_flash('add_error');?>
    </div>
<?php }?>

<?php
if(Session::get_flash('delete_success')){?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php echo Session::get_flash('delete_success');?>
    </div>
<?php }?>
<div class="panel panel-default">
    <div class="panel-heading">登録済み非送信日</div>
    <div class="panel-body">
        <ul class="list-group">
            <?php
            foreach($holidays as $key =>$value) {
                ?>
                <li class="list-group-item">
                    <?php echo $value ?>
                    <button type="button" class="btn btn-danger btn-sm" id="<?php echo $value?>" name="remove-btn">
                        <i class="glyphicon glyphicon-trash icon-white"></i>
                    </button>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
<div id="inputform" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group form-inline">
                    <div class="groupnotice" style="display: none">
                        <div class="alert alert-danger" role="alert">送信日を入力して下さい</div>
                    </div>
                    <label class="col-md-2 control-label">送信日</label>
                    <div class="col-md-10">
                        <input class="form-control dateform" placeholder="YYYY-MM-DD" type="text" name="date_holiday" id="date_holiday">
                        <span class="text-info">※必須</span>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="button" name="add-holiday" class="btn btn-primary btn-sm">
                        <i class="glyphicon glyphicon-pencil icon-white"></i>
                        追加
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.dateform').datepicker();
    $(function ()
    {
        $('button[name=add-btn]').on('click', function ()
        {
            $('.groupnotice').hide();
            $('#inputform').modal();
            $('#date_holiday').val('');
            return false;
        });
        $('button[name=remove-btn]').on('click', function ()
        {
            if (confirm('削除します、よろしいですか？')) {
                $.post('<?php echo \Fuel\Core\Uri::base(true)?>/mail/holidays/remove',
                    {
                        'key':$(this).attr('id')
                    },
                    function(data){
                        window.location.reload();
                    }
                );
            }
        });

        $('button[name=add-holiday]').on('click', function ()
        {
            if($("#date_holiday").val() == null || $("#date_holiday").val() == ''){
                $('.groupnotice').show();
                return false;
            }
            if(confirm('追加します。よろしいですか？')){
                $.post('<?php echo \Fuel\Core\Uri::base(true)?>/mail/holidays/save',
                    {
                        'date_holiday':$("#date_holiday").val()
                    },
                    function(data){
                        window.location.reload();
                    }
                );
            }

        });

    });
</script>
