<?php

use LDAP\Result;

require "conn.php";
$query = "SELECT * FROM medicines";

$result = mysqli_query($conn, $query);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/koko.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

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
                        <input type="text" class="form-control bg-light border-0 small" placeholder="البحت" name="search">
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
                    <thead style="font-size:large; font-weight:bolder;  ">

                        <td>اسم الدواء </td>
                        <td>تاريخ الانتهاء </td>
                        <td>كمية الدواء </td>
                        <td>سعر الدواء </td>
                        <td>موزع الدواء </td>
                        <td>هل منتهي</td>


                    </thead>
                    
                <?php
                while ($rows = mysqli_fetch_assoc($result)) {

                ?>
                    <tr>
                        <td><?php echo $rows["name"]; ?></td>
                        <td><?php echo $rows["date2"]; ?></td>
                        <td> <?php echo  $rows["quantity"] ?></td>
                        <td><?php echo $rows["price"] ?></td>
                        <td>
                            <?php
                            echo $rows['id_sup'];
                            ?>
                        </td>



                        <td><?php
                            $counter_expired = 0;
                            $date = date("Y-m-d");
                            if ($date > $rows["date2"]) {
                                echo "<h6 class = 'bg-danger text-white pl-1 pt-3 pb-3'>منتهي الصلاحية</h6>";
                                $counter_expired++;
                            } else {
                                echo  " <h6 class = 'bg-primary text-white pl-5 pt-3 pb-3'>ليس منتهي الصلاحية</h6>";
                            }

                            ?>
                        </td>

    
  

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



    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
    <script src="js/js.js"></script>
</body>

</html>