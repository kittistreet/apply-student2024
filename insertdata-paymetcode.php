<?php
require 'connect-pdo.php'; // โหลดไฟล์เชื่อมต่อฐานข้อมูล

require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;



// สร้างรหัสการสมัคร
$year = date("y"); // 2 หลักสุดท้ายของปี
$month = date("m"); // เดือน
$day = date("d"); // วันที่
$hour = date("H"); // ชั่วโมง
$minute = date("i"); // นาที
$second = date("s"); // วินาที
$applicationId = "$year$month$day$hour$minute$second"; // เพิ่มวินาที




/*สร้าง QR CODE*/
$billerID = "|099400018814500";
$referenceNumber1 = $applicationId;
$referenceNumber2 = "25680001";
$orm_price_total_arr = explode(".", number_format("400", 2));
$amount = "$orm_price_total_arr[0]" . "$orm_price_total_arr[1]";

$paymentData = sprintf(
    "%s\n%s\n%s\n%s",
    $billerID,
    $referenceNumber1,
    $referenceNumber2,
    $amount
);
$options = new QROptions([
    'eccLevel' => QRCode::ECC_L,
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'imageBase64' => false,
]);
$qrcode = (new QRCode($options))->render($paymentData);


$flgCreate = mkdir("upload/");
$orm_img_qr_code = "upload/$applicationId.png";
file_put_contents($orm_img_qr_code, $qrcode);
/*สร้าง QR CODE*/





// รหัสผู้สมัครและวันที่สมัคร
$applicationDate = date("Y-m-d"); // วันที่ปัจจุบัน

// เพิ่มข้อมูลเข้าฐานข้อมูล
$sql = "INSERT INTO ApplicationIDs (ApplicantID, ApplicationDate) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$applicationId, $applicationDate]);



echo "Record inserted successfully with ID: $applicationId";
