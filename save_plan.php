<?php
include 'connect-pdo.php'; // เชื่อมต่อฐานข้อมูลด้วย PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan'])) {
    $plan = trim($_POST['plan']);
    
    if (!empty($plan)) {
        try {
            // ตรวจสอบว่าแผนการเรียนมีอยู่แล้วหรือไม่
            $stmt = $conn->prepare("SELECT COUNT(*) FROM study_plan WHERE Name_plan = ?");
            $stmt->execute([$plan]);
            $exists = $stmt->fetchColumn();

            if ($exists == 0) { // ถ้าไม่มี ให้เพิ่มลงฐานข้อมูล
                $insertStmt = $conn->prepare("INSERT INTO study_plan (Name_plan) VALUES (?)");
                $insertStmt->execute([$plan]);
            }
        } catch (PDOException $e) {
            // ป้องกัน error โดยไม่แจ้งเตือนผู้ใช้
        }
    }
}
?>
