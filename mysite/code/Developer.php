<?php
	class Developer extends Member {
		
		private static $db = array(
			'EmployeeNr' => 'Int',
			'Phone' => 'Varchar(20)'
		);
		
		private static $belongs_many_many = array(
			'Projects' => 'Project'
		);
		
		private static $has_many = array(
			'Tasks' => 'Task'
		);
		
	}

