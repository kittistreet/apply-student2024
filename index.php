<?php
require 'connect-pdo.php';
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    echo $_SESSION['csrf_token'];
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


    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <style>
        .state-error {
            border: 2px solid red;
        }

        .state-success {
            border: 2px solid green;
        }

        em {
            color: red;
            font-size: 14px;
        }
    </style>


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

                            <form action="insertdata-step1.php" name="myForm" method="post" id="multiStepForm" enctype="multipart/form-data" novalidate>

                                <div class="container">
                                    <div id="step-1">
                                        <?php include 'stepPDPA.php'; ?>
                                    </div>


                                    <div id="step-2" class="hidden">
                                        <?php include 'step2.php'; ?>
                                    </div>


                                    <div id="step-3" class="hidden">
                                        <?php include 'step3.php'; ?>
                                    </div>

                                </div>




                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // ฟังก์ชันเปิด Modal
                                        function showModal(message) {
                                            document.querySelector("#insertdata .modal-body").innerHTML = message;
                                            $("#insertdata").modal("show"); // ใช้ Bootstrap Modal
                                        }


                                        // ปุ่ม Next 1 -> 2
                                        document.getElementById("next-1").addEventListener("click", function() {
                                            document.getElementById("nav-step-1").classList.remove("active");
                                            document.getElementById("nav-step-2").classList.add("active");
                                            document.getElementById("step-1").classList.add("hidden");
                                            document.getElementById("step-2").classList.remove("hidden");
                                        });

                                        // ปุ่ม Next 2 -> 3
                                        document.getElementById("next-2").addEventListener("click", function() {
                                            document.getElementById("nav-step-2").classList.remove("active");
                                            document.getElementById("nav-step-3").classList.add("active");
                                            document.getElementById("step-2").classList.add("hidden");
                                            document.getElementById("step-3").classList.remove("hidden");
                                        });

                                        // ปุ่ม Previous 2 -> 1
                                        document.getElementById("prev-2").addEventListener("click", function() {
                                            document.getElementById("nav-step-2").classList.remove("active");
                                            document.getElementById("nav-step-1").classList.add("active");
                                            document.getElementById("step-2").classList.add("hidden");
                                            document.getElementById("step-1").classList.remove("hidden");
                                        });

                                        // ปุ่ม Previous 3 -> 2
                                        document.getElementById("prev-3").addEventListener("click", function() {
                                            document.getElementById("nav-step-3").classList.remove("active");
                                            document.getElementById("nav-step-2").classList.add("active");
                                            document.getElementById("step-3").classList.add("hidden");
                                            document.getElementById("step-2").classList.remove("hidden");
                                        });




                                        // ฟังก์ชันตรวจสอบค่าว่างเฉพาะฟิลด์ที่ต้องการ
                                        function validateForm() {
                                            let isValid = true;
                                            let requiredFields = document.querySelectorAll("#multiStepForm [data-required='true']:not([disabled]):not([hidden])");

                                            requiredFields.forEach(field => {
                                                if (!field.value.trim()) {
                                                    isValid = false;
                                                    field.classList.add("is-invalid"); // เพิ่ม class แสดงข้อผิดพลาด (ใช้ Bootstrap)
                                                } else {
                                                    field.classList.remove("is-invalid");
                                                }
                                            });

                                            return isValid;
                                        }

                                        // ลบ class is-invalid ทันทีที่พิมพ์ข้อมูล
                                        document.querySelectorAll("#multiStepForm [data-required='true']:not([disabled]):not([hidden])").forEach(field => {
                                            field.addEventListener("input", function() {
                                                if (field.value.trim()) {
                                                    field.classList.remove("is-invalid");
                                                }
                                            });
                                        });

                                        // ปุ่ม Submit
                                        document.getElementById("multiStepForm").addEventListener("submit", function(event) {
                                            event.preventDefault(); // ป้องกันการ submit อัตโนมัติ

                                            // ตรวจสอบว่าฟอร์มครบถ้วนหรือไม่
                                            if (!validateForm()) {
                                                showModal("กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน!");
                                                return;
                                            }

                                            // เช็คว่าอยู่ที่ step-3 เท่านั้น
                                            if (!document.getElementById("step-3").classList.contains("hidden")) {
                                                let formData = new FormData(this);

                                                fetch("insertdata-step1.php", {
                                                        method: "POST",
                                                        body: formData
                                                    })
                                                    .then(response => response.text()) // หรือใช้ response.json() ถ้าต้องการ JSON
                                                    .then(data => {
                                                        console.log("Response:", data);
                                                        showModal("ส่งข้อมูลเรียบร้อยแล้ว!"); // แสดง Modal เมื่อส่งข้อมูลสำเร็จ
                                                    })
                                                    .catch(error => {
                                                        console.error("Error:", error);
                                                        showModal("เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง!"); // แสดง Modal เมื่อเกิด Error
                                                    });
                                            }
                                        });
                                    });





                                    
                                </script>


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


    <!-- Logout Modal-->
    <div class="modal fade" id="insertdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">แจ้งเตือน</h5>
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