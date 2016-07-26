<?php
class Task extends DataObject {
	
	private static $db = array(		
		'Title' => 'Varchar(255)',
		'Description' => 'HTMLText'
	);
	
	private static $has_one = array(
		'Project' => 'Project',
		'Developer' => 'Developer'
	);
		
	private static $has_many = array(
		'Timestamps' => 'Timestamp'
	);
}

