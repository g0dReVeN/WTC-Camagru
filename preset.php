<?php

if ($_GET["action"] == "go")  
    header("Refresh:5; url=index.php");

?>

<!doctype html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" type="text/css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form>
                <p id="warning">An email has been sent to your registered email address with a link to reset your password.
                    <script>
                        var ue = "<?php if($_GET["action"] == "go"){echo "1";} ?>";
                        if (ue > 0)
                        {
                            document.getElementById("warning").innerHTML = "Password successfully changed, you will be now redirected to the login page.";
                        }
                    </script>
                </p>
            </form>
        </div>
    </div>
</body>
</html>