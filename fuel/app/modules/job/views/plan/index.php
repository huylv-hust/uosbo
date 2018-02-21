<?php echo \Fuel\Core\Asset::js('validate/plan.js'); ?>
<div class="container">
	<?php echo \Fuel\Core\Form::open(array('id' => 'form-plan', 'class' => 'form-inline')); ?>
    <h3>
        予算
        <?php
				$filter_date = '';
				if(\Fuel\Core\Input::post('filter_date')) $filter_date = \Fuel\Core\Input::post('filter_date');
				echo \Fuel\Core\Form::select('filter_date',$filter_date,Utility::get_time_current(),array('class' => 'form-control'));
		?>
    </h3>
	<?php
		echo render('showinfo');
	?>
    <table class="table table-striped">
		<div clas="input_hidden">
			<?php
			//echo \Fuel\Core\Form::input('total_department',isset($total_department) ? $total_department : '',array('type' => 'hidden'));
			echo \Fuel\Core\Form::input('have_data','',array('type' => 'hidden'));
			?>
		</div>
        <?php
		foreach($department as $k => $v)
		{
		?>
            <tr>
                <th class="text-right"><?php echo $v; ?></th>
                <td>
					<div class="item-list">
						<div class="input-group">
							<div class="input-group-addon">求人費</div>
							<?php echo \Fuel\Core\Form::input('job_cost['.$k.']',isset($data_plan[$k - 1]) ? $data_plan[$k - 1]['job_cost'] : '',array('class' => 'form-control job_cost', 'size' => '20', 'id' => 'form_job_cost'.$k)); ?>
							<div class="input-group-addon">円</div>
						</div>
						<div>
							<label  class="error" for="form_job_cost<?php echo $k; ?>"></label>
						</div>
					</div>
					<div class="item-list">
						<div class="input-group">
							<div class="input-group-addon">販促費</div>
							<?php echo \Fuel\Core\Form::input('expenses['.$k.']',isset($data_plan[$k - 1]) ? $data_plan[$k - 1]['expenses'] : '',array('class' => 'form-control expenses', 'size' => '20', 'id' => 'form_expenses'.$k)); ?>
							<div class="input-group-addon">円</div>
						</div>
						<div>
							<label  class="error" for="form_expenses<?php echo $k; ?>"></label>
						</div>
					</div>

                    <div clas="input_hidden">
                        <?php
							echo \Fuel\Core\Form::input('area_id['.$k.']',$k,array('type' => 'hidden'));
						?>
                    </div>
                </td>
            </tr>
        <?php
		}
		?>
    </table>

    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="glyphicon glyphicon-pencil icon-white"></i>
            保存
        </button>
    </div>

    <?php echo \Fuel\Core\Form::close(); ?>

</div>