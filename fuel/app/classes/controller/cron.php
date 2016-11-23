<?php
class Controller_Cron extends Fuel\Core\Controller
{
	public function get_index()
	{
		Fuel\Core\Autoloader::add_class('Fuel\\Tasks\\Sendmailperson', APPPATH . 'tasks/sendmailperson.php');
		$obj = new Fuel\Tasks\Sendmailperson();
		$obj->run();
	}

}