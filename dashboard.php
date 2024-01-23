<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        if(!isset($_SESSION['user']) || $_SESSION['type']!=1){
            header("location:login.php");
        }
        require_once('dbconnect.php');
        include('libraries.php');
    ?>

    <title>Students</title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
           header("Location: display.php" . "?type=" . $_POST['type']);
        }
    ?>
    
    <form method='post'>
        <button name='type' method='post' value='0' class='btn btn-info'>Teacher</button>
        <button name='type'  method='post' value='1' class='btn btn-warning'>Student</button>
    </form>
        
</body>
</html>