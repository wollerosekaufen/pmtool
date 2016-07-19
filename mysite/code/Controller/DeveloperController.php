<?php

class DeveloperController extends ContentController {

    private static $allowed_actions = array('');

    private static $url_handlers = array(
        '$ID' => 'index'
    );
	
    public function index(SS_HTTPRequest $request) {
		if(!Member::currentUser())
			return $this->redirect('Security/login');
        return $this->renderWith('Developer');
    }

	
}