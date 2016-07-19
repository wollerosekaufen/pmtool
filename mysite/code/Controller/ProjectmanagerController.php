<?php

class ProjectmanagerController extends ContentController {

    private static $allowed_actions = array('getTasks','rtNewProjectForm','renderNewProjectForm');

    private static $url_handlers = array(
		'$ID!/tasks/$tID!' => 'getTasks',
		'newproject' => 'renderNewProjectForm',
        '$ID' => 'index'
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
			
            // Render task with template "DetailedTaskInfo.ss"
            return $this->customise(array('Task' => $task))->renderWith('DetailedTaskInfo');
        } 
    }
	
	
	
    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
        return $this->renderWith('Projectmanager');
    }
	

	public function renderNewProjectForm(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
        return $this->renderWith('NewProjectForm');
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
	
	public function rtNewProjectForm() {
        $fields = new FieldList(array(
                TextField::create('Title','Title')
					->setAttribute('autocomplete', 'off')
					->setAttribute('placeholder', 'Enter a project title ...'), // (key,name)
                TextareaField::create('Description','Description')
					->setAttribute('autocomplete', 'off'),
                DateField::create('Start','Start')
					->setAttribute('autocomplete', 'off')		// in Doku aufnehmen: field history löschen zwecks überlappung
					->setConfig('showcalendar', true),			// in Doku aufnehmen: kalender zwecks usability
				DateField::create('End','End')
					->setAttribute('autocomplete', 'off')		// in Doku aufnehmen: field history löschen zwecks überlappung
					->setConfig('showcalendar', true),			// in Doku aufnehmen: kalender zwecks usability
				DropdownField::create('Projectmanager','Projectmanager', Projectmanager::get()->map('ID','Title'))
		));

        $actions = new FieldList(FormAction::create('doCreateP','Projekt anlegen'));

        $requiredFields = new RequiredFields(array('Title'));

        return new Form($this, 'rtNewProjectForm', $fields, $actions, $requiredFields);
    }
	
	// public function doSubmit($data, $form) {
        // // New empty instance of model "Project"
        // $project = new Project();

        // // Save values from form fields to Project instance
        // $form->saveInto($project);

        // // Save Project instance to database
        // $project->write();

        // // Redirect back to list
        // $this->redirect(projectmanager);
    // }
	
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
		$nP->write();
		
		// Create a nice msg for our users
		$form->sessionMessage('Projekt angelegt!','good');
		
		// Redirect back to the form page
		return $this->redirect('admin');

	}
	
}