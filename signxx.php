<?php
//memulai session
session_start();
//koneksi ke database
include "conf/config.php";

//mengambil data dari form
$username    = $_POST['userid'];
$password    = md5($_POST['pass']);

//Cek username dan password dari Tabel Users
$periksa   = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN='$username' AND PASS_USER_PSWD='$password'";
$periksa_di_query = $db->query($periksa) or die("Login Fail");

$ketersediaan  = $periksa_di_query->fetchColumn();

//Cek adanya username dan password di database dilanjutkan dengan membuat session
if ($ketersediaan >= 1 )
	{ 
	$sql = "SELECT * FROM passiden WHERE PASS_USER_IDEN = '$username' AND PASS_USER_PSWD='$password'";
	$q = $db->query($sql) or die("Gagal Maning!!");
	$r = $q->fetch(PDO::FETCH_ASSOC); 
	
	$_SESSION['username'] = $username;
	header("location: index.php"); 
	}
elseif (($username=="$idadmin") and ($password=="$passadmin"))
	{
	$_SESSION['username'] = $username;
	header("Location: index.php");
	}
else 
	{ 
		header("location: signin.php"); 
	}
?>

