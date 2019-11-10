<?php 

if ($_GET["action"] == "get")  
{
    include_once("config/database.php");
    $conn->query('USE db_camagru');

    $key = $_GET["key"];

	$stmt = $conn->prepare("SELECT confirm_key FROM unconfirmed_users WHERE confirm_key= :confirm_key LIMIT 1");
	$stmt->bindValue(':confirm_key', $key);
    $stmt->execute();
    $result = $stmt->rowCount(); 
    if ($result == 1)
    {   
        $stmt = $conn->prepare("INSERT INTO users (username, email, password)
        SELECT username, email, password
        FROM unconfirmed_users
        WHERE confirm_key= :confirm_key");
        $stmt->bindValue(':confirm_key', $key);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM unconfirmed_users WHERE confirm_key= ?");
        $stmt->execute([$key]);
        header("Refresh: 5; url=login.php"); 
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
    <title>Confirmation</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <p id="warning">Thank you for registering an account. An email has been sent to the email address provided by you with a link to confirm your registration.
                    <script>
                        var ue = "<?php echo $result; ?>";
                        if (ue > 0)
                        {
                            document.getElementById("warning").innerHTML = "Thank you for confirming your account. You will be redirected to the login page in approximately 5 seconds.";
                        }
                    </script>
            </p>
        </div>
    </div>
</body>
</html>