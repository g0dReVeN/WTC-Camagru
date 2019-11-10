<?php
 
include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();
$username = $_SESSION["username"];
$img_id = $_POST["img_id"];
//$img_id = 122;
$comment = $_POST["comment"];
//$comment = "a";
$like = $_POST["like"];

$stmt = $conn->prepare("INSERT INTO comments (img_id, username, comment, `like`) VALUES (:img_id, :username, :comment, :like)");
$stmt->bindValue(':img_id', $img_id);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':comment', $comment);
$stmt->bindValue(':like', $like);
$stmt->execute();

$stmt = $conn->prepare("SELECT username FROM imgs WHERE img_id= :img_id");
$stmt->bindValue(':img_id', $img_id);
$stmt->execute();
$username2 = $stmt->fetchColumn();

if ($username != $username2)
{
    $stmt = $conn->prepare("SELECT email FROM users WHERE username= :username AND notice=`1`");
    $stmt->bindValue(':username', $username2);
    $stmt->execute();
    $email = $stmt->fetchColumn();

    if ($comment && $email)
    {
        $subject = "Camagru - Comment Notification";
        $message = "Good Day,\r\n
                    A comment was made recently on one of your pics, please click the link below to view & reply:>\r\n\n
                    <http://127.0.0.1:8080/camagru/all.php?img_id=$img_id>\r\n\n
                    Email sent by CAMAGRU";
        $headers = "From: no-reply@localhost\r\n".
                    "X-Mailer:PHP/".phpversion();

        $result = mail($email, $subject, $message, $headers);
    }
}s

?>