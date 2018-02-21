<style>
<?php
$login_info = \Fuel\Core\Session::get('login_info');
if($login_info['division_type'] == 3){
   echo '.dropdown-menu a.delete_group,.dropdown-menu a.delete_partner,.dropdown-menu a.ss_btn_delete,.dropdown-menu a.delete_order{
        display: none;
    }';
    echo '.dropdown-menu a.media_delete_btn,.dropdown-menu a.users_btn_delete,.dropdown-menu a.delete_job,.dropdown-menu a.delete_person{
        display: none
    }';
}
?>
</style>
<div id="uosmodal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">

			</div>
		</div>
	</div>
</div>
<footer>
	<p>Copyright(C) U.O.S CORP. All right reserved.</p>
</footer>
