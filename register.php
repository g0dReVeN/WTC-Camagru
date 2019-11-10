<?php 

if (isset($_POST["username"]))  
{
    include_once("config/database.php");
    $conn->query('USE db_camagru');

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

	$stmt = $conn->prepare("SELECT username FROM users WHERE username= :username OR email= :email LIMIT 1");
	$stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt = $conn->prepare("SELECT username FROM unconfirmed_users WHERE username= :username OR email= :email LIMIT 1");
	$stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result2 = $stmt->rowCount();
    if (($result == 0) && ($result2 == 0))
    {   
        $key = password_hash($username, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO unconfirmed_users (username, email, password, confirm_key) 
        VALUES (:username, :email, :password, :confirm_key)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
        $stmt->bindValue(':confirm_key', $key);
        $stmt->execute();

        $subject = "Camagru - Account Confirmation";
        $message = "Good Day,\r\n
                    This email address was used to register an account at Camagru. If this was not you please ignore this email else please click on the link below to confirm your account:\r\n\n
                    <http://127.0.0.1:8080/camagru/confirmation.php?action=get&key=$key>\r\n\n
                    Email sent by CAMAGRU";
        $headers = "From: no-reply@localhost\r\n".
                    "X-Mailer:PHP/".phpversion();

        $result = mail($email, $subject, $message, $headers);

        header("location: confirmation.php");
        exit();
    }
}

?>

<!doctype html>
<html>
<head>
    <title>Register</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
    <script src="passMatch.js"></script>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form method="post" action="register.php">
                <img class=pic src="img/profile_image.png" alt="pic"/>
                <input name="username" type="text" placeholder="username" minlength="6" maxlength="12" 
                                pattern="^[A-Za-z]+([A-Za-z0-9_\.]+)*$"
                                title="Must start with an alphabet. Numbers (0-9), hyphens (-) & decimal points (.) after are accepted. Example: joe-007."
                                value="<?php echo $username; ?>" required/>
                <input name="email" type="email" placeholder="email address" minlength="6" maxlength="64"
                                pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                                title="Example: joe@gmail.com"
                                value="<?php echo $email; ?>" required/>
                <input name="password" id="p1" type="password" placeholder="password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"
                                required autocomplete="off"/>
                <input name="password2" id="p2" type="password" placeholder="confirm password" minlength="6" maxlength="16"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,16}$"
                                title="Minimum (6) and maximum (16) characters, at least (1) uppercase letter, (1) lowercase letter, (1) number & (1) special character (@$!%*?&)"
                                onkeyup="passMatch()" required autocomplete="off"/>
                <p id="warning">
                    <script>
                        var ue = "<?php echo $result; ?>";
                        var ue2 = "<?php echo $result2; ?>";
                        if ((ue > 0) || (ue2 > 0))
                        {
                            document.getElementById("warning").style.color = "red";
                            document.getElementById("warning").innerHTML = "Username and/or email address taken/in use.";
                        }
                    </script>
                </p>
                <button id="d_button" name="button" type="submit" disabled>register</button>
                <p class="message">Already registered? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>