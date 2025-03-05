<?php
require 'connect-pdo.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="#" />

    <title>Applystudent-SLC</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link href="plugin/bootstrap-datepicker-thai-thai/css/datepicker.css" rel="stylesheet" media="screen">





    <style>
        .hidden {
            display: none;
        }
    </style>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- navbar -->
                <?php include 'navbar.php'; ?>
                <!-- end navbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Applystudent system</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-flag"></i> FAQ </a>
                    </div>


                    <!-- Content Row -->
                    <div class="row">


                        <div class="col-lg-12 mb-4">

                            <form action="insertdata-step1.php" name="myForm" method="post" id="multiStepForm" enctype="multipart/form-data">

                                <div class="container">

                                    <div id="step-1">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">แบบแสดงความยินยอมในการเก็บ ใช้ และเปิดเผยข้อมูลส่วนบุคคล</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h5>ข้อตกลงและเงื่อนไขการใช้งาน</h5>

                                                </div>


                                                <hr>

                                                <div class="text-center">
                                                    <p><b>ข้าพเจ้าได้รับทราบถึงข้อตกลงและเงื่อนไขการเก็บ ใช้ และเปิดเผยข้อมูลส่วนบุคคล ดังกล่าว และยินยอมตามเงื่อนไขดังกล่าวทุกประการ</b></p>
                                                </div>


                                                <div class="text-center">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox small">

                                                            <input type="checkbox" class="custom-control-input" id="agree" name="pdpa" value="1">

                                                            <label class="custom-control-label" for="agree">ยินยอม</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-user btn-block" id="next-1">NEXT</button>
                                                <hr>




                                            </div>
                                        </div>
                                    </div>


                                    <div id="step-2" class="hidden">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลรูปแบบการสมัครและข้อมูลการศึกษาเบื่องต้น</h6>
                                            </div>
                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                                        <label style="font-weight: bold;">รูปแบบการสมัคร</label>
                                                        <select class="form-control" id="type_application" name="type_application">
                                                            <option value="">-โปรดเลือกรูปแบบการสมัคร-</option>
                                                            <?php
                                                            // ดึงข้อมูลจากตาราง type_application
                                                            $stmt = $conn->prepare("SELECT ID_Type, Type_name FROM type_application WHERE Status = 1");
                                                            $stmt->execute();
                                                            $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($applications as $app) {
                                                                echo '<option value="' . htmlspecialchars($app['ID_Type']) . '">' . htmlspecialchars($app['Type_name']) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>



                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        document.getElementById("next-1").addEventListener("click", function(event) {
                                                            event.preventDefault(); // ป้องกันการรีโหลดหรือรีไดเรก
                                                            document.getElementById("step-1").classList.add("hidden");
                                                            document.getElementById("step-2").classList.remove("hidden");
                                                        });

                                                        document.getElementById("prev-2").addEventListener("click", function(event) {
                                                            event.preventDefault();
                                                            document.getElementById("step-2").classList.add("hidden");
                                                            document.getElementById("step-1").classList.remove("hidden");
                                                        });
                                                    });
                                                </script>






                                                <hr>

                                            </div>
                                        </div>
                                    </div>

                                </div>







                            </form>



                        </div>
                    </div>





                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'footer.php'; ?>
            i <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">โปรดตรวจสอบข้อมูล</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>









    <!-- เงื่อนไขปุ่มต่างๆ  -->
    <script src="js/fn-from.js"></script>


    <script src="//getbootstrap.com/2.3.2/assets/js/jquery.js"></script>




    <!-- datepicker -->
    <script src="plugin/bootstrap-datepicker-thai-thai/js/bootstrap-datepicker.js"></script>
    <script src="plugin/bootstrap-datepicker-thai-thai/js/bootstrap-datepicker-thai.js"></script>
    <script src="plugin/bootstrap-datepicker-thai-thai/js/locales/bootstrap-datepicker.th.js"></script>





    <!-- jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script> -->




</body>

</html>