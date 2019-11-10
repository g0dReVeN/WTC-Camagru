<?php

$s_no = $_POST["s_no"];
$i = 0;

$image = array();
/*$image[0] = imagecreatefrompng('blank.png');
$image[1] = imagecreatefrompng('blank.png');
$image[2] = imagecreatefrompng('blank.png');
$image[3] = imagecreatefrompng('blank.png');
$image[4] = imagecreatefrompng('blank.png');
$image[5] = imagecreatefrompng('blank.png');*/

while ($i < $s_no)
{
    //$str = "uploads/image".$i.".png";
    $image[$i] = imagecreatefrompng(str_replace('http://127.0.0.1:8080/camagru/', '', $_POST["sticker$i"]));
    //imagepng($image[$i], $str);
    $i++;
}

imagealphablending($image[0], true);
imagesavealpha($image[0], true);
imagealphablending($image[1], true);
imagesavealpha($image[1], true);
imagealphablending($image[2], true);
imagesavealpha($image[2], true);
imagealphablending($image[3], true);
imagesavealpha($image[3], true);
imagealphablending($image[4], true);
imagesavealpha($image[4], true);
imagealphablending($image[5], true);
imagesavealpha($image[5], true);

imagecopy($image[4], $image[0], 0, 0, 0, 0, 1000, 600);
imagecopy($image[4], $image[1], 0, 0, 0, 0, 1000, 600);
imagecopy($image[4], $image[2], 0, 0, 0, 0, 1000, 600);
imagecopy($image[4], $image[3], 0, 0, 0, 0, 1000, 600);
//imagepng($image[4], 'uploads/image1.png');

$img = $_POST['pic'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);

$image[5] = imagecreatefromstring(base64_decode($img));
imagecopy($image[5], $image[0], 0, 0, 0, 0, 1000, 600);
imagecopy($image[5], $image[1], 0, 0, 0, 0, 1000, 600);
imagecopy($image[5], $image[2], 0, 0, 0, 0, 1000, 600);
imagecopy($image[5], $image[3], 0, 0, 0, 0, 1000, 600);
ob_start(); // Let's start output buffering.
    imagejpeg($image[5]); //This will normally output the image, but because of ob_start(), it won't.
    $contents = ob_get_contents(); //Instead, output above is saved to $contents
ob_end_clean(); //End the output buffer.

$img64 = "data:image/jpeg;base64," . base64_encode($contents);

session_start();
$username = $_SESSION["username"];

include_once("config/database.php");
$conn->query('USE db_camagru');

$stmt = $conn->prepare("INSERT INTO imgs (username, img_base64) VALUES (:username, :img_base64)");
$stmt->bindValue(':username', $username);
$stmt->bindValue(':img_base64', $img64);
$stmt->execute();

$stmt = $conn->prepare("SELECT img_base64 FROM imgs WHERE username= :username ORDER BY img_id DESC LIMIT 1");
$stmt->bindValue(':username', $username);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['img_base64'];

?>