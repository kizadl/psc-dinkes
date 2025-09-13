<?php
	exec('ssh -f 127.0.0.1:3306 root@127.0.0.1 sleep 10 > /dev/null');
	$dbhost = 'localhost';
	$dbuser = 'admpscjbr';
	$dbpass = 'Publ1c5@fety!';
	$dbname = 'db_pscjbr';

$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);
?>


