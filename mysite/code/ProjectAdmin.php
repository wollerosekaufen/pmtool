<?php
class ProjectAdmin extends ModelAdmin {
	private static $managed_models = array(
		'Project', 'Task');
	
	private static $menu_title = 'My Projects';
	private static $url_segment = 'projects';
	
}