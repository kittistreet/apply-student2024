<?php
session_start();
// Set the timezone to Thailand (Asia/Bangkok)
date_default_timezone_set('Asia/Bangkok');



require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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

// Redirect ไปหน้าแสดง QR Code
header("Location: payment-qrcode.php");
exit();
