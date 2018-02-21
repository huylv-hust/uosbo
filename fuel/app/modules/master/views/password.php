<?php echo \Fuel\Core\Asset::js('validate/password.js')?>
<div class="container">
    <h3>
        ログインアカウント
    </h3>
    <?php
    if(Session::get_flash('error'))
    {
        ?>
        <div role="alert" class="alert alert-danger alert-dismissible">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <?php echo Session::get_flash('error');?>
        </div>
        <?php
    }

    if(Session::get_flash('success'))
    {
        ?>
        <div role="alert" class="alert alert-success alert-dismissible">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <?php echo Session::get_flash('success');?>
        </div>
        <?php
    }
    ?>
    <?php echo Form::open(array('class' => 'form-inline', 'id' => 'password_form'));?>

        <table class="table table-striped">
            <tr>
                <th class="text-right">パスワード</th>
                <td>
                    <?php echo Form::input('password', '', array('type' => 'password', 'class' => 'form-control', 'size' => 50));?>
                    <span class="text-info">※必須</span>
                    <label id="form_password-error" class="error" for="form_password"></label>
                </td>
            </tr>
            <tr>
                <th class="text-right">パスワード(確認用)</th>
                <td>
                    <?php echo Form::input('confirm', '', array('type' => 'password', 'class' => 'form-control', 'size' => 50));?>
                    <span class="text-info">※必須</span>
                    <label id="form_confirm-error" class="error" for="form_confirm"></label>
                </td>
            </tr>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="glyphicon glyphicon-pencil icon-white"></i>
                保存
            </button>
        </div>

    <?php echo Form::close(); ?>

</div>
