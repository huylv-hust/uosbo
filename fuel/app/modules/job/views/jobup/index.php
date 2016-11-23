<div class="container">
		<h3>
			求人アップロード
		</h3>
		<form action="" enctype="multipart/form-data" method="post" class="form-inline" id="upload-form">
			<input type="file" class="hidden" name="csv">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row text-center">
						<span class="text-info" id="filename"><?php echo $file_name ?></span>
						<button name="file-btn" class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-file icon-white"></i> CSVファイルを選択</button>
						<button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-upload icon-white"></i> アップロード実行</button>
					</div>
				</div>
			</div>
		</form>
		<?php if(isset($success)) { ?>
		<div role="alert" class="alert alert-success alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
			完了しました
		</div>
		<?php
		if(count($no_update))
		{
			echo '<ul class="list-group">';
				foreach($no_update as $key => $val)
				{
					echo '<li class="list-group-item">'.$val.'</li>';
				}
			echo '</ul>';
		}
		?>
		<?php } ?>
		<?php if(isset($error)) {?>
			<div role="alert" class="alert alert-danger alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
				以下のエラーが発生しました
			</div>
			<ul class="list-group">
				<?php

				foreach($error as $index => $val)
				{
					if(is_array($val))
					{
						foreach($val as $k => $v)
						{
							if(is_array($v))
							{
								foreach($v as $i=>$vv)
									echo '<li class="list-group-item">'.$vv.'</li>';
							}
							else
								echo '<li class="list-group-item">'.$v.'</li>';
						}
					}
					else
						echo '<li class="list-group-item">'.$val.'</li>';
				}

				?>
			</ul>
		<?php } ?>


</div>
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