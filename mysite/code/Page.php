<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);
}

class Page_Controller extends ContentController {

	private static $allowed_actions = array ('');

	// group chooser

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

}














