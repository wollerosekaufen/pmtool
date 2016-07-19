<?php
class UserMessage extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(255)',
		'Email' => 'Varchar(255)',
		'Message' => 'Text'
	);
}