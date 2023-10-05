<?php
require "conn.php";

session_start();
$id = $_SESSION['ID'];
$date_2 = date("Y-m-d");
if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $search_trim  = trim($search_key);
    $query_2 = "SELECT * FROM medicines WHERE date2 < '$date_2' and name like '%$search_trim%' and users_id ='$id'";
} else {
    $query_2 = "SELECT * FROM medicines WHERE date2 < '$date_2' and users_id ='$id'";
}

$result_2 = mysqli_query($conn, $query_2);

// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "DELETE FROM medicines WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("Location:expired.php");
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
    <link rel="stylesheet" href="css/table.css">
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
            <table class="table">
                <tr>
                    <th>الاسم</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الكمية</th>
                    <th>الموزعين</th>

                    <th>هل منتهي </th>
                    <th>تعديل</th>
                    <th>حذف</th>
                </tr>
                <?php

                while ($row = mysqli_fetch_assoc($result_2)) {

                ?>
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["date2"]; ?></td>

                        <td><?php echo $row["quantity"]; ?></td>
                        <td>
                            <?php
                            $query_name = "SELECT * FROM supller";
                            $result_name = mysqli_query($conn, $query_name);
                            $row_name = mysqli_fetch_assoc($result_name);
                            echo $row_name["name"];
                            ?>
                        </td>

                        <td><?php
                            $counter_expired = 0;
                            $date = date("Y-m-d");
                            if ($date > $row["date2"]) {
                                echo "<h6 class = 'bg-danger text-white pl-5 pt-3 pb-3'>منتهي الاصلاحية</h6>";
                                $counter_expired++;
                            } else {
                                echo  " <h6 class = 'bg-primary text-white pl-5 pt-3 pb-3'>ليس منتهي الاصلاحية </h6>";
                            }

                            ?>
                        </td>
                        <td>
                            <form action="up.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <button class="btn btn-primary" name="update">تعديل</button>
                            </form>
                        </td>
                        <td>
                    <form method="post" action="alldelete_mad.php">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-danger" type="submit" name="delete">delete</button>
</form>
                    </td>

                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">are you sure?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        اضغط حذف للحذف
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>

                                        <form method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-danger">الحذف</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td>

                    </tr>
                <?php
                }
                ?>
            </table>
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