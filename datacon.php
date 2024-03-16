<?php
$server_name = 'mysql';
$user_name = 'student';
$password = 'student';
$database_name = 'ijdb';

$connection = new PDO('mysql:dbname='.$database_name.';host='.$server_name, $user_name, $password);
?>

