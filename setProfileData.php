<?php 

include_once("config/database.php");
$conn->query('USE db_camagru');

session_start();
//echo "7";
if ($_POST["cpassword"]) 
{
    //echo "6";
    $flag = array(0, 0, 0);
	$username = $_SESSION["username"];
	$password = $_POST["cpassword"];
	
	$stmt = $conn->prepare("SELECT password FROM users WHERE username= :username");
	$stmt->bindValue(':username', $username);
    $stmt->execute();

    //echo "65";
    $password2 = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $password2["password"])) 
    {
        //echo "4";
        $stmt = $conn->prepare("SELECT email FROM users WHERE username= :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $email = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $email["email"];

        if ($username != $_POST["username"])
        {
            //echo "3";
            $stmt = $conn->prepare("SELECT username FROM users WHERE username= :username");
            $stmt->bindValue(':username', $_POST["username"]);
            $stmt->execute();
            if ($stmt->rowCount() > 0)
                $flag[1] = 1;
        }

        if ($email != $_POST["email"])
        {
            //echo "333";
            $stmt = $conn->prepare("SELECT username FROM users WHERE email= :email");
            $stmt->bindValue(':email', $_POST["email"]);
            $stmt->execute();
            if ($stmt->rowCount() > 0)
                $flag[2] = 1;
        }

        if ($flag[1] == 0 && $flag[2] == 0)
        {
            //echo "22";
            $data = array();
            $stmt = $conn->prepare("SELECT username, email, `password`, notice, propic FROM users WHERE username= :username");
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $data["username"] = $_POST["username"];
            $data["email"] = $_POST["email"];
            $data["password"] = $password2["password"];
            if ($_POST["npassword"] != "")
                $data["password"] = password_hash($_POST["npassword"], PASSWORD_BCRYPT);
            $data["notice"] = $_POST["notice"];
            $data["propic"] = NULL;
            if ($_POST["propic"] != "")
                $data["propic"] = $_POST["propic"];
            //print_r($data);
            /*$stmt = $conn->prepare("UPDATE users SET username= :username, email= :email, `password`= :password, notice= :notice, propic= :propic WHERE username=$username");
            $stmt->execute($data);
            echo "25";
            $_SESSION["username"] = $data["username"];*/
            $stmt = $conn->prepare("UPDATE users SET username= :username, email= :email, password= :password, notice= :notice, propic= :propic WHERE username= :username1");
            //$stmt->bindValue(':username', $data["username"]);
            $stmt->bindValue(':username', $data["username"]);
            $stmt->bindValue(':email', $data["email"]);
            $stmt->bindValue(':password', $data["password"]);
            $stmt->bindValue(':notice', $data["notice"]);
            $stmt->bindValue(':propic', $data["propic"]);
            $stmt->bindValue(':username1', $username);
            $stmt->execute();
            $_SESSION["username"] = $data["username"];
        }
    }
    else
        $flag[0] = 1;
}
//echo $_SESSION["username"];
//$flag[0] = 1;
echo $flag[0] . ";" . $flag[1] . ";" . $flag[2] . ";" . $_SESSION["username"];

?>