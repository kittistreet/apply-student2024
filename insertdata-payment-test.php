<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

require 'connect-pdo.php';
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// กำหนดตัวแปร
$seller_tax_id = "0994000188145"; // 13 หลัก
$suffix = "00"; // 2 หลัก
$referenceNumber1 = date("ymdHis"); // สูงสุด 20 หลัก
$referenceNumber2 = "25680001"; // สูงสุด 20 หลัก
$totalAmount = "40000"; // 400.00 บาท (ไม่มีจุดทศนิยม)
$transactionType = "2";
$dueDate = date('dmY', strtotime('+3 days'));
$quantity = "1";
$salesAmount = "37383"; // มูลค่าสินค้าไม่รวม VAT
$vatRate = "0700"; // 7.00%
$vatAmount = "2617"; // จำนวนเงิน VAT
$sellerVatBranchID = "00000";
$buyerTaxID = ""; // ไม่ระบุ
$buyerVatBranchID = ""; // ไม่ระบุ
$buyerName = ""; // ไม่ระบุ
$referenceNumber3 = "";
$proxyID = "";
$proxyType = "";
$netAmount = "40000";
$typeOfIncome = "";
$withholdingTaxRate = "";
$withholdingTaxAmount = "";
$withholdingTaxCondition = "";

// สร้างข้อมูล QR Code
$paymentData = implode(chr(13), [
    "|$seller_tax_id$suffix",
    $referenceNumber1,
    $referenceNumber2,
    $totalAmount,
    $transactionType,
    $dueDate,
    $quantity,
    $salesAmount,
    $vatRate,
    $vatAmount,
    $sellerVatBranchID,
    $buyerTaxID,
    $buyerVatBranchID,
    $buyerName,
    $referenceNumber3,
    $proxyID,
    $proxyType,
    $netAmount,
    $typeOfIncome,
    $withholdingTaxRate,
    $withholdingTaxAmount,
    $withholdingTaxCondition
]);

$options = new QROptions([
    'eccLevel' => QRCode::ECC_L,
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'imageBase64' => false,
]);

$qrcode = (new QRCode($options))->render($paymentData);

// บันทึก QR Code
$qrcodePath = "upload/{$referenceNumber1}.png";
if (!is_dir("upload/")) {
    mkdir("upload/", 0755, true);
}
file_put_contents($qrcodePath, $qrcode);

// บันทึกข้อมูลลงฐานข้อมูล
$query = "INSERT INTO application_payments (ApplicantID, amount, qr_code, expiry_time, status) VALUES (?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($query);
$expiryDateTime = date("Y-m-d H:i:s", strtotime('+3 days'));
$stmt->execute([$referenceNumber1, number_format($totalAmount / 100, 2, '.', ''), $qrcodePath, $expiryDateTime]);

// SESSION
$_SESSION['qrcode_image'] = $qrcodePath;
$_SESSION['expiry_date'] = $expiryDateTime;
$_SESSION['ApplicantID'] = $referenceNumber1;

// Redirect
header("Location: payment-qrcode.php");
exit();
