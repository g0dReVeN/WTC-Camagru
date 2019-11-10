<?php 

if (isset($_POST["email"]))  
{
    include_once("config/database.php");
    $conn->query('USE db_camagru');

    $email = $_POST["email"];
    
	$stmt = $conn->prepare("SELECT email FROM users WHERE email= :email LIMIT 1");
	$stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1)
    {   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $key = password_hash($result["email"], PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users 
        SET reset_key= :reset_key
        WHERE email= :email");
        $stmt->bindValue(':reset_key', $key);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        echo "dsad3";

        $subject = "Camagru - Password Reset";
        $message = "Good Day,\r\n
                    A password reset was requested by the account linked to this email address. If this was not you please ignore this email else please click on the link below to reset your password:\r\n\n
                    <http://127.0.0.1:8080/camagru/resetp.php?action=set&key=$key>\r\n\n
                    Email sent by CAMAGRU";
        $headers = "From: no-reply@localhost\r\n".
                    "X-Mailer:PHP/".phpversion();

        $result = mail($email, $subject, $message, $headers);

        header("location: preset.php");
        exit();
    }
}

?>

<!doctype html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form method="post" action="forgotp.php">
                <img class=pic src="img/profile_image.png" alt="pic"/>
                <input name="email" type="email" placeholder="email address" minlength="6" maxlength="64"
                                pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                                title="Example: joe@gmail.com" required/>
                <button>reset password</button>
                <p class="message">Remember your password? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>