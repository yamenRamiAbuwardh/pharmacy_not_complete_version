<!--  I want to do a table have a name Bay and i want it to take name of Buy and the problem its how to insert and update in same time  -->
<?php

use LDAP\Result;

require "conn.php";
session_start();
$id = $_SESSION['ID'];
if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $searc_trim = trim($search_key);
    $query = "SELECT * FROM buy WHERE name LIKE '%$searc_trim%' and users_id = '$id'";
} else {
    $date = date("Y-m-d");
    $query = "SELECT * FROM buy where date2 = '$date' and users_id = '$id'";
}

$result = mysqli_query($conn, $query);


// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "DELETE FROM buy WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("Location:allBuy.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include "sidebar.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div class="container">
            <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="البحث" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->


            </nav>
            <?php

            ?>
            <div><?php
                    if (isset($_SESSION['deleteBay'])) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['deleteBay']; ?>

                    </div>

                <?php
                        echo $_SESSION['deleteBay'];
                        unset($_SESSION['deleteBay']);
                    } else if (isset($_SESSION['upBuy'])) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['upBuy']; ?>

                    </div>
                <?php
                        unset($_SESSION['upBuy']);
                    }
                ?>
                <table class="table">
                    <tr>
                        <th scope="col">الاسم</th>
                        <th scope="col">تاريخ الانتهاء</th>
                        <th scope="col">الكمية</th>
                        <th scope="col">السعر</th>


                        <!-- <th scope="col">تحديت</th> -->
                        <th scope="col">حذف</th>

                        <th scope="col">تعديل</th>


                    </tr>
                    <?php
                    $total_price = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total_price += $row['price'];
                    ?>
                        <tr>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["date2"]; ?></td>
                            <td> <?php echo $row["quantity"]; ?></td>

                            <td><?php echo $row["price"]; ?></td>




                            </td>
                            <!-- <td>
                            <form action="up.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <button class="btn btn-primary" name="update">تحديت</button>
                            </form>
                        </td> -->
                            <td>
                                <form method="post" action="alldelete_bay.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button class="btn btn-danger" type="submit" name="delete">delete</button>
                                </form>
                            </td>
                            <td>
                                <form action="updateBuy.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button class="btn btn-primary" name="update">تعديل</button>
                                </form>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                    <?php echo "المجموع: " . $total_price; ?>

                </table>
                <!-- <?php
                        // $sql = "select * from medicines ";
                        // $result_sql = mysqli_query($conn, $sql);
                        // $total_record = mysqli_num_rows($result_sql);
                        //     // PHP code here, if needed

                        //     // Generating the HTML button element
                        // ;

                        // // ! echo $total_record;
                        // // ? this code to know how much pages 
                        // $total_pages = ceil($total_record / $num_per_page);
                        // for ($i = 1; $i <= $total_pages; $i++) {
                        //     echo '<button data-label="Register" class="rainbow-hover">';
                        //     echo "<a class='sp ' href='allmedicine.php?page=" . $i . "'>$i</a>";
                        //     echo '</button>';
                        // }
                        ?> -->
            </div>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>