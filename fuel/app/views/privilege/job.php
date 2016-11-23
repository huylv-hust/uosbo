<ul class="dropdown-menu" name="add-pulldown">
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>" ><a name="add-btn" style="cursor: pointer" href="<?php echo Fuel\Core\Uri::base()?>job/job?job_id=<?php echo $row['job_id']?>"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>" ><a name="add-btn" style="cursor: pointer" onclick="delete_job('<?php echo $row['job_id']?>')"><i class="glyphicon glyphicon-trash"/></i>削除</a></li>
	<li><a target="_blank" href="<?php echo trim(Fuel\Core\Config::get('uos_url'),'/') ?>/preview?enc=<?php echo Utility::encrypt($row['job_id'].':'.time()) ?>&job_id=<?php echo $row['job_id']?>&view=1#" style="cursor: pointer"><i class="glyphicon glyphicon-search"></i> プレビュー</a></li>

	<?php if($row['is_available']) { ?>
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a style="cursor: pointer" onclick="is_available('<?php echo $row['job_id']?>','<?php echo (1-(int)$row['is_available'])?>')"><i class="glyphicon glyphicon-remove"></i> 非公開にする</a></li>
	<?php } else { ?>
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a onclick="is_available('<?php echo $row['job_id']?>','<?php echo (1-(int)$row['is_available'])?>')" style="cursor: pointer"><i class="glyphicon glyphicon-ok"></i> 公開する</a></li>
	<?php } ?>

	<?php if( ! $row['status']){ ?>
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_approval)?>"><a style="cursor: pointer" onclick="approved('<?php echo $row['job_id']?>','<?php echo (1-(int)$row['status'])?>')"><i class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>
	<?php } ?>
	<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>"><a href="<?php echo Fuel\Core\Uri::base()?>job/job?copy_job_id=<?php echo $row['job_id']?>"><i class="glyphicon glyphicon-plus"></i> 複製</a></li>

	<?php if($row['is_webtoku']) { ?>
		<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a style="cursor: pointer" onclick="is_webtoku('<?php echo $row['job_id']?>','<?php echo (1-(int)$row['is_webtoku'])?>')"><i class="glyphicon glyphicon-remove"></i> WEB得OFF</a></li>
	<?php } else { ?>
		<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a onclick="is_webtoku('<?php echo $row['job_id']?>','<?php echo (1-(int)$row['is_webtoku'])?>')" style="cursor: pointer"><i class="glyphicon glyphicon-ok"></i> WEB得ON</a></li>
	<?php } ?>
</ul>