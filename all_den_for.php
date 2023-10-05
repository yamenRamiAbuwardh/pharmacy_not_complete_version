<?php
require "conn.php";
session_start();
$id = $_SESSION['ID'];
$id = $_POST['id'];
// $name = $_POST['name'];
$query = "SELECT * FROM den WHERE id = '{$id}'";
$result = mysqli_query($conn, $query);
$query_2 = "SELECT * FROM money_1 WHERE den_id = '$id' ";
$result_2 = mysqli_query($conn, $query_2);
// if (isset($_POST['delete'])) {
//     $id = $_POST['id'];
//     $query = "DELETE FROM den where id ='$id'";
//     mysqli_query($conn, $query);
//     header('location:all_den_for.php');
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


        <div class="container">

            <table class="table">
                <tr>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>الشريط</th>
                    <th>اسم الدواء</th>
                    <th>التاريخ</th>


                    <th>تعديل</th>
                    <th>الحذف</th>
                    <th>الدفعة</th>


                </tr>

                <?php

                $total  = 0;
                $priceMinus = 0;

                while ($rows = mysqli_fetch_assoc($result_2)) :
                    $priceMinus += $rows['pay'];

                endwhile;
                while ($row = mysqli_fetch_assoc($result)) {
                    // first
                    $query_total = "select * from money_1";
                    $result_total = mysqli_query($conn, $query_total);
                    $rows = mysqli_fetch_assoc($result_total);
                    $total += $row["price"];

                ?>
                    <tr>
                        <?php
                        ?>


                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["price"]; ?> شيكل</td>
                        <td><?php echo $row["id_stock"]; ?></td>
                        <td><?php echo $row["medicine_name"]; ?></td>
                        <td><?php echo $row["date2"]; ?></td>


                        <?php



                        ?>
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
                        <td>
                            <form action="pay.php" method="post">
                                <input type="hidden" name="total_depth" value="<?php echo $counter; ?>">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                <button class="btn btn-primary" name="pay">الدفعة</button>
                            </form>
                        </td>
                    <td>
                    <form action="requier_den_all.php" method="post">
                <input type="hidden" name="name" value="<?=$row['name']?>">
                <button class="btn btn-success" type="submit">export</button>
            </form>
                    </td>

                    </tr>
                <?php
                } ?>



            </table>

            <h1> الدين الكلي :<?php echo $total; ?></h1>
        </div>

        <!-- Content Wrapper -->


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
    <script src="js.js"></script>
</body>

</html>