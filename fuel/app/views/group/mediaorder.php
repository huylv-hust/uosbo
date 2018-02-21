<?php
if(isset($data['no_data']) && $data['no_data'])
{
	 return;
}
?>
<div class="media">
	<input class="stt" type="hidden" value="0">
	<div class="input-group">
		<div class="input-group-addon">取引先グループ</div>
		<select class="form-control media-group" datastt="0">
			<option value="">取引先グループを選択して下さい</option>
			<?php foreach($data['listgroup2'] as $group){ ?>
				<option value="<?php echo $group['m_group_id']; ?>" <?php if($group['m_group_id'] == $data['group_id_selected']){ echo 'selected'; } ?>><?php echo $group['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="input-group">
		<div class="input-group-addon">取引先(発注先)</div>
		<select class="form-control media-partner media-partner0" datastt="0">
			<option value="">取引先を選択して下さい</option>
			<?php foreach($data['listpartner'] as $partner) { ?>
			<option value="<?php echo $partner['partner_code']; ?>" <?php if($partner['partner_code'] == $data['partner_code_selected']){ echo 'selected'; } ?>><?php echo $partner['branch_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<p></p>
	<div class="input-group">
		<div class="input-group-addon">媒体</div>
		<select name="media_list" class="form-control media-item media-item0" datastt="0">
			<option value="">媒体を選択して下さい</option>
			<?php foreach($data['listmedia'] as $media) { ?>
			<option value="<?php echo $media['m_media_id']; ?>" <?php if($media['m_media_id'] == $data['media_id_selected']){ echo 'selected'; } ?>><?php echo $media['media_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="input-group">
		<div class="input-group-addon">掲載枠</div>
		<select name="list_post" class="form-control post-item post-item0" datastt="0">
			<option value="">掲載枠を選択して下さい</option>
			<?php foreach($data['listpost'] as $post) { ?>
			<option data-price="<?php echo !$post['price'] ? 0 : $post['price'];?>" value="<?php echo $post['post_id']; ?>" <?php if($post['post_id'] == $data['post_id_selected']){ echo 'selected'; } ?>><?php echo $data['media_name'].$post['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<?php
	if($data['post_price'] !== 'hidden') {
		?>
	<div class="input-group">
		<div class="input-group-addon">掲載金額</div>
		<input value="<?php echo isset($data['post_price']) ? $data['post_price'] : 0?>" name="price" class="form-control post_price_item" size="10" type="text">
		<div class="input-group-addon">円</div>
	</div>
	<?php } ?>
	<label id="list_post-error" class="error" for="list_post"></label>
	<!--
	<button type="button" class="btn btn-danger btn-sm" name="remove-media-btn">
		<i class="glyphicon glyphicon-remove"></i>
	</button> -->
</div>
