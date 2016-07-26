<?php

class ProjectmanagerController extends ContentController {

    private static $allowed_actions = array('getTasks','NewProjectMask','renderNewProjectForm','noRights');

    private static $url_handlers = array(
		'$ID!/tasks/$tID!' => 'getTasks',
		'newproject' => 'renderNewProjectForm',
		'keinZugriff' => 'noRights'//,
        //'$ID' => 'index'
    );

	/**
     * Handles following scenarios:
     *  - Show one task with all details
     *
     * @param SS_HTTPRequest $request
     *
     * @return HTMLText|void
     */
    public function getTasks(SS_HTTPRequest $request) {

        // Fetch project by ID from URL/Request
        $project = Project::get()->byID($request->param('ID'));

        // Check if there is a task ID
        if($request->param('tID')) {

            // Fetch task by ID from URL/request
            $task = $project->Tasks()->byID($request->param('tID'));

			if(!Member::currentUser())
				return $this->redirect('Security/login');
			else if(Member::currentUser()->inGroups(array('administrators','projectmanager'), true))
				return $this->customise(array('Task' => $task))->renderWith('projDetailedTaskInfo');   // Render task with template "projDetailedTaskInfo.ss"
			else if(Member::currentUser()->inGroup('developer', true))
				return $this->redirect('projectmanager/keinZugriff');
        } 
    }
	
	
	
    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		else if(Member::currentUser()->inGroups(array('administrators','projectmanager'), true))
			return $this->renderWith('Projectmanager');
		else if(Member::currentUser()->inGroup('developer', true))
			return $this->redirect('projectmanager/keinZugriff');
    }
	

	public function renderNewProjectForm(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
		else if(Member::currentUser()->inGroups(array('administrators','projectmanager'), true))
			return $this->renderWith('NewProjectForm');
		else if(Member::currentUser()->inGroup('developer', true))
			return $this->redirect('projectmanager/keinZugriff');
    }
	
	/**
     * Returns a list (DataList) of all stored projects.
     *
     * You can access this method in the template via $getProjects or just $Projects
     * (the word "get" is not mandatory in templates).
     *
     * @return DataList All stored projects.
     */
    public function getProjects() {
        return Project::get();
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

	public function myGroup(){
		if(Member::currentUser()->inGroup('projectmanager', true))
			return 'Projektmanager';
		else if(Member::currentUser()->inGroup('developer', true))
			return 'Developer';
	}

}