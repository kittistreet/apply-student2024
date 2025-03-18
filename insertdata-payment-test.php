<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล
require 'payment/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// กำหนดจำนวนเงินคงที่
define('FIXED_AMOUNT', "400.00");

// สร้างรหัสผู้สมัคร (ใช้เป็นตัวอย่างสำหรับ Reference No.1)
$year   = date("y"); 
$month  = date("m");
$day    = date("d");
$hour   = date("H");
$minute = date("i");
$second = date("s");
$ApplicantID = "$year$month$day$hour$minute$second";

// กำหนดเวลาหมดอายุ (3 วัน)
$expiryTimestamp = strtotime("+3 days");
$expiryDateTime = date("Y-m-d H:i:s", $expiryTimestamp);

// ------------------------
// เตรียมข้อมูลสำหรับ QR Code รูปแบบที่ 2 สำหรับการโอนเงิน
// ------------------------

// Field 1: Prefix + Seller/Receiver TAX ID + Suffix
$prefix = "|"; 
// กำหนดเลขประจำตัวผู้เสียภาษีของผู้รับโอน (ควรมี 13 หลัก)
$receiverTaxID = "0994000188145"; 
// กำหนด Suffix (รหัสอ้างอิงของผู้รับโอน) 2 หลัก
$receiverSuffix = "00"; 
$field1 = $prefix . $receiverTaxID . $receiverSuffix;

// Field 2: Reference No.1 / Customer No. (20 หลัก) 
$field2 = $ApplicantID;  // ใช้รหัสผู้สมัครเป็นตัวอย่าง

// Field 3: Reference No.2 (20 หลัก)
$field3 = "25680001"; // ตัวอย่าง

// Field 4: Total Amount (10 หลัก, Numeric; ไม่ใส่จุดทศนิยม)
// แปลงตัวเลข 400.00 เป็น "40000" (รวมเศษส่วน)
$amountParts = explode(".", number_format(FIXED_AMOUNT, 2, ".", ""));
$field4 = $amountParts[0] . $amountParts[1];

// Field 5: Transaction Type (1 หลัก, Alpha) สำหรับการโอนเงิน ให้พิมพ์ "1"
$field5 = "1";

// Field 6: Due Date (8 หลัก, Alphanumeric) ในรูปแบบ DDMMYYYY
$field6 = date("dmY", $expiryTimestamp);

// Field 7: Quantity (10 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field7 = "0";

// Field 8: Sales Amount (10 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field8 = "0";

// Field 9: VAT Rate (4 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field9 = "0";

// Field 10: VAT Amount (10 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field10 = "0";

// Field 11: Seller/Receiver VAT Branch ID (5 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field11 = "";

// Field 12: Buyer/Sender TAX ID (13 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field12 = "";

// Field 13: Buyer/Sender VAT Branch ID (5 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field13 = "";

// Field 14: Buyer/Sender Name (140 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field14 = "";

// Field 15: Reference No.3 (20 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field15 = "";

// Field 16: Proxy ID (30 หลัก, Alphanumeric) – ตัวอย่างหมายเลขบัญชีธนาคาร
$field16 = "0031234567890"; 

// Field 17: Proxy Type (12 หลัก, Alphanumeric) – เช่น "BANKACC"
$field17 = "BANKACC";

// Field 18: Net Amount (10 หลัก, Numeric) – สมมุติให้เท่ากับ Total Amount
$field18 = $field4;

// Field 19: Type of Income (3 หลัก, Alphanumeric) – ไม่ใช้ ให้เว้นว่าง
$field19 = "";

// Field 20: Withholding Tax Rate (4 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field20 = "0";

// Field 21: Withholding Tax Amount (10 หลัก, Numeric) – ไม่ใช้ ให้พิมพ์ "0"
$field21 = "0";

// Field 22: Withholding Tax Conditions (1 หลัก, Alpha) – สมมุติให้ "S" (สำหรับการจ่ายเงินครั้งเดียว)
$field22 = "S";

// รวมข้อมูลทุก Field โดยใช้ CR (Carriage Return, "\r") เป็นตัวคั่น
$fields = [
    $field1, $field2, $field3, $field4, $field5,
    $field6, $field7, $field8, $field9, $field10,
    $field11, $field12, $field13, $field14, $field15,
    $field16, $field17, $field18, $field19, $field20,
    $field21, $field22
];

$paymentData = implode("\r", $fields);

// ------------------------
// สร้าง QR Code ด้วย QROptions
// ------------------------
$options = new QROptions([
    'eccLevel'    => QRCode::ECC_M, // ตามแนวปฏิบัติ แนะนำให้ใช้ระดับ M (15% recovery)
    'outputType'  => QRCode::OUTPUT_IMAGE_PNG,
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
$_SESSION['expiry_date']  = $expiryDateTime;
$_SESSION['ApplicantID']  = $ApplicantID;

// Redirect ไปยังหน้าแสดง QR Code
header("Location: payment-qrcode.php");
exit();
?>
