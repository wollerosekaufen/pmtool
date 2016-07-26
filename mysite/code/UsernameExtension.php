<?php
class UsernameExtension extends DataExtension {
		
		private static $db = array (
			'Username' => 'Varchar(30)'
		);

		public function validate(ValidationResult $ValidationResult) {
			if(!$this->owner->Username)
				$ValidationResult->error('"Username" ist ein Pflichtfeld.');
		}
	
}