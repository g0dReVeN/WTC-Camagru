<?php

include_once("config/database.php");
$conn->query('USE db_camagru');

$count = $conn->query("SELECT COUNT(*) FROM imgs")->fetchColumn();
$n = $_GET["n"];
$response = "";

$i = 0;
$respArr = array();
$r = $count - $n;

if ($r > 0)
{
    $stmt = $conn->prepare("SELECT img_id, img_base64 FROM (SELECT img_id, img_base64 FROM imgs ORDER BY img_id ASC LIMIT $r) AS I ORDER BY img_id DESC LIMIT 40");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $respArr[$i]['img_id'] = $row['img_id'];
        $respArr[$i]['img_base64'] = $row['img_base64'];
        $i++;
    }

    for($i = 0; $i < 40; $i++)
    {
        $response = $response . $respArr[$i]['img_id'] . '!' . $respArr[$i]['img_base64'] . '!';
    }
}

echo $response;

?>