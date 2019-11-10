<?php
 
include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();
$username = $_SESSION["username"]; 

$stmt = $conn->prepare("SELECT img_base64 FROM imgs WHERE username= :username ORDER BY img_id DESC LIMIT 1");
$stmt->bindValue(':username', $username);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['img_base64'];

?>