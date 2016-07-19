<?php
class Timestamp extends DataObject {
	
	private static $db = array(		
		'Title' => 'Varchar(255)',
		'Description' => 'HTMLText',
		'Duration' => 'Int'  	// Dauer
	);
	
	private static $has_one = array(
		'Task' => 'Task',
		'Developer' => 'Developer'
	);
}

