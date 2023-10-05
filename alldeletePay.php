<?php


require "conn.php";
session_start();

if (isset($_POST['delete'])) {
    $id = $_POST['get_id'];
    $query = "SELECT * FROM money_1 where id = '$id'";
    $result = mysqli_query($conn, $query);
}
if (isset($_POST['deletefor'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $query_delete = " DELETE FROM money_1 where id = '$id'";
    if(mysqli_query($conn, $query_delete)){
        $_SESSION['deletePay'] = " ثم حذف دفعة $name  ";
    }
    header('location:den.php');
    exit();
}


// $total_of_pay = 0;
// $remaining_total = 0;

// while ($row_get_data = mysqli_fetch_assoc($result_get_data)) {
//     $total_of_pay = $row_get_data["pay"];
//     $remaining_total = $row_get_data['total'] - $total_of_pay;

//     // Store row data for manipulation
//     $row_get_data['remaining_total'] = $remaining_total;
//     $data_rows[] = $row_get_data;
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

        <table class="table">


            <th>الاسم</th>
            <th>كل الديون </th>
            <th>مقدار الدفعة </th>
            <th>ملاحظات</th>
            <th>التاريخ</th>

            <th>الحذف</th>
            <th>رجوع</th>

            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {

            ?>

                <tr>
                    <td><?php echo $row["name"]; ?></td>
                    <td> <?php echo $row["total"]; ?></td>
                    <td><?php echo $row["pay"]; ?> </td>

                    <td><?php echo $row["comment"]; ?></td>
                    <td><?php echo $row["date2"]; ?></td>



                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                            <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">

                            <button class="btn btn-danger" name="deletefor">حذف</button>
                        </form>
                    </td>
                    <td>
                        <a href="den.php"><button class="btn btn-primary">رجوع</button></a>
                    </td>
                </tr>
            <?php
            }
            ?>



        </table>
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

</body>

</html>