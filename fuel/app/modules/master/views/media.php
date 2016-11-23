<?php echo \Fuel\Core\Asset::js('validate/media.js')?>
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
?>
<h3>
	媒体
</h3>
	<form action="<?php echo \Fuel\Core\Uri::base(); ?>master/media/delete" method="post">
		<p class="text-right">
			<a href="<?php echo (\Fuel\Core\Session::get('medias_url')) ?  \Fuel\Core\Session::get('medias_url') :  \Fuel\Core\Uri::base().'master/medias';?>" class="btn btn-warning btn-sm right">
				<i class="glyphicon glyphicon-arrow-left icon-white"></i>
				戻る
			</a>
			<?php
			if(isset($media))
			{
			?>
			<input name="m_media_id" type="hidden" value="<?php echo $media->m_media_id; ?>">
			<button class="btn btn-danger btn-sm" type="button" id="btn_medias_back">
				<i class="glyphicon glyphicon-trash icon-white"></i>
				削除
			</button>
			<?php
			}
			?>
		</p>
	</form>

<?php echo Form::open(array('class' => 'form-inline', 'id' => 'media_form'));?>
<?php
if(isset($media))
{
	echo '<input type="hidden" name="m_media_id" value="'.$media->m_media_id.'">';
}
?>
<table class="table table-striped">
	<tbody><tr>
		<th class="text-right">取引先(発注先)</th>
		<td>
			<?php echo $filtergroup ?>
			<label id="form_partner_code-error" class="error" for="form_partner_code"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">媒体名</th>
		<td>
			<?php echo Form::input('media_name', Input::post('media_name') ? Input::post('media_name') : (isset($media) ? $media->media_name : ''), array('class' => 'form-control ui-autocomplete-input', 'size' => 50, 'autocomplete' => 'off'));?>
			<span class="text-info">※必須、登録済み名称が補完されます</span>
			<label id="form_media_name-error" class="error" for="form_media_name"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">版名</th>
		<td>
			<?php echo Form::input('media_version_name', Input::post('media_version_name') ? Input::post('media_version_name') : (isset($media) ? $media->media_version_name : ''), array('class' => 'form-control ui-autocomplete-input', 'size' => 50, 'autocomplete' => 'off'));?>
			<span class="text-info">※必須、登録済み名称が補完されます</span>
			<label id="form_media_version_name-error" class="error" for="form_media_version_name"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">自他区分</th>
		<td>
			<label class="radio-inline">
				<?php echo Form::radio('type', 1, (Input::post('type') && Input::post('type') == 1) ? true : (isset($media) && $media->type == 1 ? true : false)); ?>
				自力
			</label>
			<label class="radio-inline">
				<?php echo Form::radio('type', 2, (Input::post('type') && Input::post('type') == 2) ? true : (isset($media) && $media->type == 2 ? true : false)); ?>
				他力
			</label>
			<span class="text-info">※いずれか必須</span>
			<label id="type-error" class="error" for="type"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">予算区分</th>
		<td>
			<label class="radio-inline">
				<?php echo Form::radio('budget_type', 1, (Input::post('budget_type') && Input::post('budget_type') == 1) ? true : (isset($media) && $media->budget_type == 1 ? true : false)); ?>
				求人費
			</label>
			<label class="radio-inline">
				<?php echo Form::radio('budget_type', 2, (Input::post('budget_type') && Input::post('budget_type') == 2) ? true : (isset($media) && $media->budget_type == 2 ? true : false)); ?>
				販促費
			</label>
			<span class="text-info">※いずれか必須</span>
			<label id="budget_type-error" class="error" for="budget_type"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">分類</th>
		<td>
			<?php echo Form::select('classification', Input::post('classification') ? Input::post('classification') : (isset($media) ? $media->classification : ''), $classification, array('class' => 'form-control')); ?>
		</td>
	</tr>
	<tr>
		<th class="text-right">WEB転載</th>
		<td>
			<label class="radio-inline">
				<?php echo Form::radio('is_web_reprint', 1, (Input::post('is_web_reprint') && Input::post('is_web_reprint') == 1) ? true : (isset($media) && $media->is_web_reprint == 1 ? true : false)); ?>
				あり
			</label>
			<label class="radio-inline">
				<?php echo Form::radio('is_web_reprint', 0, (Input::post('is_web_reprint') && Input::post('is_web_reprint') == 0) ? true : (isset($media) && $media->is_web_reprint == 0 ? true : false)); ?>
				なし
			</label>
			<span class="text-info">※いずれか必須</span>
			<label id="is_web_reprint-error" class="error" for="is_web_reprint"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">掲載・公開について</th>
		<td>
			<?php echo Form::input('public_description', Input::post('public_description') ? Input::post('public_description') : (isset($media) ? $media->public_description : ''), array('class' => 'form-control', 'size' => 50));?>
		</td>
	</tr>
	<tr>
		<th class="text-right">締め切り</th>
		<td>
			<?php echo Form::input('deadline_description', Input::post('deadline_description') ? Input::post('deadline_description') : (isset($media) ? $media->deadline_description : ''), array('class' => 'form-control', 'size' => 50));?>
		</td>
	</tr>
	<tr>
		<th class="text-right">
			掲載枠
			<button id="media_post_add_btn" name="add-place-btn" class="btn btn-success btn-sm" type="button">
				<i class="glyphicon glyphicon-plus icon-white"></i>
			</button>
		</th>
		<td>
			<?php
				if(isset($posts))
				{
					foreach($posts as $k => $post)
					{
			?>
					<div class="panel panel-default">
						<input type="hidden" class="post_index" value="<?php echo $k;?>">
						<div class="panel-heading text-right">
							<button name="remove-btn" class="btn btn-default btn-sm remove_post_btn" type="button">
								<i class="glyphicon glyphicon-remove icon-white"></i>
							</button>
						</div>
						<div class="panel-body">
							<div class="input-group">
								<div class="input-group-addon">名称</div>
								<input type="hidden" value="<?php echo $post->post_id;?>" name="post[<?php echo $k; ?>][post_id]">
								<?php echo Form::input('post['.$k.'][name]', $post->name, array('class' => 'form-control post_name', 'size' => 83));?>
							</div>
							<label id="form_post[<?php echo $k;?>][name]-error" class="error" for="form_post[<?php echo $k;?>][name]"></label>
							<p></p>
							<div class="input-group">
								<div class="input-group-addon">拠点数</div>
								<?php echo Form::input('post['.$k.'][count]', $post->count, array('class' => 'form-control post_count', 'size' => 5));?>
								<div class="input-group-addon">点</div>
							</div>
							<label id="form_post[<?php echo $k;?>][count]-error" class="error" for="form_post[<?php echo $k;?>][count]"></label>
							<div class="input-group">
								<div class="input-group-addon">単価</div>
								<?php echo Form::input('post['.$k.'][price]', $post->price, array('class' => 'form-control post_price', 'size' => 12));?>
								<div class="input-group-addon">円</div>
							</div>
							<label id="form_post[<?php echo $k;?>][price]-error" class="error" for="form_post[<?php echo $k;?>][price]"></label>
							<p></p>
							<div class="input-group">
								<div class="input-group-addon">備考</div>
								<?php echo Form::textarea('post['.$k.'][note]', $post->note, array('class' => 'form-control post_note', 'cols' => 80, 'rows' => 3));?>
							</div>
							<label id="form_post[<?php echo $k;?>][note]-error" class="error" for="form_post[<?php echo $k;?>][note]"></label>
						</div>
					</div>
			<?php
					}
				}
				else
				{
			?>
				<div class="panel panel-default">
					<input type="hidden" class="post_index" value="0">
					<div class="panel-heading text-right">
						<button name="remove-btn" class="btn btn-default btn-sm remove_post_btn" type="button">
							<i class="glyphicon glyphicon-remove icon-white"></i>
						</button>
					</div>
					<div class="panel-body">
						<div class="input-group">
							<div class="input-group-addon">名称</div>
							<?php echo Form::input('post[0][name]', '', array('class' => 'form-control post_name', 'size' => 83));?>
						</div>
						<label id="form_post[0][name]-error" class="error" for="form_post[0][name]"></label>
						<p></p>

						<div class="input-group">
							<div class="input-group-addon">拠点数</div>
							<?php echo Form::input('post[0][count]', '', array('class' => 'form-control post_count', 'size' => 5));?>
							<div class="input-group-addon">点</div>
						</div>
						<label id="form_post[0][count]-error" class="error" for="form_post[0][count]"></label>
						<div class="input-group">
							<div class="input-group-addon">単価</div>
							<?php echo Form::input('post[0][price]', '', array('class' => 'form-control post_price', 'size' => 12));?>
							<div class="input-group-addon">円</div>
						</div>
						<label id="form_post[0][price]-error" class="error" for="form_post[0][price]"></label>
						<p></p>

						<div class="input-group">
							<div class="input-group-addon">備考</div>
							<?php echo Form::textarea('post[0][note]', '', array('class' => 'form-control post_note', 'cols' => 80, 'rows' => 3));?>
						</div>
						<label id="form_post[0][note]-error" class="error" for="form_post[0][note]"></label>
					</div>
				</div>
			<?php
				}
			?>
		</td>
	</tr>
	</tbody>
</table>

<div class="text-center">
	<button name="submit_btn" class="btn btn-primary btn-sm" type="submit">
		<i class="glyphicon glyphicon-pencil icon-white"></i>
		保存
	</button>
</div>
<?php
	echo Form::close();
?>

<script>
	$(function(){
		$('input[name=media_name]').autocomplete({
			minLength : 0,
			source : [
				<?php
					foreach($media_name_existed as $v)
					{
						echo "'".$v['media_name']."',";
					}
				?>
			]
		});

		$('input[name=media_version_name]').autocomplete({
			minLength : 0,
			source : [
				<?php
					foreach($media_version_name_existed as $v)
					{
						echo "'".$v['media_version_name']."',";
					}
				?>
			]
		});
	});
</script>

