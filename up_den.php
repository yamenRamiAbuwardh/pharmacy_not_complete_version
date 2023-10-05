<?php
require "conn.php";
session_start();
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM den where id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
};



if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $date = $_POST['date2'];

    $id_stock = $_POST['id_stock'];
    $selectedMedicines = $_POST['medicine_name'];
    $plusMinsu = $_POST['plusPrice'];
    $new_plus = $price + $plusMinsu;
    $minsuPrice = $_POST['minsuPrice'];
    $new_minus = $price - $minsuPrice;
    $query_update = "UPDATE den SET name = '$name', price = ' $price' , date2 = ' $date ' , id_stock = ' $id_stock '  , medicine_name = '$selectedMedicines' WHERE id = $id";
    if (mysqli_query($conn, $query_update)) {
        // if (!empty($plusMinsu)) {
        //     $query_update_plusPrice = "UPDATE den SET price = '$new_plus' where id = '$id' ";
        //     mysqli_query($conn, $query_update_plusPrice);
        // } elseif (!empty($minsuPrice)) {
        //     $query_update_plusPrice = "UPDATE den SET price = '$new_minus' where id = '$id' ";
        //     if (mysqli_query($conn, $query_update_plusPrice)) {
        //         $query_add_payment = "INSERT INTO money_1 (name , total , pay ,date2 , den_id ) VALUES ('$name' , '$price' , '$minsuPrice' , '$date' , '$id')";
        //         mysqli_query($conn, $query_add_payment);
        //     }
        // }
        $_SESSION['upDen'] = "ثم تعدبل $name بنجاح ";
    }
    header("Location:den.php");
}

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
        <form method="post">

            <div class="container my-5">
                <input type="hidden" class="form-control" name="id" id="exampleFormControlInput1" value="<?php echo $row["id"] ?>" placeholder="name">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"> الاسم </label>
                    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $row["name"] ?>" placeholder="name">
                </div>



                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">السعر</label>
                    <input type="text" class="form-control" name="price" id="exampleFormControlInput1" value="<?php echo $row["price"]; ?> " placeholder="Quantity">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">التاريخ </label>
                    <input type="date" class="form-control" name="date2" id="exampleFormControlInput1" value="<?php echo $row["date2"]; ?> " placeholder="Quantity">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">الشريط</label>
                    <input type="number" class="form-control" name="id_stock" id="exampleFormControlInput1" value="<?php echo $row["id_stock"]; ?> " placeholder="Quantity">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"> اسم الدواء </label>
                    <input type="text" name="medicine_name" value="<?php echo $row['medicine_name'] ?>" class="form-control">
                </div>
                <!-- <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"> زيادة سعر </label>
                    <input type="text" name="plusPrice" class="form-control" value="0">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">(الدفعة) نقصان سعر </label>
                    <input type="text" name="minsuPrice" class="form-control"  value="0">
                </div> -->
                <div class="mb-3">

                </div>
                <button class="btn btn-primary px-5 " name="submit">تعديل</button>

        </form>

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