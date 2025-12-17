<?php
session_start();
if(isset($_SESSION['username']))
{
unset($_SESSION['username']);
// session_destroy('username');
header('Location:index.php');
}else{
unset($_SESSION['username']);
// session_destroy('username');
header('Location:index.php');
}
?>
