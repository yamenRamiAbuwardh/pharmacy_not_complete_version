<?php
    require "conn.php";
    session_start();
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $query_update_buy = "select * from buy where id = '$id'";
        $result_update_buy = mysqli_query($conn , $query_update_buy);
        $row = mysqli_fetch_assoc($result_update_buy);
    }
    if(isset($_POST['submit'])):
        if(isset($_POST["submit"])){
            $id = $_POST["id"];
            $name = $_POST['name'];
            $date2 = $_POST['date2'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
    
            $query_update = "UPDATE buy SET name = '$name', date2 = '$date2' , quantity = '$quantity' , price = '$price' WHERE id = $id";
            if(mysqli_query($conn , $query_update)):
                $query_update_medicines = "UPDATE medicines SET quantity_minus = '$quantity' ";
                if(mysqli_query($conn , $query_update_medicines)):
                    $_SESSION['upBuy'] = "ثم التعديل  $nameبنجاح ";                    header('location:allBuy.php');
                endif;
            endif;
        }

    endif;
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
            <input type="hidden" class="form-control"   name="id" id="exampleFormControlInput1" value="<?php echo $row["id"] ?>" placeholder="name">

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">اسم الدواء </label>
                <input type="text" class="form-control"  readonly name="name" id="exampleFormControlInput1" value="<?php echo $row["name"] ?>" placeholder="اسم الدواء">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">تاريخ الانتهاء</label>
                <input type="date" class="form-control" readonly  name="date2"  value="<?php echo $row["date2"] ?>" id="exampleFormControlInput1" placeholder=" تاريخ الانتهاء">
            </div>
           
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">كمية الاشرطة</label>
                <input type="text" class="form-control"  name="quantity" id="exampleFormControlInput1" value="<?php echo $row["quantity"];?> " placeholder="كمية الاشرطة">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">سعر الشريط</label>
                <input type="number" class="form-control"  name="price" id="exampleFormControlInput1" value="<?php echo $row["price"];?> " placeholder="سعر الشريط" >
            </div>
            <button class="btn btn-primary px-5 " name="submit">نعديل</button>
            
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