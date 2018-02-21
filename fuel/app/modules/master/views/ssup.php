
<h3>
    取引先（勤務地）アップロード
</h3>

<form id="upload-form" class="form-inline" method="post" enctype="multipart/form-data" action="">
    <input name="csv" class="hide" type="file">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row text-center">
                <span id="filename" class="text-info"></span>
                <button type="button" class="btn btn-default btn-sm" name="file-btn"><i class="glyphicon glyphicon-file icon-white"></i> CSVファイルを選択</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-upload icon-white"></i> アップロード実行</button>
            </div>
        </div>
    </div>
</form>
<?php if(Session::get_flash('success')) { ?>
    <div role="alert" class="alert alert-success alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
        <?php echo Session::get_flash('success'); ?>
    </div>
<?php } ?>
<?php
if($approve = Session::get_flash('approve')) {?>
    <ul class="list-group">
        <?php
        foreach($approve as $index => $value)
        {
            echo '<li class="list-group-item">'.$value.'</li>';
        }
        ?>
    </ul>
<?php } ?>
<?php
if($error = Session::get_flash('error')) {?>
    <div role="alert" class="alert alert-danger alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
        以下のエラーが発生しました。
    </div>
    <ul class="list-group">
        <?php
        foreach($error as $index => $value)
        {
            echo '<li class="list-group-item">'.$value.'</li>';
        }
        ?>
    </ul>
<?php } ?>

<script>
    $(function (e)
    {
        $('input[name=csv]').on('change', function()
        {
            if (this.files.length > 0)
            {
                $('#filename').text(this.files[0].name + ':　');
            }
        });

        $('button[name=file-btn]').on('click', function()
        {
            $('input[name=csv]').trigger('click');
        });

        $('#upload-form').on('submit', function()
        {
            if ($('input[name=csv]').get(0).files.length == 0)
            {
                alert('CSVファイルを選択してください');
                return false;
            }

            if (confirm('アップロードを実行します、よろしいですか？') == false)
            {
                return false;
            }
        });
    });
</script>
