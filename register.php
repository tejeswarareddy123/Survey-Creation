<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="index.css">
  <title>Registration Page</title>
</head> 
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="POST">
                    <h2>Registration</h2>
                    <div class="inputbox">
                        <input type="text" required>
                        <label for="">Enter your name</label>
                    </div>
					<div class="inputbox">
                        <input type="text" name="email" required>
                        <label for="">Enter your email</label>
                    </div>
                    <div class="inputbox">
                        <input type="password" name="pass" class="password" required>
                        <label for="">Enter your Password</label>
                    </div>
					<div class="inputbox">
                        <input type="password" class="password" required>
                        <label for="">Confirm Password</label>
                    </div>
                    <input class="login" type="submit" value="Register" name="submit">
                   
                </form>
            </div>
        </div>
    </section>
<?php  
if(isset($_POST["submit"])){  
if(!empty($_POST['email']) && !empty($_POST['pass'])) {  
    $email=$_POST['email'];  
    $pass=$_POST['pass'];  
    $con=mysqli_connect('localhost','root','') or die(mysqli_error());  
    mysqli_select_db($con,'temp') or die("cannot select DB");  
  
    $query=mysqli_query($con,"SELECT * FROM login WHERE email='".$email."'");  
    $numrows=mysqli_num_rows($query);  
    if($numrows==0)  
    {  
    $sql="INSERT INTO login(email,password) VALUES('$email','$pass')";  
  
    $result=mysqli_query($con,$sql);  
        if($result){  
    echo "Account Successfully Created";  
	header("Location: login.php");
    } else {  
    echo "Failure!";  
    }  
  
    } else {  
    echo "That email already exists! Please try again with another email.";  
    }  
  
} else {  
    echo "All fields are required!";  
}  
}  
?>      
</body>
</html>