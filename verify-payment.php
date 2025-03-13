<?php
session_start();
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล

header('Content-Type: application/json; charset=utf-8');

// ✅ ไฟล์ Log
$logFile = 'payment_log.log';

// ✅ ฟังก์ชันสำหรับเขียน Log
function writeLog($message)
{
    global $logFile;
    $date = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$date] $message" . PHP_EOL, FILE_APPEND);
}

// ✅ ฟังก์ชันตรวจสอบ API Key
function verifyApiKey($apiKey, $conn)
{
    $query = "SELECT id FROM api_keys WHERE api_key = :api_key LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute(['api_key' => $apiKey]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

// ✅ ดึง API Key จาก Header
$headers = getallheaders();
$receivedApiKey = $headers['Authorization'] ?? '';

// ✅ ตรวจสอบ API Key
if (!preg_match('/^Bearer\s+(.+)$/', $receivedApiKey, $matches)) {
    http_response_code(401);
    writeLog("❌ Unauthorized access attempt");
    die(json_encode(["status" => "error", "message" => "Unauthorized - API Key missing"]));
}

$apiKey = $matches[1];

if (!verifyApiKey($apiKey, $conn)) {
    http_response_code(403);
    writeLog("❌ Forbidden access - Invalid API Key");
    die(json_encode(["status" => "error", "message" => "Forbidden - Invalid API Key"]));
}

// ✅ รับค่า ApplicantID จากการสแกน QR Code
$ApplicantID = $_POST['ApplicantID'] ?? '';

// ✅ ตรวจสอบว่า ApplicantID เป็นตัวเลข (ป้องกัน SQL Injection)
if (!ctype_digit($ApplicantID)) {
    http_response_code(400);
    writeLog("⚠️ Invalid ApplicantID received: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "ApplicantID ไม่ถูกต้อง"]));
}

// ✅ Rate Limiting (ป้องกันการเรียก API ซ้ำบ่อยเกินไป)
if (isset($_SESSION['last_request']) && time() - $_SESSION['last_request'] < 2) {
    http_response_code(429);
    writeLog("⚠️ Too many requests from the same session");
    die(json_encode(["status" => "error", "message" => "กรุณารอสักครู่ก่อนลองใหม่"]));
}
$_SESSION['last_request'] = time();

// ✅ ค้นหาข้อมูลในฐานข้อมูล
$query = "SELECT * FROM application_payments WHERE ApplicantID = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute([$ApplicantID]);
$paymentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paymentData) {
    http_response_code(404);
    writeLog("⚠️ QR Code not found for ApplicantID: $ApplicantID");
    die(json_encode(["status" => "error", "message" => "ไม่พบข้อมูล QR Code นี้"]));
}

// ✅ ตรวจสอบเวลาหมดอายุ
$currentTimestamp = time();
$expiryTimestamp = strtotime($paymentData['expiry_time']);

if ($currentTimestamp > $expiryTimestamp) {
    $updateQuery = "UPDATE application_payments SET status = 'expired' WHERE ApplicantID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([$ApplicantID]);

    writeLog("⚠️ QR Code expired for ApplicantID: $ApplicantID");
    http_response_code(410);
    die(json_encode(["status" => "error", "message" => "QR Code นี้หมดอายุแล้ว"]));
}

// ✅ ตรวจสอบสถานะการชำระเงิน
if ($paymentData['status'] === 'completed') {
    writeLog("✅ Payment already completed for ApplicantID: $ApplicantID");
    http_response_code(200);
    die(json_encode(["status" => "success", "message" => "ชำระเงินสำเร็จแล้ว"]));
}

// ✅ อัปเดตสถานะเป็น "processing"
$updateQuery = "UPDATE application_payments SET status = 'processing' WHERE ApplicantID = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->execute([$ApplicantID]);

writeLog("🔄 QR Code validated, status updated to processing for ApplicantID: $ApplicantID");

// ✅ ตอบกลับข้อมูลสำเร็จ
http_response_code(200);
echo json_encode(["status" => "success", "message" => "QR Code ถูกต้อง รอการชำระเงิน"]);
?>
