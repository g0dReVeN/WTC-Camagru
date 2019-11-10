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
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="container2">
        <section class="pmain">
            <div class="form">
                <img class=pic src="img/profile_image.png" alt="pic"/>
            </div>
            <div class="form">
                <form method="post" action="profile.php">
                    <table class="table">
                        <tr>
                            <td class="td">Username</td>
                            <td class="td"><p id="warn1"></p><input name="username" type="text" placeholder="username" minlength="6" maxlength="12" value="<?php echo $_SESSION["username"]; ?>" required/></td>
                        </tr>
                        <tr>
                            <td class="td">Email Address</td>
                            <td class="td"><p id="warn2"></p><input name="email" type="email" placeholder="email address" minlength="6" maxlength="64" value="<?php echo $result["email"] ?>" required/></td>
                        </tr>
                        <tr>
                            <td class="td">New Password</td>
                            <td class="td"><p id="warn3"></p><input name="password" type="password" placeholder="password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"/></td>
                        </tr>
                        <tr>
                            <td class="td">Confirm New Password</td>
                            <td class="td"><p></p><input name="password2" type="password" placeholder="confirm password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"/></td>
                        </tr>
                        <tr>
                            <td class="td">Notifications</td>
                            <td class="td">
                                <label><input type="radio" name="noti" value="yes" checked="checked"/>Yes</label>
                                <label><input type="radio" name="noti" value="no" checked="checked"/>No</label>
                            </td>           
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button  name="button" type="submit">edit</button>
                            </td>           
                        </tr>
                    </table>
                </form>
                
            </div>
        </section>
    </div>
    <div style="clear:both;"></div>
    <?php include_once("footer.php"); ?>
</body>
</html>