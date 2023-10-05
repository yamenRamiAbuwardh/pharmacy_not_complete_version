<?php
require "conn.php";
session_start();
$id = $_SESSION['ID'];
$num_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number from the URL or default to page 1
$start_from = ($page - 1) * $num_per_page; // Calculate the starting record for the current page

if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $search_trim  = trim($search_key);
    $query = "SELECT * FROM supller WHERE name LIKE '%$search_trim%'and users_id = '$id' LIMIT $start_from, $num_per_page";
} else {
    $query = "SELECT * FROM supller where users_id = '$id' LIMIT $start_from, $num_per_page";
}

$result = mysqli_query($conn, $query);

// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "DELETE FROM supller WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("location:allsupplers.php");
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
            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                
            </nav>
            <div><?php
                    if (isset($_SESSION['addSup'])) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['addSup']; ?>

                    </div>

                <?php
                        unset($_SESSION['addSup']);
                    } else if (isset($_SESSION['all_delete'])) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['all_delete']; ?>

                    </div>
                <?php
                        unset($_SESSION['all_delete']);
                    } else if (isset($_SESSION['updateSup'])) {
                ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $_SESSION['updateSup']; ?>

                    </div>
                <?php
                        unset($_SESSION['updateSup']);
                    } else if (isset($_SESSION['paySup'])) {
                        ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo $_SESSION['paySup']; ?>
        
                            </div>
                        <?php
                                unset($_SESSION['paySup']);
                            } else if (isset($_SESSION['deletePaySup'])) {
                                ?>
                                    <div class="alert alert-info" role="alert">
                                        <?php echo $_SESSION['deletePaySup']; ?>
                
                                    </div>
                                <?php
                                        unset($_SESSION['deletePaySupz']);
                                    }
                                ?>

                
            </div>
            <table class="table">
                <tr>
                    <th>اسم الموزع</th>
                    <th>عنوان الموزع</th>
                    <th>السعر</th>
                    <th>الرقم</th>
                    <th>الكمية</th>
                    <th>التاريح</th>

                    <th>نعديل</th>
                    <th>حذف</th>
                    <th>الدفعة </th>
                </tr>
                <?php
                $payment = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $payment += $row['priceminus'];
                ?>
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["addres"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td><?= $row['quntite']; ?></td>
                        <td><?= $row['date']; ?></td>

                        <td>
                            <form action="up_su.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <button class="btn btn-primary" name="update">نعديل</button>
                            </form>
                        </td>

                        <td>
                            <form method="post" action="all_delete.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-danger" type="submit" name="delete">delete</button>
                            </form>
                        </td>

                        <td>
                            <form action="all_suppler_for.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                <button class="btn btn-primary" name="all">الدفعة </button>
                        </td>
                        </form>

                    </tr>
                <?php
                }
                ?>




            </table>
            <!-- 
            <?php
            $sql = "select * from supller";
            $result_sql = mysqli_query($conn, $sql);
            $total_record = mysqli_num_rows($result_sql);
            //     // PHP code here, if needed

            //     // Generating the HTML button element
            // ;

            //  ? this code to know how much pages 
            $total_pages = ceil($total_record / $num_per_page);
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<button class="btn btn-dark m-2"><a class="sp" href="allsupplers.php?page=' . $i . '">' . $i . '</a></button>';
            }
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