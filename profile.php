<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include('libraries.php');
        session_start();
        if(!isset($_SESSION['user']) || $_SESSION['type']!=0){
            header("location:login.php");
        }
        require_once('dbconnect.php');
    ?>
    
    <link rel="icon" href="Pictures/img.jpg" type="image/x-icon"/>
    <title>Profile</title>
</head>
<body>
    <?php
        if(isset($_GET['pi'])){
            if($_GET['pi'] == 0){
                $msg = "<span style='font-size: small;color: green;font-weight: bold;'>Profile Picture has been Reset Successfully</span>";
            }
            else if($_GET['pi'] == 1){
                $msg = "<span style='font-size: small;color: green;font-weight: bold;'>Profile Picture has been Update Successfully</span>";
            }
        }
        $email = $_SESSION['user'];
        $sql = $conn->query("SELECT picture from users where email = '$email'")->fetch();
        $pic = $sql['picture'];
        $sql = $conn->query("SELECT id,fname,lname,birthday from student where user_id = (Select id from users where email = '$email')")->fetch();
        $id = $sql['id'];
        $fname = $sql['fname'];
        $lname = $sql['lname'];
        $birthday = $sql['birthday'];
        echo "
            <center>
            <img class='circle-img rounded-circle' style='margin-top: 20px; width: 150px; height: 150px; object-fit: cover;' alt='pc' src='$pic' />
            </center>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['logout'])){
                header('Location: sessionEnd.php');
            }
            if(isset($_POST['reset'])){
                if($pic != 'Pictures/unknown.png')
                    unlink($pic);
                $sql = $conn->query("UPDATE users SET picture = 'Pictures/unknown.png' where email = '$email'");
                unset($_POST);
                header('Location: '.$_SERVER['PHP_SELF'].'?pi=0');
                
            }
            else{
                $size = $_FILES['fileToUpload']['size'];
                if($size > 2097152){
                    $err = "<span style='font-size: small;color: rgb(169, 0, 0);font-weight: bold;>Must Be lower the 2MB</span>";
                }
                else{
                    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                    $check =  strtolower(end($temp));
                    if($check == "jpg" || $check == "png" || $check == "jpeg"){
                        if($pic != 'Pictures/unknown.png')
                            unlink($pic);
                        $newfilename = "Pictures/".date('h_i_s_a_d_m_Y', time()) . '.' . end($temp);
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename);
                        $sql = $conn->query("UPDATE users SET picture = '$newfilename' where email = '$email'");
                        unset($_POST);
                        header('Location: '.$_SERVER['PHP_SELF'].'?pi=1');
                    }
                    else{
                        $err = "<span style='font-size: small;color: rgb(169, 0, 0);font-weight: bold;'>Sorry, only JPG, JPEG & PNG files are allowed ..</span>";
                    }
                    
                }
            }
        }
        
    ?>
    <form method="post" enctype="multipart/form-data"><br>
    <!-- <input type='text' style="font-weight: bold;" value='$id' readonly> -->

        <center>
            <?php echo "
            <input type='text'
                style='
                    text-align: center;
                    font-weight: bold;
                    outline: none;
                    border: none;
                    '
                value='$fname $lname' 
            readonly><br>
            <input type='text'
                style='
                    text-align: center;
                    outline: none;
                    color : grey;
                    border: none;
                    font-size : small;
                '
                value='$id'
            readonly><br>
            <br>";?>
            <input type="file" id="pic" name="fileToUpload" hidden>
            <label for="pic" class='btn btn-info' style="margin-bottom: 10px;" >Change Pofile Picture</label>
        <br>
        <input type="submit" value="Upload Image" name="submit">
        <input type="submit" value="Reset image" name='reset'><br>
        <?php
            if(isset($err)){
                echo $err;
            }
            else if(isset($msg)){
                echo $msg;
            }
            ?>
        </center>

        <?php
            $sql = $conn->query("SELECT subject_id,degree from degrees where student_id = $id")->fetchAll();
            foreach($sql as $row){
                $sub_id = $row['subject_id'];
                $subject = $conn->query("SELECT subject,term,lvl from subjects where id = $sub_id")->fetch();
                if($subject['lvl'] != 1){
                    continue;
                }
                echo $subject['subject']."   ".$subject['term']."   ".$row['degree']."<br>";
            }
        ?>
</form>
<form method="post" action="">
    <input type="submit" name="logout" value="Logout">
</form>
</body>
</html>