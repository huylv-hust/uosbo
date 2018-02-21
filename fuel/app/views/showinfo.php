<!--Show success-->
<?php
	if(Session::get_flash('success'))
	{
		echo '<div class="alert alert-success" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo '<ul><li>';
		echo implode('</li><li>', (array) Session::get_flash('success'));
		echo '</li></ul>';
		echo '</div>';
	}
?>
<!--Show error-->
<?php
	if(Session::get_flash('error'))
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo '<ul><li>';
		echo implode('</li><li>', (array) Session::get_flash('error'));
		echo '</li></ul>';
		echo '</div>';
	}
?>