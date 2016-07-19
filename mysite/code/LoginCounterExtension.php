<?php
class LoginCounterExtension extends DataExtension {
		
		private static $db = array (
			'LoginCount' => 'Int'
		);
		
		public function memberLoggedIn() {
			$this->owner->LoginCount++;
			$this->owner->write();
		}
	
}