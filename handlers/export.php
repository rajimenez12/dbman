<?php

if (! User::require_admin ()) {
	header ('Location: /admin');
	exit;
}

if (! isset ($_GET['table'])) {
	header ('Location: /dbman/index');
	exit;
}

$page->template = false;
header ('Cache-control: private');
header ('Content-Type: text/plain');
header ('Content-Disposition: attachment; filename=' . $_GET['table'] . '-' . gmdate ('Y-m-d') . '.csv');

$res = db_fetch_array ('select * from `' . $_GET['table'] . '`');
if (count ($res) > 0) {
	echo join (',', array_keys ((array) $res[0])) . "\n";
}

foreach ($res as $row) {
	$sep = '';
	foreach ((array) $row as $k => $v) {
		$v = str_replace ('"', '""', $v);
		if (strpos ($v, ',') !== false) {
			$v = '"' . $v . '"';
		}
		$v = str_replace (array ("\n", "\r"), array ('\\n', '\\r'), $v);
		echo $sep . $v;
		$sep = ',';
	}
	echo "\n";
}

?>