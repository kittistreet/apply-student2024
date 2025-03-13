<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// กำหนดจำนวนเงินคงที่
define('FIXED_AMOUNT', "400.00");

// สร้างรหัสผู้สมัคร
$year = date("y"); 
$month = date("m");
$day = date("d");
$hour = date("H");
$minute = date("i");
$second = date("s");
$ApplicantID = "$year$month$day$hour$minute$second";

// กำหนดเวลาหมดอายุ (3 วัน)
// $expiryTimestamp = strtotime("+3 days");
$expiryTimestamp = strtotime("+20 second");
$expiryDateTime = date("Y-m-d H:i:s", $expiryTimestamp);

$TranType = '2';



// สร้าง QR Code ข้อมูล
$billerID = "|099400018814500";
$referenceNumber1 = $ApplicantID;
$referenceNumber2 = "25680001";
$orm_price_total_arr = explode(".", number_format(FIXED_AMOUNT, 2));
$amount = "$orm_price_total_arr[0]" . "$orm_price_total_arr[1]";

// ข้อมูล QR Code
$paymentData = sprintf(
    "%s\n%s\n%s\n%s\n%s\n%s\n%s",
    $billerID,
    $referenceNumber1,
    $referenceNumber2,
    $amount,
    $TranType,
    $expiryDateTime,
    $duedate
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

// บันทึกข้อมูลลงฐานข้อมูล
$query = "INSERT INTO application_payments (ApplicantID, amount, qr_code, expiry_time, status) VALUES (?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($query);
$stmt->execute([$ApplicantID, FIXED_AMOUNT, $qrcodePath, $expiryDateTime]);

// บันทึกค่าใน SESSION
$_SESSION['qrcode_image'] = $qrcodePath;
$_SESSION['expiry_date'] = $expiryDateTime;
$_SESSION['ApplicantID'] = $ApplicantID;

// Redirect ไปยังหน้าแสดง QR Code
header("Location: payment-qrcode.php");
exit();
?>
