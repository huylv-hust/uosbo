<?php
if(isset($data['no_data']) && $data['no_data'])
{
	 return;
}
?>
<div class="media">
	<input class="stt" type="hidden" value="<?php echo $data['media_id_selected']?>">
	<div class="input-group">
		<div class="input-group-addon">取引先グループ</div>
		<select class="form-control media-group" datastt="<?php echo $data['media_id_selected']?>">
			<option value="">取引先グループを選択して下さい</option>
			<?php foreach($data['listgroup2'] as $group){ ?>
				<option value="<?php echo $group['m_group_id']; ?>" <?php if($group['m_group_id'] == $data['group_id_selected']){ echo 'selected'; } ?>><?php echo $group['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="input-group">
		<div class="input-group-addon">取引先(発注先)</div>
		<select class="form-control media-partner media-partner<?php echo $data['media_id_selected']?>" datastt="<?php echo $data['media_id_selected']?>">
			<option value="">取引先を選択して下さい</option>
			<?php foreach($data['listpartner'] as $partner) { ?>
			<option value="<?php echo $partner['partner_code']; ?>" <?php if($partner['partner_code'] == $data['partner_code_selected']){ echo 'selected'; } ?>><?php echo $partner['branch_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="input-group">
		<div class="input-group-addon">媒体</div>
		<select name="media_list[]" class="form-control media-item media-item<?php echo $data['media_id_selected']?>" datastt="<?php echo $data['media_id_selected']?>">
			<option value="">媒体を選択して下さい</option>
			<?php foreach($data['listmedia'] as $media) { ?>
			<option value="<?php echo $media['m_media_id']; ?>" <?php if($media['m_media_id'] == $data['media_id_selected']){ echo 'selected'; } ?>><?php echo $media['media_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<button type="button" class="btn btn-danger btn-sm" name="remove-media-btn">
		<i class="glyphicon glyphicon-remove"></i>
	</button>
</div>
