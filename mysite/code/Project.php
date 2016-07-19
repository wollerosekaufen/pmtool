<?php
class Project extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Description' => 'HTMLText',
		'Start' => 'SS_Datetime',    	
		'End' => 'SS_Datetime'			
	);
	
	private static $has_one = array(
		'Projectmanager' => 'Projectmanager'
	);
		
	private static $many_many = array(
		'Developers' => 'Developer'
	);
		
	private static $has_many = array(
		'Tasks' => 'Task'
	);

}

