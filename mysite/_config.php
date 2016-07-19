<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'db_pmtool',
	'path' => ''
);

// Set the site locale
i18n::set_locale('de_DE');

Director::set_environment_type('dev');

//Security::set_default_login_dest('start');

Security::set_default_login_dest('home');


