<?php
session_start();
echo  $_SESSION['ROLE'];
if($name == 'super_admin'){
    header('location:dashboardAdmin.php');
}else{
    header('location:dashboard.php');
}
?>