<?php
echo "run \n";
passthru('/usr/bin/php output.php 23');

sleep(3);
echo "run2 \n";
exec('/usr/bin/php output.php 23');
sleep(3);
echo "run3 \n";
exec('/usr/bin/php output.php 23 2>&1');
sleep(1);
echo "run4 \n";
exec("/usr/bin/php output.php '0days' 2>&1");
//print_r($t);
sleep(3);

echo "run5 \n";
exec ("usr/bin/php output.php '-2days' 2>&1");

sleep(3);
echo "run6 \n";
passthru ("/usr/bin/php output.php '-2 days' &");

sleep(1);
sleep(sdfsdaf);
echo "run7 \n";
passthru ("/usr/bin/php output.php '-1 days' > /dev/null &");

echo "run8 \n";
passthru ("/usr/bin/php output.php '0 days' 2>&1");

sleep(3);