<?php
require 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูล

// ฟังก์ชันสร้าง API Key แบบสุ่ม
function generateApiKey($length = 32)
{
    return bin2hex(random_bytes($length));
}

// สร้าง API Key ใหม่
$newApiKey = generateApiKey();

// บันทึก API Key ลงฐานข้อมูล
$query = "INSERT INTO api_keys (api_key) VALUES (:api_key)";
$stmt = $conn->prepare($query);
$stmt->execute(['api_key' => $newApiKey]);

echo "✅ API Key ใหม่ของคุณ: $newApiKey";
?>
