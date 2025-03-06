<?php
// Set the timezone to Thailand (Asia/Bangkok)
date_default_timezone_set('Asia/Bangkok');

// Database Connection (with UTF-8)
$db_host = "localhost";
$db_name = "db_applyonline2025";
$db_user = "root";
$db_pass = "12345678";

try {
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass); // Added charset=utf8mb4
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Add to ensure full UTF8 support
} catch (PDOException $e) {
  die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}
