<?php
require 'connect-pdo.php'; // โหลดไฟล์เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


// // echo date('Y-m-d H:i:s')."<br>";
// echo "now your system default time zone is : ". date_default_timezone_get() ."<br>";

session_start();
// ตรวจสอบ CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token");
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

    // ฟังก์ชันสำหรับทำความสะอาดข้อมูล (ป้องกัน XSS)
    function sanitize_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }




    // กำหนดจำนวนเงินแบบคงที่
    define('FIXED_AMOUNT', "400.00");

    // สร้างรหัสการสมัคร
    $year = date("y"); // 2 หลักสุดท้ายของปี
    $month = date("m"); // เดือน
    $day = date("d"); // วันที่
    $hour = date("H"); // ชั่วโมง
    $minute = date("i"); // นาที
    $second = date("s"); // วินาที
    $applicationId = "$year$month$day$hour$minute$second"; // เพิ่มวินาที

    // สร้าง Timestamp สำหรับหมดอายุ (3 วันจากนี้)
    $expiryTimestamp = strtotime("+3 days");

    // ข้อมูลสำหรับสร้าง QR CODE
    $billerID = "|099400018814500";
    $referenceNumber1 = $applicationId;
    $referenceNumber2 = "25680001";
    $orm_price_total_arr = explode(".", number_format(FIXED_AMOUNT, 2));
    $amount = "$orm_price_total_arr[0]" . "$orm_price_total_arr[1]";

    // รวมข้อมูลทั้งหมดที่ต้องการเข้ารหัส
    $paymentData = sprintf(
        "%s\n%s\n%s\n%s\n%s",
        $billerID,
        $referenceNumber1,
        $referenceNumber2,
        $amount,
        $expiryTimestamp // เพิ่ม Timestamp หมดอายุ
    );

    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'imageBase64' => false,
    ]);

    $qrcode = (new QRCode($options))->render($paymentData);

    // สร้างโฟลเดอร์ถ้ายังไม่มี
    if (!is_dir("upload/")) {
        mkdir("upload/");
    }

    // บันทึกรูป QR Code
    $orm_img_qr_code = "upload/$applicationId.png";
    file_put_contents($orm_img_qr_code, $qrcode);


    
    // บันทึกข้อมูลลง SESSION เพื่อนำไปแสดงในหน้าถัดไป
    $_SESSION['qrcode_image'] = $orm_img_qr_code;
    $_SESSION['expiry_date'] = date("Y-m-d H:i:s", $expiryTimestamp);
    $_SESSION['application_id'] = $applicationId;









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

    // echo "Record inserted successfully with ID: $applicationId";


}
