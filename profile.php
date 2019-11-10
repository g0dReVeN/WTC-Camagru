<?php 

session_start();
include_once("config/database.php");
$conn->query('USE db_camagru');

$stmt = $conn->prepare("SELECT email, notice FROM users WHERE username= :username LIMIT 1");
$stmt->bindValue(':username', $_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html>
<head>
    <title>My Profile</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="main.css" type="text/css">
    <script src="getProfile.js"></script>
</head>
<body onload="getData('<?php echo $_SESSION['username']; ?>')">
    <?php include_once("header.php"); ?>
    <div class="container2">
        <div class="subhead">ACCOUNT DETAILS</div>
        <div class="form">
            <form id="table" onsubmit="event.preventDefault(); update();">
                <table>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow" id="warn1"></td>
                    </tr>
                    <tr>
                        <td class="tdata">Username</td>
                        <td class="tdata"><input id="username" name="username" type="text" placeholder="username" minlength="6" maxlength="12" 
                            pattern="^[A-Za-z]+([A-Za-z0-9_\.]+)*$"
                            title="Must start with an alphabet. Numbers (0-9), hyphens (-) & decimal points (.) after are accepted. Example: joe-007."value="" 
                            required/>
                        </td>
                    </tr>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow" id="warn2"></td>
                    </tr>
                    <tr>
                        <td class="tdata">Email Address</td>
                        <td class="tdata"><input id="email" name="email" type="email" placeholder="email address" minlength="6" maxlength="64" 
                            pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                            title="Example: joe@gmail.com"value="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow" id="warn3"></td>
                    </tr>
                    <tr>
                        <td class="tdata">Current Password</td>
                        <td class="tdata"><input id="p0" name="cpassword" type="password" placeholder="password" minlength="6" maxlength="16"
                            title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)" 
                            required onkeyup="passMatch()">
                        </td>
                    </tr>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow"></td>
                    </tr>
                    <tr>
                        <td class="tdata">New Password</td>
                        <td class="tdata"><input id="p1" name="npassword" type="password" placeholder="new password" minlength="6" maxlength="16"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                            title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)" 
                            onkeyup="passMatch()"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow" id="warn4"></td>
                    </tr>
                    <tr>
                        <td class="tdata">Confirm New Password</td>
                        <td class="tdata"><input id="p2" type="password" placeholder="confirm new password" minlength="6" maxlength="16"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                            title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)" 
                            onkeyup="passMatch()"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdata">Notifications</td>
                        <td class="tdata" style="padding-left: 170px;">
                            <label><input id="yes" type="radio" value="1" name="notice"/>Yes</label>
                            <label><input id="no" type="radio" value="0" name="notice"/>No</label>
                        </td>           
                    </tr>
                    <tr>
                        <td class="tdata">Profile Picture</td>
                        <td style="padding-left: 30px;">
                            <img id="pic" src="" onclick="filer()"/>
                            <input name="propic" id="propic" type="hidden" value=""/>
                            <input type="file" id="fileElem" multiple accept="image/*" style="display:none" onchange="previewFile()">
                        </td>           
                    </tr>
                    <tr>
                        <td class="trow"></td>
                        <td class="trow"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input id="button1" type="submit" value="EDIT"/>
                        </td>           
                    </tr>
                    <tr>
                        <td style="height: 100px;"></td>
                    </tr>
                </table>
            </form>
            <div id="footer">
                &#169; 2018 Camagru All Rights Reserved.
            </div>
        </div>
    </div>
</body>
</html>