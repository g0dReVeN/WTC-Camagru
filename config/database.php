<?php

$DB_DSN = "mysql:host=localhost;charset=utf8mb4";
$DB_USER = "";
$DB_PASSWORD = "";
$DB_OPTIONS = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try 
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>