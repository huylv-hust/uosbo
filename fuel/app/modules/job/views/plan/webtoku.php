<?php
use Fuel\Core\Input;
?>
<div class="container">
	<?php echo \Fuel\Core\Form::open(array('action' => \Fuel\Core\Uri::current() . '?' . Input::server('QUERY_STRING'), 'method' => 'post', 'class' => 'form-inline')); ?>
    <h3>
        WEB得予算
        <?php
			echo \Fuel\Core\Form::select('start_date', $start_date, Utility::get_time_current(), array('class' => 'form-control'));
		?>

		<div class="input-group">
			<div class="input-group-addon">対象部門</div>
			<select class="form-control" name="department_id">
				<option value="">選択してください</option>
				<?php foreach ($departments as $department_id => $department_name) { ?>
				<option value="<?php echo $department_id ?>"<?php echo Input::get('department_id') == $department_id ? ' selected' : '' ?>><?php echo htmlspecialchars($department_name) ?></option>
				<?php } ?>
			</select>
		</div>

    </h3>
	<?php
		echo render('showinfo');
	?>

	<?php if ($plans != null) { ?>
	<div id="plans">
		<table class="table table-striped">
			<?php for ($i=1;$i<=12;$i++) { ?>
			<tr>
				<th class="text-right"><?php echo htmlspecialchars($i) ?>月</th>
				<td>
					<div class="input-group">
						<input type="text" class="form-control" size="20" name="plans[]" value="<?php echo $plans[$i] ? $plans[$i] : '' ?>">
						<div class="input-group-addon">円</div>
					</div>
				</td>
			</tr>
			<?php } ?>
		</table>

		<div class="text-center">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="glyphicon glyphicon-pencil icon-white"></i>
				保存
			</button>
		</div>
	</div>
	<?php } ?>

    <?php echo \Fuel\Core\Form::close(); ?>

	<script>
		$(function() {
			$('select').on('change', function() {
				$('form').attr('method', 'get').submit();
			});
		});
	</script>
</div>