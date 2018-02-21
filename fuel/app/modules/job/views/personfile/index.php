<?php echo Asset::js('module/personfile.js'); ?>
<style>
	div.image-box {
		margin: 10px 10px 10px 0px;
	}

	button.remove-btn {
		position: relative;
		left: -20px;
		top: -10px;
		padding: 8px;
		vertical-align: top;
	}
</style>

<div class="container">
	<h3>
		本人確認書類
		<div class="text-right">
			<a class="btn btn-warning btn-sm" href="<?php if(\Fuel\Core\Cookie::get('person_url')) echo \Fuel\Core\Cookie::get('person_url'); else echo Uri::base(true).'job/persons'?>">
					<i class="glyphicon glyphicon-arrow-left icon-white"></i>
					戻る
			</a>
		</div>
	</h3>

	<p class="text-center">
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/person?person_id=<?php echo $person_id; ?>">応募者</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $person_id; ?>">採用管理</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/personfile?person_id=<?php echo $person_id; ?>">本人確認書類</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/interviewusami?person_id=<?php echo $person_id; ?>">面接票</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/emcall?person_id=<?php echo $person_id; ?>">緊急連絡先</a>
	</p>

	<!-- ticket 1065 (thuanth6589) -->
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>対象SS</label>
						<input class="form-control" value="<?php echo $ss_info;?>" disabled type="text">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>氏名（漢字）</label>
						<input class="form-control" value="<?php echo $person['name'];?>" disabled type="text">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>氏名（かな）</label>
						<input class="form-control" value="<?php echo $person['name_kana'];?>" disabled type="text">
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(Session::get_flash('success')){?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<?php echo Session::get_flash('success');?>
	</div>
	<?php } ?>
	<form class="form-inline" method="POST" action="" id="form_submit"  enctype="multipart/form-data" name="post_file">

		<table class="table table-striped">
			<?php
				$img_cf = \Constants::$_personfile;
			?>
			<tbody>



			<tr>
				<th style="width:50%" class="text-right">
					免許証(表)
					<button id="1" name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button">
						<i class="glyphicon glyphicon-plus icon-white"></i> 画像選択
					</button>
					<input type="file" attr_id="1" id="1" class="image hide" name="image">
				</th>
				<td>
					<div class = "image-box pull-left image_panel" id = "image-1">
						<?php if($img['1']['content']) {?>
							<img onclick="view_img(this)" width="200" src="data:image/jpeg;base64,<?php echo $img['1']['content'] ?>">
							<button id="1" class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							<input type="hidden"  name="content[1]" value="<?php echo $img['1']['content'] ?>" />

						<?php }?>
					</div>
					<?php $img['1']['content'] ? $class = 'class="hide"': $class = 'class="show"';?>
					<span id="show_1" <?php echo $class?>>※未登録</span>


				</td>

			</tr>
			<tr>
				<th style="width:50%" class="text-right">
					学生証
					<button id="2" name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button">
						<i class="glyphicon glyphicon-plus icon-white"></i> 画像選択
					</button>
					<input type="file" attr_id="2" id="2" class="image hide" name="image">
				</th>
				<td>
					<div class = "image-box pull-left image_panel" id = "image-2">
						<?php if($img['2']['content']) {?>
							<img onclick="view_img(this)" width="200" src="data:image/jpeg;base64,<?php echo $img['2']['content'] ?>">
							<button id="2" class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							<input type="hidden"  name="content[2]" value="<?php echo $img['2']['content'] ?>" />
						<?php }?>
					</div>
					<?php $img['2']['content'] ? $class = 'class="hide"': $class = 'class="show"';?>
					<span id="show_2" <?php echo $class?>>※未登録</span>
				</td>

			</tr>
			<tr>
				<th style="width:50%" class="text-right">
					銀行口座通帳
					<button id="3" name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button">
						<i class="glyphicon glyphicon-plus icon-white"></i> 画像選択
					</button>
					<input type="file" attr_id="3" id="3" class="image hide" name="image">
				</th>
				<td>
					<div class = "image-box pull-left image_panel" id = "image-3">
						<?php if($img['3']['content']) {?>
							<img onclick="view_img(this)" width="200" src="data:image/jpeg;base64,<?php echo $img['3']['content'] ?>">
							<button id="3" class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							<input type="hidden"  name="content[3]" value="<?php echo $img['3']['content'] ?>" />
						<?php }?>
					</div>
					<?php $img['3']['content'] ? $class = 'class="hide"': $class = 'class="show"';?>
					<span id="show_3" <?php echo $class?>>※未登録</span>
				</td>
			</tr>
			<tr>
				<th style="width:50%" class="text-right">
					自賠責
					<button id="4" name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button">
						<i class="glyphicon glyphicon-plus icon-white"></i> 画像選択
					</button>
					<input type="file" attr_id="4" id="4" class="image hide" name="image">
				</th>
				<td>
					<div class = "image-box pull-left image_panel" id = "image-4">
						<?php if($img['4']['content']) {?>
							<img onclick="view_img(this)" width="200" src="data:image/jpeg;base64,<?php echo $img['4']['content'] ?>">
							<button id="4" class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							<input type="hidden"  name="content[4]" value="<?php echo $img['4']['content'] ?>" />
						<?php }?>
					</div>
					<?php $img['4']['content'] ? $class = 'class="hide"': $class = 'class="show"';?>
					<span id="show_4" <?php echo $class?>>※未登録</span>
				</td>

			</tr>
			<tr>
				<th style="width:50%" class="text-right">
					任意保険
					<button id="5" name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button">
						<i class="glyphicon glyphicon-plus icon-white"></i> 画像選択
					</button>
					<input type="file" attr_id="5" id="5" class="image hide" name="image">
				</th>
				<td>
					<div class = "image-box pull-left image_panel" id = "image-5">
						<?php if($img['5']['content']) {?>
							<img onclick="view_img(this)" width="200" src="data:image/jpeg;base64,<?php echo $img['5']['content'] ?>">
							<button id="5" class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							<input type="hidden"  name="content[5]" value="<?php echo $img['5']['content'] ?>" />
						<?php }?>
					</div>
					<?php $img['5']['content'] ? $class = 'class="hide"': $class = 'class="show"';?>
					<span id="show_5" <?php echo $class?>>※未登録</span>
				</td>

			</tr>
			</tbody>
		</table>

		<div class="text-center">
			<button type="button" onclick="submit_form()" class="btn btn-primary btn-sm">
				<i class="glyphicon glyphicon-pencil icon-white"></i>
				保存
			</button>
		</div>

	</form>

</div>
<script type="text/javascript">
	function submit_form()
	{
		//$("#form_submit").submit();
		try
		{
            $("#form_submit").submit();
        }
		catch(e)
		{
            try
			{
                $("#form_submit").submit();
            }
			catch(e)
			{
                try
				{
                    $("#form_submit").submit();
                }
				catch(e)
				{
					submit_form();
                }
            }
        }
	}


	function view_img(obj)
	{
		var myW = window.open('');
		myW.document.write('<div style="text-align: center;"><img src='+obj.src+' /></div>');
	}
</script>

