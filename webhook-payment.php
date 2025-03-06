<?php
require 'connect-pdo.php';
header('Content-Type: application/json; charset=utf-8');

// ไฟล์ Log
$logFile = 'payment_log.log';

// ฟังก์ชันสำหรับเขียน Log
function writeLog($message)
{
    global $logFile;
    $date = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$date] $message" . PHP_EOL, FILE_APPEND);
}


// ฟังก์ชันตรวจสอบ API Key
function verifyApiKey($apiKey, $conn)
{
    $query = "SELECT id FROM api_keys WHERE api_key = :api_key LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute(['api_key' => $apiKey]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

// ดึง API Key จาก Header
$headers = getallheaders();
$receivedApiKey = $headers['Authorization'] ?? '';

// ตรวจสอบ API Key
if (!preg_match('/^Bearer\s+(.+)$/', $receivedApiKey, $matches)) {
    http_response_code(401);
    die(json_encode(["status" => "error", "message" => "Unauthorized - API Key missing"]));
}

$apiKey = $matches[1];

if (!verifyApiKey($apiKey, $conn)) {
    http_response_code(403);
    die(json_encode(["status" => "error", "message" => "Forbidden - Invalid API Key"]));
}

// รับข้อมูล JSON จาก Payment Gateway
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// ตรวจสอบ JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    writeLog("❌ Invalid JSON format");
    die(json_encode(["status" => "error", "message" => "ข้อมูล JSON ไม่ถูกต้อง"]));
}

// ดึงค่าจาก JSON พร้อมตรวจสอบความปลอดภัย
$ApplicantID = $data['ApplicantID'] ?? '';
$amountPaid = $data['amount'] ?? 0;
$paymentStatus = $data['status'] ?? '';

// ตรวจสอบข้อมูลว่ามีค่าหรือไม่
if (empty($ApplicantID) || empty($amountPaid) || empty($paymentStatus)) {
    http_response_code(400);
    writeLog("⚠️ Incomplete data received: " . json_encode($data));
    die(json_encode(["status" => "error", "message" => "ข้อมูลไม่ครบถ้วน"]));
}

// ตรวจสอบว่า ApplicantID เป็นตัวเลข
if (!ctype_digit($ApplicantID)) {
    http_response_code(400);
    writeLog("⚠️ Invalid ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "ApplicantID ไม่ถูกต้อง"]));
}

// ตรวจสอบว่า amountPaid เป็นตัวเลข และไม่ติดลบ
if (!is_numeric($amountPaid) || $amountPaid <= 0) {
    http_response_code(400);
    writeLog("⚠️ Invalid amountPaid: $amountPaid");
    die(json_encode(["status" => "error", "message" => "จำนวนเงินไม่ถูกต้อง"]));
}

// 🔍 ค้นหาข้อมูลการชำระเงิน
$query = "SELECT * FROM application_payments WHERE ApplicantID = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$ApplicantID]);
$paymentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paymentData) {
    http_response_code(404);
    writeLog("⚠️ Payment request not found for ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "ไม่พบคำขอชำระเงิน"]));
}

// ตรวจสอบว่าการชำระเงินเสร็จสมบูรณ์ไปแล้วหรือไม่
if ($paymentData['status'] === 'completed') {
    http_response_code(409);
    writeLog("⚠️ Payment already completed for ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "การชำระเงินนี้ถูกดำเนินการไปแล้ว"]));
}

// ตรวจสอบจำนวนเงิน
if ((float)$paymentData['amount'] !== (float)$amountPaid) {
    http_response_code(400);
    writeLog("⚠️ Incorrect payment amount for ApplicantID: $ApplicantID, Expected: {$paymentData['amount']}, Received: $amountPaid");
    die(json_encode(["status" => "error", "message" => "จำนวนเงินไม่ถูกต้อง"]));
}

// ตรวจสอบเวลาหมดอายุของ QR Code
$currentTimestamp = time();
$expiryTimestamp = strtotime($paymentData['expiry_time']);

if ($currentTimestamp > $expiryTimestamp) {
    http_response_code(410);
    writeLog("⚠️ Expired QR Code for ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "QR Code นี้หมดอายุแล้ว"]));
}

// ✅ อัปเดตสถานะเป็น "completed"
$updateQuery = "UPDATE application_payments SET status = 'completed' WHERE ApplicantID = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateSuccess = $updateStmt->execute([$ApplicantID]);

if (!$updateSuccess) {
    http_response_code(500);
    writeLog("❌ Failed to update payment status for ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"]));
}

// ✅ บันทึกข้อมูลการชำระเงินสำเร็จ
writeLog("✅ Payment successful for ApplicantID: $ApplicantID, Amount: $amountPaid");

// ✅ ส่ง Response สำเร็จ
http_response_code(201);
echo json_encode(["status" => "success", "message" => "การชำระเงินสำเร็จ"]);
?>
