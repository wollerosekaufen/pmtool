<?php

class DeveloperController extends ContentController {

    private static $allowed_actions = array('getTasks','NewTaskMask','renderNewTaskForm','noRights');

    private static $url_handlers = array(
        'newtask' => 'renderNewTaskForm',
        'keinZugriff' => 'noRights',
        '$ID!/tasks/$tID!' => 'getTasks',
        '$ID' => 'index'
    );

    public function getTasks(SS_HTTPRequest $request) {

        // Fetch project by ID from URL/Request
        $project = Project::get()->byID($request->param('ID'));

        // Check if there is a task ID
        if($request->param('tID')) {

            // Fetch task by ID from URL/request
            $task = $project->Tasks()->byID($request->param('tID'));

            if(!Member::currentUser())
                return $this->redirect('Security/login');
            else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
                return $this->customise(array('Task' => $task))->renderWith('devDetailedTaskInfo');   // Render task with template "devDetailedTaskInfo.ss"
            else if(Member::currentUser()->inGroup('projectmanager', true))
                return $this->redirect('developer/keinZugriff');
        }
    }

    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
        else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
            return $this->renderWith('Developer');
        else if(Member::currentUser()->inGroup('projectmanager', true))
            return $this->redirect('developer/keinZugriff');
    }

    public function renderNewTaskForm(SS_HTTPRequest $request) {
        if(!Member::currentUser())
            return $this->redirect('Security/login');
        else if(Member::currentUser()->inGroups(array('administrators','developer'), true))
            return $this->renderWith('NewTaskForm');
        else if(Member::currentUser()->inGroup('projectmanager', true))
            return $this->redirect('developer/keinZugriff');
    }

    public function getProjects() {
        return Project::get();
    }

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
        $developer = Developer::get()->byID(Member::currentUserID());
        $MyOwnProjects = $developer->Projects()->filter('End:GreaterThan',date('Y-m-d'));
        return $MyOwnProjects;
    }

    public function getArchivedProjects(){
        $developer = Developer::get()->byID(Member::currentUserID());
        $MyOwnProjects = $developer->Projects()->filter('End:LessThan',date('Y-m-d'));
        return $MyOwnProjects;
    }


    public function NewTaskMask() {
        $fields = new FieldList(
            TextField::create('Title','Title')
                ->setAttribute('autocomplete', 'off')
                ->setAttribute('placeholder', 'Enter a task title ...'), // (key,name)
            TextareaField::create('Description','Description')
                ->setAttribute('autocomplete', 'off'),
            DropdownField::create('Project','Project', Project::get()->map('ID','Title'))
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
    }
}