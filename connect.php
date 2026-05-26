<?php

$host="localhost";
$user="root";
$pass="";
$db="login";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
    exit();
}

function ensureColumn($conn, $table, $column, $definition) {
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($result && $result->num_rows === 0) {
        $conn->query("ALTER TABLE `$table` ADD COLUMN `$column` $definition");
    }
}

$tables = $conn->query("SHOW TABLES LIKE 'users'");
if ($tables && $tables->num_rows === 1) {
    ensureColumn($conn, 'users', 'is_verified', 'TINYINT(1) NOT NULL DEFAULT 0');
    ensureColumn($conn, 'users', 'verification_code', 'VARCHAR(6) DEFAULT NULL');
}
?>