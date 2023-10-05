<?php

use LDAP\Result;

require "conn.php";
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;




// ... (Previous code)
session_start();
$id = $_SESSION['ID'];

// ... (Previous code)



// ... (Rest of your code)





$id = $_SESSION['ID'];
$num_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number from the URL or default to page 1
$start_from = ($page - 1) * $num_per_page; // Calculate the starting record for the current page

if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $searc_trim = trim($search_key);
    $query = "SELECT * FROM medicines WHERE users_id = '$id' AND name LIKE '%$searc_trim%' LIMIT $start_from, $num_per_page";
} else {
    $query = "SELECT * FROM medicines WHERE users_id = '$id' LIMIT $start_from, $num_per_page";
}


$result = mysqli_query($conn, $query);




// ... (Rest of your code)







// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "delete from  medicines WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("Location: allmedicine.php");
// }

?>

<?php 
header('Content-Type: application/vmd.ms-excel');
header('Content-Disposition: attachment; Filename = Mydata.xls');

require 'requier_den_all.php'
?>
