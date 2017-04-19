<?php
// Update 1/16 users 60 days robot

$time_gb_start = time();
if (isset($argv['1'])) {
    $page = $argv['1'];
} else {
    $page = 1;
}

set_time_limit(0);
ini_set("memory_limit", -1);

require_once 'functions.php';

writeLogRobot('log_60_days/','robot_60_days_page', 'Page: '. $page .'/16 START', 'start');

include 'db.php';

$usersResult = $db->query('SELECT count(*) as totalUser FROM `mws` WHERE `code` IS NOT NULL');
$users = $usersResult->fetch(PDO::FETCH_ASSOC);
$totalUsers = $users['totalUser'];

$maxPage = 16;
$amount = floor( $totalUsers/($maxPage-1) );
$index = ($page-1)*$amount;

$listUserDb = $db->query('SELECT user FROM `mws` WHERE `code` IS NOT NULL LIMIT '. $index .', '. $amount);

$listUser = [];
while ($user = $listUserDb->fetch(PDO::FETCH_ASSOC)) {
	$listUser[] = $user['user'];
}

//test
if (isset($argv['2'])) {
	$listUser = [$argv['2']];
}

if (isset($listUser[0])) {
	$user_start = $listUser[0];
} else {
	$user_start = 0;
}

if (isset($listUser[count($listUser)-1])) {
	$user_end = $listUser[count($listUser)-1];
} else {
	$user_start = 0;
}

foreach ($listUser as $userId) {
	$time_user_start = time();

	writeLogRobot('log_60_days/','robot_60_days_user', 'User: '.$userId.' START', 'start');

	$cmd1 = '/usr/bin/php /srv/robots/syncdat.php ' . $userId;
	passthru($cmd1);
	sleep(5);

	$cmd2 = '/usr/bin/php /srv/robots/lookup.php ' . $userId;
	passthru($cmd2);
	sleep(5);

	writeLogRobot('log_60_days/','robot_60_days_user', 'User: '.$userId.' END, TOTAL TIME: '.(time()-$time_user_start).' s', 'end');
}

writeLogRobot('log_60_days/','robot_60_days_page', 'Page: '.$page.'/16 END, TOTAL TIME: '.(time()-$time_gb_start).' s', 'end');

