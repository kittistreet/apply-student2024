<?php
try {
  $conn = new PDO("mysql:host=localhost;dbname=db_applyonline2025", "root", "root");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}

// Google reCAPTCHA Configuration
$recaptcha_secret = '6Lf4JuMqAAAAAN2pidvT48pxyGKRocR66Cfrw9M_';


