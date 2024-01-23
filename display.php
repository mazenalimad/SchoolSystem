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
                echo "Students";
            else
                echo "Teachers";
        ?>
    </title>
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
</head>
<body>
    <?php
        if($type == '1'){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['delete'])){
                    $delete =$_POST['delete'];
                    $uid = $conn->query("SELECT user_id from student where id = '$delete'")->fetch();
                    $uid = $uid['user_id'];
                    $gid = $conn->query("SELECT guardian_id from student where id = '$delete'")->fetch();
                    $gid = $gid['guardian_id'];
                    $sql = $conn->query("DELETE FROM student WHERE id='$delete'");
                    $sql = $conn->query("DELETE FROM users WHERE id=('$uid')");
                    $sql = $conn->query("DELETE FROM guardian WHERE id='$gid'");
                    unset($_POST);
                    header("Location: ".$_SERVER['PHP_SELF'] ."?type=1");
                }
                else if(isset($_POST['edit'])){
                    header('Location: edit.php?id=' . $_POST['edit'] . "&type=1");
                }
                else if(isset($_POST['add'])){
                    unset($_POST);
                    header('Location: add.php');
                }
            }
        }
        else if($type == 0){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['delete'])){
                    $delete = $_POST['delete'];
                    $sql = $conn->query("DELETE FROM staff WHERE id='$delete'");
                    unset($_POST);
                    header("Location: ".$_SERVER['PHP_SELF'] ."?type=0");
                }
                else if(isset($_POST['edit'])){
                    header('Location: edit.php?id=' . $_POST['edit'] . "&type=0");
                }
                else if(isset($_POST['add'])){
                    unset($_POST);
                    header('Location: add.php');
                }
            }
        }
        else{
            unset($_GET);
            header('Location: Not Found.php');
            exit;
        }
    ?>
    <br><br><br><br><br>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover " id="dataTables-example">
                    <thead style="background-color: darkcyan;">
                        <tr>
                            <th style=" text-align: center;" ><i class="fa fa-users"></i>
                                            <?php
                                            if($type == 1)
                                                echo "Students";
                                            else
                                                echo "Teachers";
                                            ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>          
                                <form method='post'>
                                    <div class="d-grid gap-2">
                                        <button name='add' method='post' value='$id' class='btn btn-outline-success'>
                                            <?php
                                            if($type == 1)
                                                echo "Add New Student";
                                            else
                                                echo "Add New Teacher";
                                            ?>
                                            
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-hover " id="dataTables-example" >
                    
                    <thead>
                        <tr>
                            <?php
                            if($type == 1)
                                echo "
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Guardian Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Edit / Delete</th>
                                    <th>Statues</th>
                                ";
                            else{
                                echo "
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Educational Level</th>
                                <th>Staff Type</th>
                                <th>Salary</th>
                                <th>Edit / Delete</th>
                                ";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            if($type == 1){
                                $sql = $conn->query("SELECT id,fname,lname,state from student")->fetchAll();
                                foreach($sql as $row){
                                    $id = $row['id'];
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                                    $state = $row['state'];
                                    echo "
                                        <tr class='odd gradeX'>
                                            <td style='width : 1%; text-align: center; ' >$i</td>";
                                            $query = $conn->query("SELECT picture from users where id = (SELECT user_id from student where id = '$id')")->fetch();
                                            $picture = $query['picture'];
                                            echo "
                                            <td style='width : 5%'>
                                                <img class='circle-img rounded-circle' style='width: 60px; height: 60px; object-fit: cover;' alt='pc' src='$picture' />
                                            </td>
                                            <td style=''>$fname $lname</td>";
                                            $query = $conn->query("SELECT name,phone,address from guardian where id = (SELECT guardian_id from student where id = '$id')")->fetch();
                                            $gname = $query['name'];
                                            $phone = $query['phone'];
                                            $address = $query['address'];
                                            echo "
                                            <td>$gname</td>
                                            <td>$phone</td>
                                            <td>$address</td>
                                            <td style ='width : 15%; text-align: center;'>
                                                <form method='post' action='?type=$type'>
                                                    <button name='edit' method='post' value='$id' class='btn btn-outline-info'>Edit</button>
                                                    <button name='delete'  method='post' value='$id' class='btn btn-outline-danger'>Delete</button>
                                                </form>";
                                                
                                            echo "</td>
                                            <td style='width : 5%;  text-align: center;'>";
                                                if($state == 0){
                                                    echo "<a class='btn btn-danger' style='cursor:default;'>Suspended</a>";
                                                }
                                                else if($state == 1){
                                                    echo "<a class='btn btn-success' style='cursor:default;'>Attended</a>";
                                                }
                                                else{
                                                    echo "<a class='btn btn-warning' style='cursor:default;'>Absent</a>";
                                                }
                                            echo "</td>
                                        </tr>";
                                    $i++;
                                }
                            }
                            else {
                                $sql = $conn->query("SELECT id,fname,lname,phone,address,salary,type,Educational_level from staff")->fetchAll();
                                foreach($sql as $row){
                                    $id = $row['id'];
                                    $edu = $row['Educational_level'];
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                                    $phone = $row['phone'];
                                    $address = $row['address'];
                                    $type = $row['type'];
                                    $salary = $row['salary'];
                                    echo "
                                        <tr class='odd gradeX'>
                                            <td style='width : 1%; text-align: center; ' >$i</td>
                                            <td style=''>$fname $lname</td>
                                            <td><center>$phone</center></td>
                                            <td><center>$address</center></td>
                                            <td><center>";
                                                if($edu == 1)
                                                    echo "Bachelor's";
                                                else if($edu == 2)
                                                    echo "Master's";
                                                else if($edu == 3)
                                                    echo "Ph.D";
                                                else if($edu == 4)
                                                    echo "Prof";
                                                else
                                                    echo "None";
                                            echo "</center></td>
                                            <td><center>";
                                                if($type == 1)
                                                    echo "Manager";
                                                else if($type == 2)
                                                    echo "Assistant Mangaer";
                                                else if($type == 3)
                                                    echo "Secretary";
                                                else if($type == 4)
                                                    echo "Agent";
                                                else if($type == 5)
                                                    echo "Accountant";
                                                else if($type == 6)
                                                    echo "Teacher";
                                                else if($type == 7)
                                                    echo "Security";
                                                else if($type == 8)
                                                    echo "Cleaner";
                                                else if($type == 9)
                                                    echo "Social Speciallist";
                                                else
                                                    echo "None";
                                            echo "
                                            </center></td>
                                            <td><center>$salary</center></td>
                                            <td style ='width : 15%; text-align: center;'>
                                                <form method='post' action='?'>
                                                    <button name='edit' method='post' value='$id' class='btn btn-outline-info'>Edit</button>
                                                    <button name='delete'  method='post' value='$id' class='btn btn-outline-danger'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>";
                                    $i++;
                                }

                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
        
</body>
</html>