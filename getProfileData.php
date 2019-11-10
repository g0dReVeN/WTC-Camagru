<?php 

include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();
$username = $_GET["username"];

$stmt = $conn->prepare("SELECT username, email, notice, propic FROM users WHERE username= :username LIMIT 1");
$stmt->bindValue(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$propic = substr($result["propic"], 22);
if ($propic[0] == ',')
    $propic = substr($propic, 1);

echo $result["username"] . ";" . $result["email"] . ";" . $result["notice"] . ";" . $propic;

?>