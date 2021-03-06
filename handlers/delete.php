<?php

if (! User::require_admin ()) {
	header ('Location: /admin');
	exit;
}

if (! isset ($_GET['table'])) {
	header ('Location: /dbman/index');
	exit;
}

$page->layout = 'admin';

$sql = sprintf (
	'delete from `%s` where %s = ?',
	$_GET['table'],
	DBMan::primary_key ($_GET['table'])
);

if (db_execute ($sql, $_GET['key'])) {
	$this->add_notification (i18n_get ('Item deleted.'));
	$this->redirect ('/dbman/browse?table=' . $_GET['table']);
}

$page->title = i18n_get ('An Error Occurred');
printf ("<p>%s</p>\n<p><a href='/dbman/browse?table=%s'>&laquo; %s</a></p>\n", db_error (), $_GET['table'], i18n_get ('Back'));

?>