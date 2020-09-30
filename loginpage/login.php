<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>User login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Login</h2>
	</div>

	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<br>
		<div  class="input-group">
			<button type="submit" name="login" class="btn">Login</button>	
		</div>
		<p>
			Not yet a member?<a href="register.php">Sign up</a>
		</p>
		<div>
			<a href="enter_email.php">Forgot your password</a>
		</div>
	</form>
</body>
</html>