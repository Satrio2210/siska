<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{//1

include "conf/config.php";
if (isset($_POST['txtuseriden']))
    {
        $useriden = $_POST['txtuseriden'];

        $delete = "DELETE FROM passiden WHERE PASS_USER_IDEN = '$useriden'";

                // Prepare Request  
                $query_delete = $db->prepare($delete);

                // Mulai Input
                $db->beginTransaction();
                $query_delete->execute();
                $db->commit();
                header("location: PASSIDEN03.php");
    }//2
    }//1

else
{
  header("Location: "."index.php");
}
?>