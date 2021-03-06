<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class MyAuth
 */
class MyAuth
{
	static $roles = array(
		'1' => array(
			'Master\Controller_Groups'      => '*',
			'Master\Controller_Media'       => '*',
			'Master\Controller_Medias'      => '*',
			'Master\Controller_Partner'     => '*',
			'Master\Controller_Partners'    => '*',
			'Master\Controller_Ss'          => '*',
			'Master\Controller_Sslist'      => '*',
			'Master\Controller_Sssale'      => '*',
			'Master\Controller_User'        => '*',
			'Master\Controller_Users'       => '*',
			'Job\Controller_Jobs'           => '*',
			'Job\Controller_Job'            => '*',
			'Job\Controller_Persons'        => '*',
			'Job\Controller_Person'         => '*',
			'Job\Controller_Orders'         => '*',
			'Job\Controller_Order'          => '*',
			'Job\Controller_Plan'           => '*',
			'Job\Controller_Employment'     => '*',
			'Job\Controller_Personfile'     => '*',
			'Job\Controller_Jobup'          => '*',
			'Job\Controller_Interview'      => '*',
			'Job\Controller_Interviewusami' => '*',
			'Job\Controller_Result'         => '*',
			'Job\Controller_Emcall'         => '*',
			'Ajax\Controller_Common'        => '*',
			'Ajax\Controller_Orders'        => '*',
			'Ajax\Controller_Job'           => '*',
			'Support\Controller_Contact'    => '*',
			'Support\Controller_Contacts'   => '*',
			'Support\Controller_Concierges' => '*',
			'Support\Controller_Concierge'  => '*',
			'Obic7\Controller_Office'       => '*',
			'Obic7\Controller_Person'       => '*',
			'Obic7\Controller_Persons'      => '*',
			'Obic7\Controller_Workplace'    => '*',
		),
		'2' => array(
			'Master\Controller_Groups'      => '*',
			'Master\Controller_Partner'     => '*',
			'Master\Controller_Partners'    => '*',
			'Master\Controller_Ss'          => '*',
			'Master\Controller_Sslist'      => '*',
			'Master\Controller_Sssale'      => '*',
			'Job\Controller_Jobs'           => '*',
			'Job\Controller_Job'            => '*',
			'Job\Controller_Persons'        => '*',
			'Job\Controller_Person'         => '*',
			'Job\Controller_Orders'         => '*',
			'Job\Controller_Order'          => '*',
			'Job\Controller_Employment'     => '*',
			'Job\Controller_Personfile'     => '*',
			'Job\Controller_Interview'      => '*',
			'Job\Controller_Interviewusami' => '*',
			'Job\Controller_Result'         => '*',
			'Ajax\Controller_Common'        => '*',
			'Ajax\Controller_Orders'        => '*',
			'Ajax\Controller_Job'           => '*',
			'Job\Controller_Emcall'         => '*',
		),
		'3' => array(
			'Master\Controller_Groups'      => '*',
			'Master\Controller_Partner'     => '*',
			'Master\Controller_Partners'    => '*',
			'Master\Controller_Ss'          => 'index,accept,reject,delete',
			'Master\Controller_Sslist'      => '*',
			'Master\Controller_Sssale'      => '*',
			'Job\Controller_Jobs'           => '*',
			'Job\Controller_Job'            => '*',
			'Job\Controller_Persons'        => '*',
			'Job\Controller_Person'         => '*',
			'Job\Controller_Orders'         => '*',
			'Job\Controller_Order'          => '*',
			'Job\Controller_Employment'     => '*',
			'Job\Controller_Personfile'     => '*',
			'Job\Controller_Interview'      => '*',
			'Job\Controller_Interviewusami' => '*',
			'Job\Controller_Result'         => '*',
			'Ajax\Controller_Common'        => 'approved,available,get_partners,get_ss',
			'Ajax\Controller_Orders'        => '*',
			'Ajax\Controller_Job'           => '*',
			'Job\Controller_Emcall'         => '*',
		),
		'4' => array(
			'Obic7\Controller_Office'    => '*',
			'Obic7\Controller_Person'    => '*',
			'Obic7\Controller_Persons'   => '*',
			'Obic7\Controller_Workplace' => '*',
		),
	);
	static $role_edit = 'edit';
	static $role_approval = 'approval';
	static $role_unapproval = 'unapproval';
	static $role_public = 'public';
	static $role_unpublic = 'unpublic';
	static $roles_edit = array(
		'1' => 'edit,approval,unapproval,public,unpublic',
		'2' => 'edit,approval,unapproval,public,unpublic',
		'3' => 'edit,public,unpublic',
	);
}