<?php
// Update 1/16 users one day robot

$time_gb_start = time();

set_time_limit(0);
ini_set("memory_limit", -1);

require_once 'functions.php';

include 'db.php';

$usersResult = $db->query('SELECT count(*) as totalUser FROM `mws` WHERE `code` IS NOT NULL');
$users = $usersResult->fetch(PDO::FETCH_ASSOC);
$totalUsers = $users['totalUser'];

if (isset($argv['1'])) {
    $page = $argv['1'];
} else {
    $page = 1;
}
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

foreach ($listUser as $userId) {

	// pa
	writeLogRobot('Robot_one_day', 'Start---------------------------', $userId);
	// end pa

	// update image produc-name
	// $cmd_60_days = '/usr/bin/php /srv/robots/updateProduct.php '. $userId;

	// exec($cmd_60_days);
	// sleep(5);

	// update 3 table ad, keyword, searchterm -1 days
	$cmd1 = '/usr/bin/php /var/www/html/genReportsToProcessList.php "-60 days" ' . $userId;
	exec($cmd1);
	sleep(5);

	$cmd2 = '/usr/bin/php /var/www/html/genReportsPart.php ' . $userId;
	exec($cmd2);
	sleep(5);

	$cmd3 = '/usr/bin/php /var/www/html/getReportsPreparedInfile.php ' . $userId;
	exec($cmd3);
	sleep(5);

	// pa
	writeLogRobot('Robot_one_day', 'END, TOTAL TIME '.(time()-$time_gb_start).' ---------------------------', $userId);
	//end pa
}

