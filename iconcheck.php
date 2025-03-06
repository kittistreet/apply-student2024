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


    <script>
        const icons = [...document.querySelectorAll('[class*="icon-"], [class*="fa-"]')].map(el => el.className);
        console.log([...new Set(icons)]);
    </script>


<i class="fa fa-page4"></i>
<span class="icon-check"></span>



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