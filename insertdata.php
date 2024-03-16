<?php
require 'datacon.php';
?>
<?php
if(isset($_POST['submit'])){
$insertvalue= $connection->prepare('insert into Register(username, email, password) values(:user,:email,:password)');

$criteria=[
    'user'=>$_POST['username'],
    'email'=>$_POST['email'],
    'password'=>$_POST['password']
];
$insertvalue->execute($criteria);
// header('Location: https://v.je');
  exit;
}
?>