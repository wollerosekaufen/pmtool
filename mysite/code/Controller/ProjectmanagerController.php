<?php

class ProjectmanagerController extends ContentController {

    private static $allowed_actions = array('NewProjectMask','renderNewProjectForm','NewTaskMask','renderNewTaskForm','noRights');

    private static $url_handlers = array(
		'newtask' => 'renderNewTaskForm',
		'newproject' => 'renderNewProjectForm',
		'keinZugriff' => 'noRights'
    );

    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		else if(Member::currentUser()->inGroup('projectmanager', true))
			return $this->renderWith('Projectmanager');
		else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
			return $this->redirect('projectmanager/keinZugriff');
    }

	public function renderNewProjectForm(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		else if(Member::currentUser()->inGroup('projectmanager', true))
			return $this->renderWith('NewProjectForm');
		else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
			return $this->redirect('projectmanager/keinZugriff');
    }

	public function renderNewTaskForm(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		else if(Member::currentUser()->inGroup('projectmanager', true))
			return $this->renderWith('NewTaskForm');
		else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
			return $this->redirect('projectmanager/keinZugriff');
	}

    /**
     * Try to fetch a project record by the ID from the URL.
     *
     * @return Project|null
     */
    public function getActiveProject() {

        // Try to fetch ID from the URL
        $id = $this->getRequest()->param('ID');

        // Return null if there is no ID
        if(!$id)
            return null;

        // Try to fetch a project with the ID from the URL
        $project = Project::get()->byID($id);

        // Return null if there is no project and return the project record otherwise
        return $project ? $project : null;
    }
	
	public function getActiveProjects(){
		return Project::get()->filter('End:GreaterThan',date('Y-m-d'));
	}
	
	public function getArchivedProjects(){
		return Project::get()->filter('End:LessThan',date('Y-m-d'));
	}

	public function NewProjectMask() {
        $fields = new FieldList(
                TextField::create('Title','Title')
					->setAttribute('autocomplete', 'off')
					->setAttribute('placeholder', 'Enter a project title ...'), // (key,name)
                TextareaField::create('Description','Description')
					->setAttribute('autocomplete', 'off'),
                DateField::create('Start','Start')
					->setAttribute('autocomplete', 'off')		// in Doku aufnehmen: field history löschen zwecks überlappung
					->setConfig('showcalendar', true)			// in Doku aufnehmen: kalender zwecks usability
					->setAttribute('placeholder', 'Click me ...'),
				DateField::create('End','End')
					->setAttribute('autocomplete', 'off')		// in Doku aufnehmen: field history löschen zwecks überlappung
					->setConfig('showcalendar', true)			// in Doku aufnehmen: kalender zwecks usability
					->setAttribute('placeholder', 'Click me ...'),
				DropdownField::create('Projectmanager','Projectmanager', Projectmanager::get()->map('ID','Title'))
					->setEmptyString('Select a Projectmanager ...')

		);

        $actions = new FieldList(FormAction::create('doCreateP','Projekt anlegen'));

        $requiredFields = new RequiredFields(array('Title','Start','End','Projectmanager'));

        return new Form($this, 'NewProjectMask', $fields, $actions, $requiredFields);
    }

	public function doCreateP($data, $form) {

		// Creating a new project record
		$nP = new Project();

		// Check if a description was submitted
		if(isset($data['Description'])){
			$nP->Description = $data['Description'];
		}

		$nP->Title = $data['Title'];
		$nP->Start = $data['Start'];
		$nP->End = $data['End'];
		$nP->ProjectmanagerID = $data['Projectmanager'];
		$nP->write();

		// Create a nice msg for our users
		$form->sessionMessage('Projekt angelegt!','good');

		// Redirect back to the form page
		return $this->redirectBack();
	}

	public function NewTaskMask() {
		$fields = new FieldList(
			TextField::create('Title','Title')
				->setAttribute('autocomplete', 'off')
				->setAttribute('placeholder', 'Enter a task title ...'), // (key,name)
			TextareaField::create('Description','Description')
				->setAttribute('autocomplete', 'off'),
			DropdownField::create('Project','Project', Project::get()->filter('End:GreaterThan',date('Y-m-d'))->map('ID','Title'))
				->setEmptyString('Select a Project ...'),
			DropdownField::create('Developer','Developer', Developer::get()->map('ID','Title'))
				->setEmptyString('Select a Developer ...')
		);

		$actions = new FieldList(FormAction::create('doCreateT','Task anlegen'));

		$requiredFields = new RequiredFields(array('Title','Project'));

		return new Form($this, 'NewTaskMask', $fields, $actions, $requiredFields);
	}

	public function doCreateT($data, $form) {

		// Creating a new task record
		$nT = new Task();

		$nT->Title = $data['Title'];
		$nT->Description = $data['Description'];
		$nT->ProjectID = $data['Project'];
		$nT->DeveloperID = $data['Developer'];
		$nT->write();

		// Create a nice msg for our users
		$form->sessionMessage('Task angelegt!','good');

		// Redirect back to the form page
		return $this->redirectBack();
	}

	public function noRights(){
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		return $this->renderWith('keinZugriff');
	}

	public function myUrl() {
		$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
		$numSegments = count($segments);
		$currentSegment = $segments[$numSegments - 2];

		if($currentSegment == 'developer')
			return 'Developer-Seiten';
		else if($currentSegment == 'projectmanager')
			return 'Projektmanager-Seiten';
		else
			return 'Administrator-Seiten';
	}

	public function myUrl2() {
		$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
		$numSegments = count($segments);
		$currentSegment = $segments[$numSegments - 2];

		if($currentSegment == 'developer')
			return 'developer';
		else
			return 'projectmanager';
	}

	public function myGroup(){
		if(Member::currentUser()->inGroup('projectmanager', true))
			return 'Projektmanager';
		else if(Member::currentUser()->inGroup('developer', true))
			return 'Developer';
		else if(Member::currentUser()->inGroup('administrators',true))
			return 'Administrator';
	}

}