<?php
require "conn.php";
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $date2 = $_POST['date2'];
    $quantity = $_POST['quantity'];
    $best = $_POST['best'];
    $id_sub = $_POST['id_sup'];
    $price =$_POST['price'];
    $query = "INSERT INTO medicines (name, date2 , quantity  , best, id_sup, price ) VALUES ('$name',  '$date2', '$quantity', '$best' , '$id_sub','$price')";
    mysqli_query($conn, $query);
    header("Location:allmedicine.php");
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
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name Medicine </label>
                    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="name">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Expiry</label>
                    <input type="date" class="form-control" name="date2" id="exampleFormControlInput1" placeholder="Expiry date	">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">stock</label>
                    <input type="text" class="form-control" name="quantity" id="exampleFormControlInput1" placeholder="Quantity">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">price</label>
                    <input type="text" class="form-control" name="price" id="exampleFormControlInput1" placeholder="price">
                </div>
                <select name="best">
                        <option value="1">1</option>
                        <option value="0">0</option>

                </select>
                <div class="mb-3">

                    <select name="id_sup">
                        <?php
                        $quary_dpt = "SELECT * FROM supller";
                        $result_dept = mysqli_query($conn, $quary_dpt);
                        while ($rows_dept = mysqli_fetch_assoc($result_dept)) {
                        ?>

                            <option value="<?php echo $rows_dept['id'] ?>"><?php echo $rows_dept['name'] ?></option>
                        <?php
                        }
                        ?>


                    </select>
                </div>
                <button class="btn btn-primary px-5 " name="barcode">ADD</button>

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