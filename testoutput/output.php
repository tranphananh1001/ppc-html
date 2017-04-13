<?php
date_default_timezone_set("America/Los_Angeles");

echo $argv[1] . '\n';
echo strtotime($argv[1]) . '\n';
echo date('Y-m-d H:i:s') . '\n';
echo "\n";
sleep(2);