<?php
session_start();
require "conn.php";
$id = $_SESSION['ID'];

$num_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number from the URL or default to page 1
$start_from = ($page - 1) * $num_per_page; // Calculate the starting record for the current page

if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $query = "SELECT * FROM den WHERE users_id = (SELECT id FROM admins WHERE id = '$id')";
} else {
    $query = "SELECT * FROM den WHERE users_id = '$id' LIMIT $start_from, $num_per_page";
}


$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "DELETE FROM den WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("location:den.php");
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
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." name="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->


            </nav>
            <h1>الدين</h1>
            <div><?php
                    if (isset($_SESSION['addDen'])) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['addDen']; ?>
                    </div>

                <?php
                        unset($_SESSION['addDen']);
                    } else if (isset($_SESSION['deleteDen'])) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['deleteDen']; ?>

                    </div>
                <?php
                        unset($_SESSION['deleteDen']);
                    } else if (isset($_SESSION['upDen'])) {
                ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $_SESSION['upDen']; ?>

                    </div>
                <?php
                        unset($_SESSION['upDen']);
                    } else if (isset($_SESSION['payDen'])) {
                ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $_SESSION['payDen']; ?>

                    </div>
                <?php
                        unset($_SESSION['payDen']);
                    } else if (isset($_SESSION['deletePay'])) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['deletePay']; ?>

                    </div>
                <?php
                        unset($_SESSION['deletePay']);
                    }
                ?>


            </div>
            <a href="export_den.php"> <button type='button' class="btn btn-success" '>export</button></a>
            <table class="table">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>التاريخ</th>
                        <th>الشريط</th>

                        <th>اسم الدواء</th>

                        <th>تعديل</th>
                        <th>الحذف</th>
                        <th>كل دين الشخص</th>
                        <th>الذهاب الى دفعات الشخص </th>

                    </tr>
                </thead>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];

?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["name"]; ?></td>
                            <td> <?php echo $row["price"]; ?></td>
                            <td><?php echo $row["date2"]; ?> </td>

                            <td><?php echo $row["id_stock"]; ?></td>
                            <td><?php echo $row["medicine_name"]; ?></td>



                            <td>
                                <form action="up_den.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                    <button class="btn btn-primary" name="update">تعديل</button>
                                </form>
                            </td>
                            <td>
                                <form method="post" action="alldeleteden.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button class="btn btn-danger" type="submit" name="delete">delete</button>
                                </form>
                            </td>
                            <?php
                            
                            $id = $row['id'];
                            ?>
                            <td>
                                <form action="all_den_for.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                    <button class="btn btn-primary" name="all">كل دين الشخص
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="allPay.php?id=<?= $row["id"] ?>" class="btn btn-danger">الذهاب الى صفحة الشخص </a>
                            </td>
                                
                        </tr>
                    </tbody>
                <?php
                }
                ?>
                
            </table>
            <?php
            $sql = "select * from den";
            $result_sql = mysqli_query($conn, $sql);
            $total_record = mysqli_num_rows($result_sql);
            //     // PHP code here, if needed

            //     // Generating the HTML button element
            // ;

            //  ? this code to know how much pages 
            $total_pages = ceil($total_record / $num_per_page);
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<button class="btn btn-dark m-2"><a class="sp" href="den.php?page=' . $i . '">' . $i . '</a></button>';
            } ?>
            <!-- <?php
                    //             $sql = "select * from den ";
                    //             $result_sql = mysqli_query($conn, $sql);
                    //             $total_record = mysqli_num_rows($result_sql);
                    // // PHP code here, if needed

                    // // Generating the HTML button element
                    // ;

                    //             // ! echo $total_record;
                    //             // ? this code to know how much pages 
                    //             $total_pages = ceil($total_record / $num_per_page);
                    //             for ($i = 1; $i <= $total_pages; $i++) {
                    //                 echo '<button data-label="Register" class="rainbow-hover">';
                    //                 echo "<a class='sp ' href='den.php?page=" . $i . "'>$i</a>";
                    //                echo '</button>';
                    //             }
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
                        <span aria-hidden="true">×</span>
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