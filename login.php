<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        include('libraries.php');
        //setcookie("style","color",strtotime("+1 month"));
        //var_dump($_COOKIE);
    ?>

    <title>Login</title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php
        require_once('dbconnect.php');
    ?>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $pass = $_POST['pass'];

            $sql = $conn->prepare("SELECT id,passwd,type FROM users where email = :email");
            $sql->execute(array("email"=>$email));
            $sql = $sql->fetch();

            if (empty($sql)) {
                echo "Not found User";
            }else{
                if(password_verify($pass, $sql["passwd"])){
                    if($sql['type']){
                        $_SESSION['user'] = $email;
                        $_SESSION['type'] = 1;
                        header('Location: dashboard.php');
                    }else{  
                        $_SESSION['user'] = $email;
                        $_SESSION['type'] = 0;
                        header("Location: profile.php");
                        //echo $_SESSION['user'];
                    }
                }
                else{
                    echo "Login Failed... Something Wrong";
                }
            }
        }
    ?>

    <form method="post" name="new">
        <label>Email </label><br>
        <input type="email" method="post" name="email" required><br>

        <label>Password </label><br>
        <input type="password" method="post" name="pass" required><br>

        <br><input type="submit" name="new">
    </form>
</body>
</html>