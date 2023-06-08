<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login Panel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
  <div class="container">
    <div class="myform">
      <form method="POST" action="">
        <h2>ADMIN LOGIN</h2>
        <input type="text" name="user" placeholder="Admin Name">
        <input type="password" name="pass" placeholder="Password">
        <button type="submit" name="submit">LOGIN</button>
      </form>
    </div>
    <div class="image">
      <img src="image.jpg">
    </div>
  </div>
 <?php
if(isset($_POST["submit"])){  
  
if(!empty($_POST['user']) && !empty($_POST['pass'])) {  
    $user=$_POST['user'];  
    $pass=$_POST['pass'];  
  
    $con=mysqli_connect('localhost','root','') or die(mysql_error());  
    mysqli_select_db($con,'temp') or die("cannot select DB");  
  
    $query=mysqli_query($con,"SELECT * FROM admin WHERE username='".$user."' AND password='".$pass."'");  
    $numrows=mysqli_num_rows($query);  
    if($numrows!=0)  
    {  
    while($row=mysqli_fetch_assoc($query))  
    {  
    $dbusername=$row['username'];  
    $dbpassword=$row['password'];  
    }  
  
    if($user == $dbusername && $pass == $dbpassword)  
    {  
    session_start();  
    $_SESSION['sess_user']=$user;  
  
    /* Redirect browser */ 
    header("Location: adminhome.html");  
    }  
    } else {  
    echo "Invalid username or password!";  
    }  
  
} else {  
    echo "All fields are required!";  
}  
}  
?>  
</body>
</html>