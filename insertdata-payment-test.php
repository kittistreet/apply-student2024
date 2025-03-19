<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// กำหนดจำนวนเงินคงที่
define('FIXED_AMOUNT', "400.00");

// สร้างรหัสผู้สมัคร
$ApplicantID = date("ymdHis"); // ใช้รูปแบบ ปี+เดือน+วัน+ชั่วโมง+นาที+วินาที

// วันที่และเวลาปัจจุบัน
$currentDate = date("Y-m-d"); // ได้เฉพาะวันที่ เช่น 2025-03-18
$currentTime = date("H:i:s"); // ได้เฉพาะเวลา เช่น 14:35:22


// กำหนดเวลาหมดอายุ (3 วัน)
$expiryTimestamp = strtotime("+3 days");
// $expiryTimestamp = strtotime("+20 second");
$expiryDateTime = date("Y-m-d H:i:s", $expiryTimestamp);

// สร้าง QR Code ข้อมูล
$Prefix ="|";
$billerID = "099400018814500";
$referenceNumber1 = $ApplicantID;
$referenceNumber2 = "25680001";
$orm_price_total_arr = explode(".", number_format(FIXED_AMOUNT, 2));
$amount = "$orm_price_total_arr[0]" . "$orm_price_total_arr[1]";

// ข้อมูล QR Code
$paymentData = sprintf(
    "%s\n%s\n%s\n%s\n%s",
    
    $Prefix&$billerID,
    $referenceNumber1,
    $referenceNumber2,
    $amount,
    $expiryTimestamp
);

$options = new QROptions([
    'eccLevel' => QRCode::ECC_L,
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'imageBase64' => false,
]);

$qrcode = (new QRCode($options))->render($paymentData);

// บันทึกไฟล์ QR Code
if (!is_dir("upload/")) {
    mkdir("upload/");
}
$qrcodePath = "upload/$ApplicantID.png";
file_put_contents($qrcodePath, $qrcode);



//ปรับฐานข้อมูลส่วนนนี้ ให้บันทึกลงใน transactions
// บันทึกข้อมูลลงฐานข้อมูล
// $query = "INSERT INTO application_payments (ApplicantID, amount, qr_code, expiry_time, status) VALUES (?, ?, ?, ?, 'pending')";
// $stmt = $conn->prepare($query);
// $stmt->execute([$ApplicantID, FIXED_AMOUNT, $qrcodePath, $expiryDateTime]);

$query = "INSERT INTO application_transactions (payeeId, transDate, transTime, transRef, channel, termId, amount, reference1, fromBank, path_qr) VALUES (?, ?, ?, ?, 'A', ?, ?, ?, '002', ?)";
$stmt = $conn->prepare($query);
$stmt->execute([$billerID, $currentDate, $currentTime, $ApplicantID, $ApplicantID, FIXED_AMOUNT, $ApplicantID, $qrcodePath]);












// บันทึกค่าใน SESSION
$_SESSION['qrcode_image'] = $qrcodePath;
$_SESSION['expiry_date'] = $expiryDateTime;
$_SESSION['ApplicantID'] = $ApplicantID;

// Redirect ไปยังหน้าแสดง QR Code
header("Location: payment-qrcode.php");
exit();
?>
