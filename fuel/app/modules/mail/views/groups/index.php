<?php echo \Fuel\Core\Asset::js('validate/mail_group.js');?>
<h3>
    メールグループリスト
    <a href="<?php echo \Fuel\Core\Uri::base();?>mail/group" class="btn btn-info btn-sm" name="add-btn">
        <i class="glyphicon glyphicon-plus icon-white"></i>
        新規追加
    </a>
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

<form id="form_mail_group" class="form-inline" method="get" action="<?php echo \Fuel\Core\Session::get('url_mail_group_list') ? \Fuel\Core\Session::get('url_mail_group_list') : '';?>">
    <nav>
        <div class="row">
            <div class="col-md-6">
                <?php if($total_group) {?>
                    <?php echo html_entity_decode($pagination_group);?>
                    <input type="hidden" name="limit_group" value="<?php echo Fuel\Core\Input::get('limit_group', '')?>">
                    <div style="margin: 20px 0;">
                        <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit_group') ? \Fuel\Core\Input::get('limit_group') : 100, Constants::$limit_pagination, array('class' => 'form-control limit_group'))?>
                    </div>
                <?php }?>
            </div>
            <div class="col-md-6">
                <?php
                echo html_entity_decode($pagination_partner);
                ?>
                <input type="hidden" name="limit_partner" value="<?php echo Fuel\Core\Input::get('limit_partner', '')?>">
                <?php if (!empty($list_partner_sales[1])) {?>
                    <div style="margin: 20px 0;">
                        <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit_partner') ? \Fuel\Core\Input::get('limit_partner') : 100, Constants::$limit_pagination, array('class' => 'form-control limit_partner'))?>
                    </div>
                <?php }?>
            </div>
        </div>
    </nav>
</form>
<div class="form-inline">
    <div class="row">
        <div class="col-md-6">
            <?php
            if(empty($mail_groups)) {
                ?>
                <div role="alert" class="alert alert-danger alert-dismissible">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>該当するデータがありません
                </div>
                <?php
            } else {
                ?>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th class="text-center">メールグループ名</th>
                        <th class="text-center">送信先氏名</th>
                        <th class="text-center">管理</th>
                    </tr>
                    <?php
                    $user_obj = new Model_Muser();
                    $all_user = array_column($user_obj->get_data_array(),'name','user_id');
                    foreach($mail_groups as $k => $v) {
                        $users = $v['users'] ? explode(',', trim($v['users'], ',')) : [];
                        $name = '';
                        foreach($users as $key => $value) {
                            $name .= $all_user[$value].'／';
                        }
                        $name = trim($name, '／');
                        ?>
                        <tr>
                            <td><?php echo $v['mail_group_name']?></td>
                            <td><?php echo $name; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success">
                                        処理
                                        <span class="caret"></span>
                                    </a>
                                    <ul name="add-pulldown" class="dropdown-menu">
                                        <li><a href="<?php echo \Fuel\Core\Uri::base()?>mail/group?mail_group_id=<?php echo $v['mail_group_id']?>" name="add-btn"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
                                        <?php if ($login_info['division_type'] == 1) { ?>
                                        <li>
                                            <form method="post" action="<?php echo \Fuel\Core\Uri::base()?>mail/groups/delete">
                                                <input type="hidden" name="mail_group_id" value="<?php echo $v['mail_group_id']?>">
                                                <a class="delete_mail_group" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i> 削除</a>
                                            </form>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            }
            ?>

            <div class="col-md-12" style="padding-left: 0">
                <?php
                if($total_group) {
                    echo html_entity_decode($pagination_group);
                    ?>
                    <div style="margin: 20px 0;">
                        <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit_group') ? \Fuel\Core\Input::get('limit_group') : 100, Constants::$limit_pagination, array('class' => 'form-control limit_group'))?>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="col-md-6">
            <?php
            if(empty($list_partner_sales[1])) {
                ?>
                <div role="alert" class="alert alert-danger alert-dismissible">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>該当するデータがありません
                </div>
                <?php
            } else {
                ?>

                <div class="panel panel-danger">
                    <div class="panel-heading">現在メールグループ未指定の取引先(支店)～売上形態</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach($list_partner_sales[1] as $k => $v) {?>
                                <li class="list-group-item">
                                    <?php echo explode('/', $v)[0];?>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="col-md-12" style="padding-left: 0">
            <?php
                echo html_entity_decode($pagination_partner);
                ?>
                <?php if (!empty($list_partner_sales[1])) {?>
                    <div style="margin: 20px 0;">
                        <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit_partner') ? \Fuel\Core\Input::get('limit_partner') : 100, Constants::$limit_pagination, array('class' => 'form-control limit_partner'))?>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<style>
    .dropdown-menu > li > form > a {
        clear: both;
        color: #333;
        display: block;
        font-weight: 400;
        line-height: 1.42857;
        padding: 3px 20px;
        white-space: nowrap;
    }
    .dropdown-menu > li > form > a:hover, .dropdown-menu > li > form > a:focus{
        background-color: #357ebd;
        background-image: linear-gradient(to bottom, #428bca 0px, #357ebd 100%);
        background-repeat: repeat-x;
        text-decoration: none;
    }
    .pagination {
        float: left;
        margin-right: 10px;
    }
    #limit_group, #limit {
        margin : 20px 0;
    }
</style>
