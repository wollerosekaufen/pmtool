<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);

}
class Page_Controller extends ContentController {
		
	private static $allowed_actions = array ('NewProject');
	
	public function index() {
		if(Member::currentUserID() && Member::currentUser()->inGroup('developer', true))
			return $this->redirect('developer');
		else if(Member::currentUserID() && Member::currentUser()->inGroup('projectmanager', true))
			return $this->redirect('projectmanager');
		else if(Member::currentUserID() && Member::currentUser()->inGroup('administrators', true))
			return $this->redirect('administrator');
		else
			return $this->redirect('Security/login');
	}
	
	
	
	// public function MyForm() {
		
		// $fields = new FieldList(
			// TextField::create('Name', 'Dein Name'),
			// EmailField::create('Email', 'Deine Mailadresse'),
			// TextareaField::create('Message', 'Deine Nachricht')
		// );
		
		// $actions = new FieldList(
			// FormAction::create('doSubmit', 'Abschicken')
		// );
		
		// $requiredFields = new RequiredFields(array('Email', 'Message'));
		
		// return new Form($this, 'MyForm', $fields, $actions, $requiredFields);
	// }
	
	// public function NewProject() {
		
		// $fields = new FieldList(
			// TextField::create('Title', 'Projekttitel'),
			// TextareaField::create('Description', 'Projektbeschreibung'),
			// DateField::create('Start', 'Startdatum')
				// ->setAttribute('autocomplete', 'off')							// in Doku aufnehmen: field history löschen zwecks überlappung
				// ->setConfig('showcalendar', true),								// in Doku aufnehmen: kalender zwecks usability
			// DateField::create('End', 'Enddatum')
				// ->setAttribute('autocomplete', 'off')
				// ->setConfig('showcalendar', true)
		// );
		
		// $actions = new FieldList(
			// FormAction::create('doCreateP', 'Projekt anlegen')
		// );
		
		// $requiredFields = new RequiredFields(array('Title', 'Start', 'End'));
		
		// return new Form($this, 'NewProject', $fields, $actions, $requiredFields);
	// }
	
	public function doSubmit($data, $form) {
		
		// Creating a new user message record
		$uM = new UserMessage();
		
		// Check if a name was submitted
		if(isset($data['Name'])){
			$uM->Name = $data['Name'];
		}
		
		$uM->Email = $data['Email'];
		$uM->Message = $data['Message'];
		$uM->write();
		
		// Create a nice msg for our users
		$form->sessionMessage('Danke für deine Nachricht','good');
		
		// Redirect back to the form page
		return $this->redirectBack();
	}
	

}














