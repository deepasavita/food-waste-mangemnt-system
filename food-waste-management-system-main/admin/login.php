<?php
include '../connection.php';
$acc=0;
$msg=0;

if(isset($_POST['signup']))
{
    $username=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $location=$_POST['district'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from admin where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);

    if($num==1){
        $acc=1;
    }
    else{
        $query="insert into admin(name,email,password,location) values('$username','$email','$pass','$location')";
        $query_run= mysqli_query($connection, $query);
        if(!$query_run){
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Login</title>
</head>
<body>

<div class="container">
    <div class="forms">
        <div class="form login">
            <?php
            if($msg==1){
                echo '<p ><center style="color:#06C167;">Incorrect Password</center></p>';
            }
            if($acc==1){
                echo '<p ><center style="color:crimson;">Account already exists</center></p>';
            }
            ?>
            <span class="title">Login</span>
            <form action="" method="post">
                <div class="input-field">
                    <input type="text" placeholder="Enter your email" name="email" required>
                    <i class="uil uil-envelope icon"></i>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class="uil uil-lock icon"></i>
                </div>
                <div class="input-field button">
                    <button type="submit" name="Login">Login</button>
                </div>
            </form>
            <div class="login-signup">
                <span class="text">Not a member?
                    <a href="#" class="text signup-link">Signup Now</a>
                </span>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="form signup">
            <span class="title">Registration</span>
            <form action="" method="post">
                <div class="input-field">
                    <input type="text" placeholder="Enter your name" name="name" required>
                    <i class="uil uil-user"></i>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Enter your email" name="email" required>
                    <i class="uil uil-envelope icon"></i>
                </div>
                <div class="input-field">
                    <select id="district" name="district" style="padding:10px; padding-left: 20px;">
                        <option value="mumbai-city">Mumbai City</option>
                        <option value="mumbai-suburban">Mumbai Suburban</option>
                        <option value="thane">Thane</option>
                        <option value="navi-mumbai">Navi Mumbai</option>
                        <option value="kalyan-dombivli">Kalyan-Dombivli</option>
                        <option value="vasai-virar">Vasai-Virar</option>
                    </select> 
                    <i class="uil uil-map-marker icon"></i>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Confirm Password" required>
                    <i class="uil uil-lock icon"></i>
                </div>
                <div class="input-field button">
                    <button type="submit" name="signup">Signup</button>
                </div>
            </form>
            <div class="login-signup">
                <span class="text">Already a member?
                    <a href="#" class="text login-link">Login Now</a>
                </span>
            </div>
        </div>
    </div>
</div>

<script src="login.js"></script>
</body>
</html>

<?php
$msg=0;
if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    $sql = "select * from admin where email='$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['location'] = $row['location'];
                header("location:admin.php");
            } else {
                $msg=1;
            }
        }
    } else {
        echo "<h1><center>Account does not exist</center></h1>";
    }
}
?>
