<?php 

session_start();

if (isset($_SESSION["username"])) 
{
	header("location: index.php"); 
	exit();
}

if (isset($_POST["username"]) && isset($_POST["password"])) 
{
	include_once("config/database.php");
	$conn->query('USE db_camagru');

	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$stmt = $conn->prepare("SELECT password, propic FROM users WHERE username= :username LIMIT 1");
	$stmt->bindValue(':username', $username);
    $stmt->execute();

	$result = $stmt->rowCount(); 
	if ($result == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if (password_verify($password, $row["password"])) 
		{
			$_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            if ($row["propic"] != "")
                $_SESSION["propic"] = $row["propic"];
            else
                $_SESSION["propic"] = "img/profile_image.png";
			header("location: index.php");
			exit();
		}
		else
			$flag = 2;
	} 
	else     
		$flag = 1;
}

?>

<!doctype html>
<html>
<head>
    <title>Login</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form method="post" action="login.php">
                <img class=pic src="img/profile_image.png" alt="pic"/>
                <input name="username" type="text" placeholder="username" maxlength="12" value="<?php echo $username; ?>" required/>
                <input name="password" type="password" placeholder="password" maxlength="16" value="<?php echo $password; ?>" required/>
				<p id="warning">
                    <script>
                        var flag = "<?php echo $flag; ?>";
                        if (flag == 1)
                        {
                            document.getElementById("warning").style.color = "red";
                            document.getElementById("warning").innerHTML = "Username not found.";
						}
						else if (flag == 2)
                        {
                            document.getElementById("warning").style.color = "red";
                            document.getElementById("warning").innerHTML = "Invalid password.";
                        }
                    </script>
                </p>
                <button name="button" type="submit">login</button>
                <p class="message">Forgot password? <a href="forgotp.php">Reset password</a></p>
                <p class="message">Not registered? <a href="register.php">Register an account</a></p>
            </form>
        </div>
    </div>
</body>
</html>