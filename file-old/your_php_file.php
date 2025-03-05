<?php
require_once 'connect-pdo.php';
if (!isset($conn)) {
    die(json_encode(["error" => "Database connection not established"]));
}
