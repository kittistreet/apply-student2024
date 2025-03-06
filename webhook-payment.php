<?php
require 'connect-pdo.php';
header('Content-Type: application/json; charset=utf-8');


// รับข้อมูล JSON จาก Payment Gateway
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$ApplicantID = $data['ApplicantID'] ?? '';
$amountPaid = $data['amount'] ?? 0;
$paymentStatus = $data['status'] ?? '';

// ทดสอบส่งค่ามา
// $ApplicantID = $_POST['ApplicantID'] ?? '';
// $amountPaid = $_POST['amount'] ?? 0;
// $paymentStatus = $_POST['status'] ?? '';

if (!$ApplicantID || !$amountPaid || !$paymentStatus) {
    http_response_code(400);
    die(json_encode(["status" => "error", "message" => "ข้อมูลไม่ครบถ้วน"]));
}

// ค้นหาข้อมูลการชำระเงิน
$query = "SELECT * FROM application_payments WHERE ApplicantID = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$ApplicantID]);
$paymentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paymentData) {
    http_response_code(404);
    die(json_encode(["status" => "error", "message" => "ไม่พบคำขอชำระเงิน"]));
}

// ตรวจสอบจำนวนเงิน
if ($paymentData['amount'] != $amountPaid) {
    die(json_encode(["status" => "error", "message" => "จำนวนเงินไม่ถูกต้อง"]));
}

// ตรวจสอบเวลาหมดอายุ
$currentTimestamp = time();
$expiryTimestamp = strtotime($paymentData['expiry_time']);

if ($currentTimestamp > $expiryTimestamp) {
    die(json_encode(["status" => "error", "message" => "QR Code นี้หมดอายุแล้ว"]));
}

// อัปเดตสถานะเป็น "completed"
$updateQuery = "UPDATE application_payments SET status = 'completed' WHERE ApplicantID = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->execute([$ApplicantID]);

http_response_code(201);
echo json_encode(["status" => "success", "message" => "การชำระเงินสำเร็จ"]);
?>
