<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// กำหนดจำนวนเงินคงที่
define('FIXED_AMOUNT', "1.00");

// สร้างรหัสผู้สมัคร
$ApplicantID = date("ymdHis"); // ใช้รูปแบบ ปี+เดือน+วัน+ชั่วโมง+นาที+วินาที

// วันที่และเวลาปัจจุบัน
$currentDate = date("Y-m-d"); // ได้เฉพาะวันที่ เช่น 2025-03-18
$currentTime = date("H:i:s"); // ได้เฉพาะเวลา เช่น 14:35:22


// กำหนดเวลาหมดอายุ (3 วัน)
$expiryTimestamp = strtotime("+3 days");
// $expiryTimestamp = strtotime("+20 second");
$expiryDateTime = date("dmY", strtotime("+3 days"));

// สร้าง QR Code ข้อมูล
$prefix ="|";
$billerID = "099400018814500";
$suffix = '00';
$referenceNumber1 = $ApplicantID;
$referenceNumber2 = "25680001201585455413";
$orm_price_total_arr = explode(".", number_format(FIXED_AMOUNT, 2));
$amount = "$orm_price_total_arr[0]" . "$orm_price_total_arr[1]";
$TransactionType = "1";

// ข้อมูล QR Code
$paymentData = sprintf(
    "%s%s%s\r%s\r%s\r%s\r%s",
    
    $prefix,
    $billerID,
    $suffix,
    $referenceNumber1,
    $referenceNumber2,
    $amount,
    $expiryDateTime
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




$query = "INSERT INTO application_transactions (payeeId, transDate, transTime, transRef, channel, termId, amount, reference1, fromBank, path_qr) VALUES (?, ?, ?, ?, 'I', ?, ?, ?, '0', ?)";
$stmt = $conn->prepare($query);
$stmt->execute([$billerID, $currentDate, $currentTime, $referenceNumber1, $referenceNumber2, FIXED_AMOUNT, $ApplicantID, $qrcodePath]);




// บันทึกค่าใน SESSION
$_SESSION['qrcode_image'] = $qrcodePath;
$_SESSION['expiry_date'] = $expiryDateTime;
$_SESSION['ApplicantID'] = $ApplicantID;
$_SESSION['paymentData'] = $paymentData ;
 
// Redirect ไปยังหน้าแสดง QR Code
header("Location: payment-qrcode.php");
exit();
?>
