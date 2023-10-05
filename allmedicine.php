<?php

use LDAP\Result;

require "conn.php";
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

session_start();
$id = $_SESSION['ID'];

// ... (Previous code)
if (isset($_POST['import'])) {
    $exelMinus = array('text/xls', 'text/xlsx', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $exelMinus)) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadSheet = $reader->load($_FILES['file']['tmp_name']);
            $workSheet = $spreadSheet->getActiveSheet();
            $workSheet_arr = $workSheet->toArray();
            // Start the loop from the second row (index 1)
            for ($i = 2; $i <= count($workSheet_arr) - 1; $i++) {

                $price = mysqli_real_escape_string($conn, $workSheet_arr[$i][3]);
                $real_price = mysqli_real_escape_string($conn, $workSheet_arr[$i][4]);
                $name = mysqli_real_escape_string($conn, $workSheet_arr[$i][1]);

                $number_medicine = mysqli_real_escape_string($conn, $workSheet_arr[$i][0]);

                // $date2 = mysqli_real_escape_string($conn, $workSheet_arr[$i][1]);
                // $date = strtotime($date2);
                // $db_date = date("Y-m-d", $date);
                $type = mysqli_real_escape_string($conn, $workSheet_arr[$i][2]);
                
                // echo $i ;
                $prev = "SELECT * FROM medicines ";
                $prevres = mysqli_query($conn, $prev);
                if ($prevres->num_rows > 0) {
                    $conn->query("INSERT INTO medicines (name , number_medicine ,real_price ,type , price, users_id) VALUES ('$name', '$number_medicine' , '$real_price', '$type' , '$price', '$id')");
                    $_SESSION['excel'] = "ثم اضافة قائمة اكسل ";
                    header('Location: allmedicine.php');
                } else {
                    $conn->query("INSERT INTO medicines (name, number_medicine  , type, price, real_price , users_id) VALUES ('$name', '$number_medicine', '$real_price' , '$type' , '$price', '$id')");
                    $_SESSION['excel'] = "ثم اضافة قائمة اكسل ";
                    header('Location: allmedicine.php');
                }
            }
        }
    }
}

// ... (Rest of your code)





$id = $_SESSION['ID'];
$num_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number from the URL or default to page 1
$start_from = ($page - 1) * $num_per_page; // Calculate the starting record for the current page

if (isset($_POST['search'])) {
    $search_key = $_POST['search'];
    $searc_trim = trim($search_key);
    $query = "SELECT * FROM medicines WHERE users_id = '$id' AND name LIKE '%$searc_trim%' LIMIT $start_from, $num_per_page";
} else {
    $query = "SELECT * FROM medicines WHERE users_id = '$id' LIMIT $start_from, $num_per_page";
}


$result = mysqli_query($conn, $query);


// if (isset($_POST["delete"])) {
//     $id = $_POST["id"];
//     $query = "delete from  medicines WHERE id = '$id'";
//     mysqli_query($conn, $query);
//     header("Location: allmedicine.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/koko.css">
    <style>
        .pagination {
            justify-content: center;

        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }
    </style>

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
            <?php

            ?>
            <form method="post" enctype="multipart/form-data" class=" mb-5 ">
                <label class="form-label">ادخال ملف exel</label>
                <input type="file" class="form-control" name="file">
                <button class="btn btn-success mt-2" name="import">ادخال المعلومات</button>
            </form>
            <a href="export.php"><button type="button" class="btn btn-success">export</button></a>

            <div><?php
                    if (isset($_SESSION['stuts'])) {
                    ?>
                    <div class="alert alert-success" role="alert">

                        <?php echo $_SESSION['stuts']; ?>
                    </div>

                <?php
                        echo $_SESSION['stuts'];
                        unset($_SESSION['stuts']);
                    } elseif (isset($_SESSION['excel'])) {

                ?>
                    <div class="alert alert-success" role="alert">

                        <?php echo $_SESSION['excel']; ?>
                    </div>
                <?php
                        unset($_SESSION['excel']);
                    } else if (isset($_SESSION['delete'])) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['delete']; ?>

                    </div>
                <?php
                        unset($_SESSION['delete']);
                    } else if (isset($_SESSION['updatemedicine'])) {
                ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $_SESSION['updatemedicine']; ?>

                    </div>
                <?php
                        unset($_SESSION['updatemedicine']);
                    } else if (isset($_SESSION['addBay'])) {
                ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $_SESSION['addBay']; ?>

                    </div>
                <?php
                        unset($_SESSION['addBay']);
                    }
                ?>

            </div>


            <table class="table" border="2px">
                <thead>
                <td>رقم الدواء </td>
                <td>اسم الدواء </td>
                <td>الوحدة</td>
                <td>سعر الدواء </td>
                <td>سعر الجملة </td>
                <!-- <td>هل منتهي</td> -->


                </thead>

                <?php
                while ($rows = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $rows["number_medicine"]; ?></td>
                        <td><?php echo $rows["name"]; ?></td>
                        <td>
                            <?php echo $rows['type'];?>
                        </td>
                        <td><?php echo $rows["price"];?></td>
                        <td> <?php echo  $rows["real_price"] ?></td>
                        



                        <!-- <td><?php
                            // $counter_expired = 0;
                            // $date = date("Y-m-d");
                            // if ($date > $rows["date2"]) {
                            //     echo "<h6 class = 'bg-danger text-white pl-1 pt-3 pb-3'>منتهي الصلاحية</h6>";
                            //     $counter_expired++;
                            // } else {
                            //     echo  " <h6 class = 'bg-primary text-white pl-5 pt-3 pb-3'>ليس منتهي الصلاحية</h6>";
                            // }

                            ?>
                        </td> -->
                        <td>
                            <form action="up.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $rows["id"]; ?>">
                                <button class="btn btn-primary" name="update">تعديل</button>
                            </form>
                        </td>
                        <td>

                            <!-- Button trigger modal -->
                            <form method="post" action="alldelete_mad.php">
                                <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $rows['name']; ?>">
                                <button class="btn btn-danger" type="submit" name="delete">delete</button>
                            </form>
                            <!-- ? i need to do a from action and send the id and select with a new [quantity ] That he have put it So lets do the form  -->
                        <td>
                            <form action="addBay.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">

                                <button class="btn btn-warning" type="submit" name="update">البيع </button>
                            </form>
                        </td>

                    </tr>

                <?php
                }
                ?>
            </table>
            <?php
            $sql = "select * from medicines";
            $result_sql = mysqli_query($conn, $sql);
            $total_record = mysqli_num_rows($result_sql);
            //     // PHP code here, if needed

            //     // Generating the HTML button element
            // ;

            //  ? this code to know how much pages 
            $total_pages = ceil($total_record / $num_per_page);


            ?>

            <div class="text-center">
                <ul class="pagination">
                    <?php
                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="allmedicine.php?page=' . ($page - 1) . '">الصفحة السابقة </a></li>';
                    }

                    if ($page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="allmedicine.php?page=' . ($page + 1) . '">الصفحة القادمة </a></li>';
                    }

                    echo '<li class="page-item"><a class="page-link" href="allmedicine.php?page=' . $total_pages . '">الصفحة الاخيرة </a></li>';
                    ?>
                </ul>
            </div>


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