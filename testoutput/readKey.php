<?php
function waitToRead() {
	if (PHP_OS == 'WINNT') {
	  echo 'Press key to continue...';
	  $line = stream_get_line(STDIN, 1024, PHP_EOL);
	} else {
	  $line = readline('Press key to continue... ');
	}
}
	waitToRead();
	echo "hello";

 ?>