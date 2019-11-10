<?php 

session_start();

if (!isset($_SESSION["username"])) 
{
    header("location: login.php"); 
    exit();
}

$username = $_SESSION["username"]; 
$password = $_SESSION["password"]; 

include_once("config/database.php");
$conn->query('USE db_camagru');

$stmt = $conn->prepare("SELECT password FROM users WHERE username= :username LIMIT 1");
$stmt->bindValue(':username', $username);
$stmt->execute();
$result = $stmt->rowCount(); 
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $result["password"]))
{ 
	session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>
<!doctype html>
<html>
<head>
    <title>Camagru</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="main.css" type="text/css">
    <script src="index.js"></script>
</head>
<body onload="camera()">
    <?php include_once("header.php"); ?>
    <div class="container">
        <div class="main">
            <div class="title"><p>Choose an Overlay(s)</p></div>
            <div class="filters">
                <img src="images/filters/blank.png" onclick="sticker('images/filters/blank.png')">
                <img src="images/filters/deer.png" onclick="sticker('images/filters/deer.png')">
                <img src="images/filters/king.png" onclick="sticker('images/filters/king.png')">
                <img src="images/filters/santa.png" onclick="sticker('images/filters/santa.png')">
                <img src="images/filters/frame.png" onclick="sticker('images/filters/frame.png')">
            </div>
            <video id="video" width="0" height="0" autoplay></video>
            <div id="camview">
                <canvas id="canvas" width="640" height="480"></canvas>
                <br><br>
                <div id="btngrp">
                    <input type="file" id="fileElem" multiple accept="image/*" style="display:none" onchange="previewFile()">
                    <div onclick="filer()">
                        <svg id="upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" height="100px" width="100px" x="0px" y="0px" viewBox="0 0 419.2 419.2" style="enable-background:new 0 0 419.2 419.2;" xml:space="preserve" width="512px" height="512px">
                            <g>
                                <circle cx="158" cy="144.4" r="28.8" fill="#00ccff"/>
                                <path d="M394.4,250.4c-13.6-12.8-30.8-21.2-49.6-23.6V80.4c0-15.6-6.4-29.6-16.4-40C318,30,304,24,288.4,24h-232
                                c-15.6,0-29.6,6.4-40,16.4C6,50.8,0,64.8,0,80.4v184.4V282v37.2c0,15.6,6.4,29.6,16.4,40c10.4,10.4,24.4,16.4,40,16.4h224.4
                                c14.8,12,33.2,19.6,53.6,19.6c23.6,0,44.8-9.6,60-24.8c15.2-15.2,24.8-36.4,24.8-60C419.2,286.8,409.6,265.6,394.4,250.4z
                                M21.2,80.4c0-9.6,4-18.4,10.4-24.8c6.4-6.4,15.2-10.4,24.8-10.4h232c9.6,0,18.4,4,24.8,10.4c6.4,6.4,10.4,15.2,10.4,24.8v124.8
                                l-59.2-58.8c-4-4-10.8-4.4-15.2,0L160,236l-60.4-60.8c-4-4-10.8-4.4-15.2,0l-63.2,64V80.4z M56,354.8v-0.4
                                c-9.6,0-18.4-4-24.8-10.4c-6-6.4-10-15.2-10-24.8V282v-12.8L92.4,198l60.4,60.4c4,4,10.8,4,15.2,0l89.2-89.6l58.4,58.8
                                c-1.2,0.4-2.4,0.8-3.6,1.2c-1.6,0.4-3.2,0.8-5.2,1.6c-1.6,0.4-3.2,1.2-4.8,1.6c-1.2,0.4-2,0.8-3.2,1.6c-1.6,0.8-2.8,1.2-4,2
                                c-2,1.2-4,2.4-6,3.6c-1.2,0.8-2,1.2-3.2,2c-0.8,0.4-1.2,0.8-2,1.2c-3.6,2.4-6.8,5.2-9.6,8.4c-15.2,15.2-24.8,36.4-24.8,60
                                c0,6,0.8,11.6,2,17.6c0.4,1.6,0.8,2.8,1.2,4.4c1.2,4,2.4,8,4,12v0.4c1.6,3.2,3.2,6.8,5.2,9.6H56z M378.8,355.2
                                c-11.6,11.6-27.2,18.4-44.8,18.4c-16.8,0-32.4-6.8-43.6-17.6c-1.6-1.6-3.2-3.6-4.8-5.2c-1.2-1.2-2.4-2.8-3.6-4
                                c-1.6-2-2.8-4.4-4-6.8c-0.8-1.6-1.6-2.8-2.4-4.4c-0.8-2-1.6-4.4-2-6.8c-0.4-1.6-1.2-3.6-1.6-5.2c-0.8-4-1.2-8.4-1.2-12.8
                                c0-17.6,7.2-33.2,18.4-44.8c11.6-11.6,27.2-18.4,44.8-18.4c17.6,0,33.2,7.2,44.8,18.4c11.6,11.2,18.4,27.2,18.4,44.8
                                C397.2,328,390,343.6,378.8,355.2z" fill="#00ccff"/>
                                <path d="M368.8,299.6h-24.4v-24.4c0-6-4.8-10.8-10.8-10.8s-10.8,4.8-10.8,10.8v24.4h-24.4c-6,0-10.8,4.8-10.8,10.8
                                s4.8,10.8,10.8,10.8h24.4v24.4c0,6,4.8,10.8,10.8,10.8s10.8-4.8,10.8-10.8v-24.4h24.4c6,0,10.8-4.8,10.8-10.8
                                S374.8,299.6,368.8,299.6z" fill="#00ccff"/>
                            </g>
                        </svg>
                    </div>
                    <div onclick="capture()">
                        <svg id="capture" xmlns="http://www.w3.org/2000/svg" height="100px" viewBox="0 -40 480 480" width="100px">
                            <path d="m472 0h-464c-4.417969 0-8 3.582031-8 8v384c0 4.417969 3.582031 8 8 8h464c4.417969 
                            0 8-3.582031 8-8v-384c0-4.417969-3.582031-8-8-8zm-8 384h-448v-368h448zm0 0" fill="#00ccff"/>
                            <path d="m48 48h72v-16h-80c-4.417969 0-8 3.582031-8 8v80h16zm0 0" fill="#00ccff"/>
                            <path d="m40 368h80v-16h-72v-72h-16v80c0 4.417969 3.582031 8 8 8zm0 0" fill="#00ccff"/>
                            <path d="m432 120h16v-80c0-4.417969-3.582031-8-8-8h-80v16h72zm0 0" fill="#00ccff"/>
                            <path d="m432 352h-72v16h80c4.417969 0 8-3.582031 8-8v-80h-16zm0 0" fill="#00ccff"/>
                            <path d="m224 224h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m160 224h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m88 184v32c0 4.417969 3.582031 8 8 8h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8zm16 8h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m288 224h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m288 288h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m352 224h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m224 160h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m224 96h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m224 288h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m160 288h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m160 160h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m288 160h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                            <path d="m224 352h32c4.417969 0 8-3.582031 8-8v-32c0-4.417969-3.582031-8-8-8h-32c-4.417969
                            0-8 3.582031-8 8v32c0 4.417969 3.582031 8 8 8zm8-32h16v16h-16zm0 0" fill="#00ccff"/>
                        </svg>
                    </div>
                    <div onclick="clear1()">
                        <svg id="clear" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" height="80px" width="80px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve">
                            <g>
                                <polygon points="357,35.7 321.3,0 178.5,142.8 35.7,0 0,35.7 142.8,178.5 0,321.3 35.7,357 178.5,214.2 321.3,357 357,321.3 214.2,178.5" fill="#00ccff"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div id="footer">
                    &#169; 2018 Camagru All Rights Reserved.
                </div>
            </div>
        </div>
        <div class="sidebar">
            <p id="sidebar">Previous Snaps</p>
        </div>
    </div>
    <!-- <div id="footer"> -->
                    <!-- &#169; 2018 Camagru All Rights Reserved. -->
                <!-- </div> -->
</body>
</html>