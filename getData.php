<?php
 
include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();

$username = $_SESSION["username"];
$img_id = $_GET["img_id"];

$like = $conn->query("SELECT COUNT(*) FROM comments WHERE img_id='$img_id' AND `like`!='0' AND username='$username'")->fetchColumn();
 
$result = $conn->query("SELECT COUNT(*) FROM comments WHERE img_id='$img_id' AND `like`='1'")->fetchColumn().";".$conn->query("SELECT COUNT(*) FROM comments WHERE img_id='$img_id' AND `like`='-1'")->fetchColumn();

$response = "";
$i = 0;

$stmt = $conn->prepare("SELECT comment, username, comment_time FROM comments WHERE img_id= :img_id AND comment IS NOT NULL");
$stmt->bindValue(':img_id', $_GET["img_id"]);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    $response = $response . ";" . str_replace(";", ",", $row['comment']);
    $response = $response . ";" . $row['username'];
    $response = $response . ";" . $row['comment_time'];
    $i += 3;
}

echo $like . ";" . $result . ";" . $i . $response;

?>