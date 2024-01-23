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
        $type = $_GET['type'];
    ?>

    <title>
        <?php 
            if($type == 1)
                echo "Edit Student Information";
            else
                echo "Edit Teachers Information";
        ?>
    </title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php
        $id = $_GET['id'];
        if($type == 1){
            $sql = $conn->query("SELECT s.fname,s.lname,s.birthday,s.state,g.name,g.phone,g.address from student s , guardian g
            where s.id = $id AND g.id = (SELECT guardian_id from student where id = $id)")->fetch();
            if(!empty($sql)){
                $fname = $sql['fname'];
                $lname = $sql['lname'];
                $birthday = $sql['birthday'];
                $state = $sql['state'];
                $gname = $sql['name'];
                $phone = $sql['phone'];
                $address = $sql['address'];
            }
            else{
                unset($_GET);
                header('Location: display.php?type=1');
                exit;
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['save'])){
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];;
                    $birthday = $_POST['birthday'];;
                    $state = $_POST['state'];
                    $gname = $_POST['gname'];;
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    //Update Student Table
                    $sql = $conn->prepare("UPDATE student SET fname = :fname , lname = :lname , birthday = :birthday , state = :state 
                    where id = :id");
                    $sql->bindParam(":fname", $fname);
                    $sql->bindParam(":lname", $lname);
                    $sql->bindParam(":birthday", $birthday);
                    $sql->bindParam(":state", $state);
                    $sql->bindParam(":id", $id);
                    $sql->execute();
                    //Update Student Table
                    $sql = $conn->prepare("UPDATE guardian SET name = :name , phone = :phone , address = :address 
                    where id = (SELECT guardian_id from student where id = :id)");
                    $sql->bindParam(":name", $gname);
                    $sql->bindParam(":phone", $phone);
                    $sql->bindParam(":address", $address);
                    $sql->bindParam(":id", $id);
                    $sql->execute();
                }
                unset($_POST);
                header('Location: display.php?type=1');
                exit;
            }
        }
        else if($type == 0){
            $sql = $conn->query("SELECT fname,lname,phone,address,salary,type,Educational_level from staff where id = $id")->fetch();
            if(!empty($sql)){
                $fname = $sql['fname'];
                $lname = $sql['lname'];
                $edu = $sql['Educational_level'];
                $typeof = $sql['type'];
                $salary = $sql['salary'];
                $phone = $sql['phone'];
                $address = $sql['address'];
            }
            else{
                unset($_GET);
                header('Location: display.php?type=0');
                exit;
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['save'])){
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $edu = $_POST['edu'];
                    $typeof = $_POST['type'];
                    $salary = $_POST['salary'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    //Update Student Table
                    $sql = $conn->prepare("UPDATE staff SET fname = :fname , lname = :lname , phone = :phone ,
                    address = :address , salary = :salary ,type = :type , Educational_level = :edu
                    where id = :id");
                    $sql->bindParam(":fname", $fname);
                    $sql->bindParam(":lname", $lname);
                    $sql->bindParam(":phone", $phone);
                    $sql->bindParam(":address", $address);
                    $sql->bindParam(":type", $typeof);
                    $sql->bindParam(":edu", $edu);
                    $sql->bindParam(":salary", $salary);
                    $sql->bindParam(":id", $id);
                    $sql->execute();
                }
                unset($_POST);
                header('Location: display.php?type=0');
                exit;
            }
        }
        else{
            header("Location: Not Found.php");
        }
    ?>
    <center><h3 class="head" >Edit</h3></center>
    <form method='post'>
        
        <?php
            if($type == 1){
                echo "
                    <div class='form-floating'>
                        <input type='text' name='fname' value='$fname' method='post' class='form-control' placeholder='Firstname' required>
                        <label>Firstname</label>
                    </div><br>
                    <div class='form-floating'>
                        <input type='text' name='lname' value='$lname' method='post' class='form-control' placeholder='lastname' required>
                        <label>LastName</label>
                    </div><br>
                    <div class='form-floating'>
                        <input type='date' name='birthday' value='$birthday' method='post' class='form-control' required>
                        <label>Birthday</label>
                    </div><br>
                    <div class='input-group mb-3'>
                    <label class='input-group-text' for='State'>Statues</label>
                    <select name='state' method='post' class='form-select' id='State'>
                        <option value='0'"; if($state == 0) echo " selected";
                        echo ">Suspended</option>
                        <option value='1'"; if($state == 1) echo " selected";
                        echo ">Attended</option>
                        <option value='2'"; if($state == 2) echo " selected";
                        echo ">Absent</option>
                    </select>
                    </div>
                    
                    <fieldset><legend>Guardian info</legend>
                        <div class='form-floating'>
                        <input type='text' method='post' name='gname'  value='$gname' required class='form-control' placeholder='Firstname'>
                        <label>Name</label>
                        </div><br>
                        <div class='form-floating'>
                        <input type='number' method='post' name='phone' value='$phone' required class='form-control' placeholder='Firstname'>
                        <label>Phone</label>
                        </div><br>
                        <div class='form-floating'>
                        <input type='text' method='post' name='address' value='$address' class='form-control' placeholder='Firstname'>
                        <label>Address</label>
                        </div><br>
                    </fieldset>";
            }
            else if($type == 0){
                echo "
                    <div class='form-floating'>
                        <input type='text' name='fname' value='$fname' method='post' class='form-control' placeholder='Firstname' required>
                        <label>Firstname</label>
                    </div><br>
                    <div class='form-floating'>
                        <input type='text' name='lname' value='$lname' method='post' class='form-control' placeholder='lastname' required>
                        <label>LastName</label>
                    </div><br>
                    <div class='form-floating'>
                        <input type='number' method='post' name='phone' value='$phone' required class='form-control' placeholder='Firstname'>
                        <label>Phone</label>
                    </div><br>
                    <div class='form-floating'>
                        <input type='text' method='post' name='address' value='$address' class='form-control' placeholder='Firstname'>
                        <label>Address</label>
                    </div><br>
                    <div class='input-group mb-3'>
                    <label class='input-group-text' for='edu'>Educational Level</label>
                    <select name='edu' method='post' class='form-select' id='State'>
                        <option value='1'"; if($edu == 1) echo " selected";
                        echo ">Bachelor's</option>
                        <option value='2'"; if($edu == 2) echo " selected";
                        echo ">Master's</option>
                        <option value='3'"; if($edu == 3) echo " selected";
                        echo ">Ph.D</option>
                        <option value='4'"; if($edu == 4) echo " selected";
                        echo ">Prof</option>
                    </select>
                    </div>
                    <div class='input-group mb-3'>
                    <label class='input-group-text' for='type'>Staff Type</label>
                    <select name='type' method='post' class='form-select' id='State'>
                        <option value='1'"; if($typeof == 1) echo " selected";
                        echo ">Manager</option>
                        <option value='2'"; if($typeof == 2) echo " selected";
                        echo ">Assistant Mangaer</option>
                        <option value='3'"; if($typeof == 3) echo " selected";
                        echo ">Secretary</option>
                        <option value='4'"; if($typeof == 4) echo " selected";
                        echo ">Agent</option>
                        <option value='5'"; if($typeof == 5) echo " selected";
                        echo ">Accountant</option>
                        <option value='6'"; if($typeof == 6) echo " selected";
                        echo ">Teacher</option>
                        <option value='7'"; if($typeof == 7) echo " selected";
                        echo ">Security</option>
                        <option value='8'"; if($typeof == 8) echo " selected";
                        echo ">Cleaner</option>
                        <option value='9'"; if($typeof == 9) echo " selected";
                        echo ">Social Speciallist</option>
                    </select>
                    </div>
                    <div class='form-floating'>
                        <input type='number' method='post' name='salary' value='$salary' required class='form-control' placeholder='Firstname'>
                        <label>Salary</label>
                    </div><br>
                    ";
            }
                    
                ?>
                <div class="d-grid gap-2">
                    <input type="submit" method='post' name="save" class='btn btn-outline-success' value="Save Changes">
                </div>
    </form>
    <form method='post'>
        <div style="padding: 10px 0px;" class="d-grid gap-2">
            <button name='cancel' method='post' class='btn btn-outline-danger'>Cancel</button>
        </div>
    </form>
</body>
</html>