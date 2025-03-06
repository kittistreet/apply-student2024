<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล

header('Content-Type: application/json; charset=utf-8');



// รับค่า ApplicantID จากการสแกน QR Code
$ApplicantID = $_POST['ApplicantID'] ?? '';




if (!$ApplicantID) {
    die(json_encode(["status" => "error", "message" => "ไม่มีข้อมูล ApplicantID"]));
}

// ดึงข้อมูลจากฐานข้อมูล
$query = "SELECT * FROM application_payments WHERE ApplicantID = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute([$ApplicantID]);
$paymentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paymentData) {
    die(json_encode(["status" => "error", "message" => "ไม่พบข้อมูล QR Code นี้"]));
}

// ตรวจสอบเวลาหมดอายุ
$currentTimestamp = time();
$expiryTimestamp = strtotime($paymentData['expiry_time']);

if ($currentTimestamp > $expiryTimestamp) {
    $updateQuery = "UPDATE application_payments SET status = 'expired' WHERE ApplicantID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([$ApplicantID]);
    
    die(json_encode(["status" => "error", "message" => "QR Code นี้หมดอายุแล้ว"]));
}

// ตรวจสอบสถานะการชำระเงิน
if ($paymentData['status'] == 'completed') {
    die(json_encode(["status" => "success", "message" => "ชำระเงินสำเร็จแล้ว"]));
}

// อัปเดตสถานะเป็น "processing"
$updateQuery = "UPDATE application_payments SET status = 'processing' WHERE ApplicantID = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->execute([$ApplicantID]);


echo json_encode(["status" => "success", "message" => "QR Code ถูกต้อง รอการชำระเงิน"]);
?>
