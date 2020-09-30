<?php
include('server.php');
if (isset($_POST["submit"])&& isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");
  $query = mysqli_query($db,
  "SELECT * FROM password_recovery WHERE key='".$key."' and email='".$email."';"
  );
  $row = mysqli_num_rows($query);
  if ($row==""){
  $error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p>
<p><a href="sendmail.php">
Click here</a> to reset password.</p>';
 }else{
  $row = mysqli_fetch_assoc($query);
  $expDate = $row['expDate'];
  if ($expDate >= $curDate){
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Reset password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  
  <form method="post" action="reset_password.php" name="update">
  <input type="hidden" name="action" value="update" />
  <br /><br />
  <div class="input-group">
      <label>Enter new Password</label>
      <input type="password" name="pass1" required>
    </div>
    <div class="input-group">
      <label>Re-Enter new Password</label>
      <input type="password" name="pass2" required>
    </div>
  <input type="hidden" name="email" value="<?php echo $email;?>"/>
  <div class="input-group">
     <button type="submit" class="btn" name="update">Reset Password</button>
   </div>
  </form>
  </body>
  </html>
<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
as valid only 24 hours (1 days after request).<br /><br /></p>";
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  } 
} // isset email key validate end
 
 
if(isset($_POST["email"]) && isset($_POST["action"]) &&
 ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($db,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($db,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
$error.= "<p>Password do not match, both password should be same.<br /><br /></p>";
  }
  if($error!=""){
echo "<div class='error'>".$error."</div><br />";
}else{
$pass1 = md5($pass1);
mysqli_query($db,
"UPDATE users SET password='".$pass1."'
WHERE email='".$email."';"
);
 
mysqli_query($db,"DELETE FROM password_recovery WHERE email='".$email."';");
 
echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
<p><a href="login.php">
Click here</a> to Login.</p></div><br />';
   } 
}
?>  