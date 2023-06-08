<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="index.css">
  <title>Login Page</title>
</head> 
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="POST" target="_top">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <input type="text" name="email" required>
                        <label for="">Email
						</label>
                    </div>
                    <div class="inputbox">
                        <input type="password" name="pass" class="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox">Remember Me</label>
                      
                    </div>
                    <input class="login" type="submit" value="Login" name="submit">
                    <div class="register">
                        <p>Don't have a account <a href="./register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>

<?php  

if(isset($_POST["submit"])){  
  
if(!empty($_POST['email']) && !empty($_POST['pass'])) {  
    $email=$_POST['email'];  
    $pass=$_POST['pass'];  
	
  
    $con=mysqli_connect('localhost','root','') or die(mysql_error());  
    mysqli_select_db($con,'temp') or die("cannot select DB");  
  
    $query=mysqli_query($con,"SELECT * FROM login WHERE email='".$email."' AND password='".$pass."'");  
    $numrows=mysqli_num_rows($query);  
    if($numrows!=0)  
    {  
    while($row=mysqli_fetch_assoc($query))  
    {  
    $dbemail=$row['email'];  
    $dbpassword=$row['password'];  
    }  
  
    if($email == $dbemail && $pass == $dbpassword)  
    {  
    session_start();  
    $_SESSION['sess_email']=$email;  
  
    /* Redirect browser */ 
    header("Location: user/index.html");  
    }  
    } else {  
    echo "Invalid email or password!";  
    }  
  
} else {  
    echo "All fields are required!";  
}  
}  
?>     
</body>
</html>