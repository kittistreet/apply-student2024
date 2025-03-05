<?php
require 'connect-pdo.php'; // โหลดไฟล์เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;



session_start();
// ตรวจสอบ CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token");
    }



    // ฟังก์ชันสำหรับทำความสะอาดข้อมูล (ป้องกัน XSS)
    function sanitize_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }


    

    // สร้างรหัสการสมัคร
    $year = date("y");
    $month = date("m");
    $day = date("d");
    $hour = date("H");
    $minute = date("i");
    $second = date("s");
    $applicationId = "$year$month$day$hour$minute$second";
    $applicationDate = date("Y-m-d");




    // เพิ่มข้อมูลเข้าตาราง ApplicationIDs
    try {
        $sql = "INSERT INTO application_ids (ApplicantID, ApplicationDate) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$applicationId, $applicationDate]);
        // echo "DEBUG: ApplicationIDs inserted successfully.<br>";
    } catch (PDOException $e) {
        die("Error inserting ApplicationIDs: " . $e->getMessage());
    }





    // รับค่าจาก $_POST และทำความสะอาดข้อมูล 
    $pdpa = sanitize_input($_POST['pdpa'] ?? null);
    $type_application = sanitize_input($_POST['type_application'] ?? null);
    $course = sanitize_input($_POST['course'] ?? null);
    $education = sanitize_input($_POST['education'] ?? null);
    $Educationlevel_O = sanitize_input($_POST['Educationlevel_O'] ?? null);
    $edu_plan = sanitize_input($_POST['edu_plan'] ?? null);
    $gpa = sanitize_input($_POST['gpa'] ?? null);
    $tcas = sanitize_input($_POST['tcas'] ?? null);

    // เพิ่มข้อมูลเข้าตาราง applicationedu
    try {
        $sql = "INSERT INTO application_edu 
            (ApplicantID, pdpa, type_application, course, education, Educationlevel_O, edu_plan, gpa, tcas) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $applicationId,
            $pdpa,
            $type_application,
            $course,
            $education,
            $Educationlevel_O,
            $edu_plan,
            $gpa,
            $tcas
        ]);

        // echo "DEBUG: applicationedu inserted successfully.<br>";
    } catch (PDOException $e) {
        die("Error inserting applicationedu: " . $e->getMessage());
    }





    // รับค่าข้อมูลที่อยู่จาก $_POST และทำความสะอาดข้อมูล
    $Address1 = sanitize_input($_POST['Address1'] ?? null);
    $Province = sanitize_input($_POST['province_1'] ?? null);
    $District = sanitize_input($_POST['District_1'] ?? null);
    $Sub_district = sanitize_input($_POST['Sub_District_1'] ?? null);
    $zipcode = sanitize_input($_POST['zipcode_1'] ?? null);
    $Phone = sanitize_input($_POST['Phone_1'] ?? null);
    $IDLine = sanitize_input($_POST['IDLine'] ?? null);
    $Email = sanitize_input($_POST['Email_1'] ?? null);

    // เพิ่มข้อมูลเข้าตาราง application_ads1
    try {
        $sql = "INSERT INTO application_ads1 
            (`ApplicantID`, `Address1`, `Province`, `District`, `Sub_district`, `zipcode`, `Phone`, `IDLine`, `Email`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $applicationId,
            $Address1,
            $Province,
            $District,
            $Sub_district,
            $zipcode,
            $Phone,
            $IDLine,
            $Email
        ]);
    } catch (PDOException $e) {
        die("Error inserting into application_ads1: " . $e->getMessage());
    }







    // บันทึกลง log
    file_put_contents('logs.txt', date("Y-m-d H:i:s") . " - Application submitted: $applicationId\n", FILE_APPEND);
}



// ตรวจสอบ Google reCAPTCHA
// $recaptcha_secret = "YOUR_SECRET_KEY"; // เปลี่ยนเป็น Secret Key ของคุณ
// $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';


// if (!$recaptcha_response) {
//     die("Please complete the reCAPTCHA verification.");
// }


// // ตรวจสอบกับ Google
// $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
// $response = file_get_contents($verify_url);
// $response_data = json_decode($response, true);


// if (!$response_data['success']) {
//     die("reCAPTCHA verification failed. Please try again.");
// }




echo "Record inserted successfully with ID: $applicationId";
