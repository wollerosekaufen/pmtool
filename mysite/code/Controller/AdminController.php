<?php

class AdminController extends ContentController {

    private static $allowed_actions = array('noRights');

    private static $url_handlers = array(
        'keinZugriff' => 'noRights',
        '$ID' => 'index'
    );
	
    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
        else if(Member::currentUser()->inGroup('administrators', true))
            return $this->renderWith('Admin');
        else
            return $this->redirect('administrator/keinZugriff');
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

    public function getMembers(){
        return Member::get();
    }
}