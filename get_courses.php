<?php
// นำเข้าไฟล์เชื่อมต่อฐานข้อมูล
require_once 'connect-pdo.php';

try {
    // ตรวจสอบค่าที่รับมาจาก AJAX
    if (isset($_POST['type_id'])) {
        $type_id = $_POST['type_id'];

        $sql = "SELECT fn_application.ID_Course, fn_application.GPA, course_application.Name_Course 
                FROM fn_application 
                INNER JOIN course_application ON fn_application.ID_Course = course_application.ID_Course 
                WHERE fn_application.ID_Type = :type_id
                AND fn_application.Date_Start <= CURDATE()
                AND fn_application.Date_End >= CURDATE()";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ส่งข้อมูลกลับเป็น JSON
        echo json_encode($courses);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
}
