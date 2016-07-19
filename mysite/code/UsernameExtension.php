<?php
class UsernameExtension extends DataExtension {
		
		private static $db = array (
			'Username' => 'Varchar(30)'
		);
		
		// private static $many_many = array (
			// 'Projects' => 'Project'
		// );
		
		// public function getUserData() {
			// return $this->owner->Username . ' (' . $this->owner->Email . ')';
		// }
		
		public function validate(ValidationResult $ValidationResult) {
			if(!$this->owner->Username)
				$ValidationResult->error('"Username" ist ein Pflichtfeld.');
		}
	
}