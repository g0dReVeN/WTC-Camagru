<?php
 
include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();

$username = $_SESSION["username"]; 
$img_id = $_GET["img_id"];

$stmt = $conn->prepare("DELETE FROM imgs WHERE img_id= :img_id AND username= :username LIMIT 1");
$stmt->bindValue(':username', $username);
$stmt->bindValue(':img_id', $img_id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM comments WHERE img_id= :img_id");
$stmt->bindValue(':img_id', $img_id);
$stmt->execute();
header("Location: mine.php");

?>