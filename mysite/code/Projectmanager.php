<?php
	class Projectmanager extends Member {
		
		private static $db = array(
			'EmployeeNr' => 'Int',
			'Phone' => 'Varchar(20)'
		);
		
		private static $has_many = array(
			'Projects' => 'Project'
		);


	}

