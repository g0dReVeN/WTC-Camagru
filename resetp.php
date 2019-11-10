<?php 

if ($_GET["action"] == "set")  
{
    include_once("config/database.php");
    $conn->query('USE db_camagru');

    $key = $_GET["key"];

	$stmt = $conn->prepare("SELECT reset_key FROM users WHERE reset_key= :reset_key LIMIT 1");
	$stmt->bindValue(':reset_key', $key);
    $stmt->execute();
    $result = $stmt->rowCount(); 
    if ($result == 1)
    {   
        if (isset($_POST["password"]))
        {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users
            SET password= :password, reset_key= NULL
            WHERE reset_key= :reset_key");
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':reset_key', $key);
            $stmt->execute();
            $flag = 1;
            header("Location: preset.php?action=go");
            exit();
        }
    }
    else
    {
        header("Location: index.php");
        exit();
    }
}

?>
<!doctype html>
<html>
<head>
    <title>Change Password</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
    <script src="passMatch.js"></script>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form method="post" action="resetp.php?action=set&key=<?php echo $_GET["key"]; ?>">
                <img class=pic src="img/profile_image.png" alt="pic"/>
                <input name="password" id="p1" type="password" placeholder="new password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"
                                required autocomplete="off"/>
                <input name="password2" id="p2" type="password" placeholder="confirm new password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"
                                onkeyup="passMatch()" required autocomplete="off"/>
                <p id="warning">
                    <script>
                        var ue = "<?php echo $flag; ?>";
                        if (ue > 0)
                        {
                            document.getElementById("warning").innerHTML = "Password successfully changed, you will be now redirected to the login page.";
                        }
                    </script>
                 </p>
                <button>change password</button>
            </form>
        </div>
    </div>
</body>
</html>