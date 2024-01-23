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

    <title>Add New Student</title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new'])) {
            $sql = $conn->query("SELECT id FROM student")->fetchall();
            $id = ($sql[count($sql) - 1]["id"]) + 1;



            $sql = $conn->prepare("INSERT INTO users (email, passwd, picture, type)
            VALUES (:email, :passwd, 'pictures/unknown.png' ,0)");
            $sql->bindParam(':email' , $email);
            $sql->bindParam(':passwd' , $pass);
            $email = "$id"."@us.edu.ye";
            $pass = password_hash("$id", PASSWORD_DEFAULT);
            $sql->execute();

            
            $sql = $conn->prepare("INSERT INTO guardian (name, phone, address)
            VALUES (:gname, :gphone, :address)");
            $sql->bindParam(':gname' , $gname);
            $sql->bindParam(':gphone' , $gphone);
            $sql->bindParam(':address' , $address);
            $gname = $_POST['gname'];
            $gphone = $_POST['gphone'];
            $address = $_POST['address'];
            $sql->execute();

            $sql = $conn->query("SELECT id FROM guardian where phone = '$gphone' ")->fetch();
            $gid = $sql[0];
            $sql = $conn->query("SELECT id FROM users where email = '$email' ")->fetch();
            $user_id = $sql[0];

            // insert to student //
            $sql = $conn->prepare("INSERT INTO student (id,fname, lname, birthday,user_id,state,guardian_id)
            VALUES (:id, :fname, :lname, :birthday,:user_id,1,:guardian_id)");
            $sql->bindParam(':id' , $id);
            $sql->bindParam(':fname' , $fname);
            $sql->bindParam(':lname' , $lname);
            $sql->bindParam(':birthday' , $birthday);
            $sql->bindParam(':user_id' , $user_id);
            $sql->bindParam(':guardian_id' , $gid);
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $birthday = $_POST['birthday'];
            $sql->execute();

            unset($_POST);
            header('Location: index.php');
            exit;
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
            unset($_POST);
            header('Location: index.php');
            exit;
        }
    ?>
    <center><h3 class="head" >New Student</h3></center>
    <form method="post" name="new">
        <div class="form-floating">
            <input type="text" method="post" name="fname" required class="form-control" placeholder="Firstname">
            <label>FirstName </label><br>
        </div>

        <div class="form-floating">
            <input type="text" method="post" name="lname" id="ll" required class="form-control" placeholder="Lastname">
            <label for="ll" >LastName </label><br>
        </div>

        <div class="form-floating">
            <input type="date" name="birthday" method="post" required class="form-control">
            <label>Birthday</label><br>
        </div>

        <fieldset><legend>Guardian info</legend>
        <div class="form-floating">
            <input type="text" method="post" name="gname" required class="form-control" placeholder="Lastname">
            <label>Name</label><br>
        </div>
        <div class="form-floating">
            <input type="number" method="post" maxlength="9" name="gphone" required class="form-control" placeholder="Lastname">
            <label>Phone</label> <br>
        </div>
        <div class="form-floating">
            <input type="text" method="post" name="address" class="form-control" placeholder="Lastname">
            <label>Address</label> <br>
        </div>
        </fieldset>
        <div class="d-grid gap-2">
            <input type="submit" method='post' name="new" value="Add"  class='btn btn-outline-success'>
        </div>
    </form> 
    <form method='post' style="padding: 10px 0px;" >
        <div class="d-grid gap-2">
            <button name='cancel'  method='post' class='btn btn-outline-danger'>Cancel</button>
        </div>
    </form>
</body>
</html>