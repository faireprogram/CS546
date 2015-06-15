<!DOCTYPE html>
<html>
  <head>
    <title>CS546 Final Project</title>
    <meta name="description=" content="My name is Zejie Ding. I work with Wen Zhang on CS546 final project">
    <meta charset=UTF-8">
  </head>
  
  <body>  
	<section id = "login">
	<form method=GET action="./utils/LoginVerify.php">
		<header>
		<b>User please log in here.</b><br>
		</header>
		<br>
		<b>User Name:</b>
		<input type="text" name="uname">
		<br>
		<br>
		<b>  Password:</b>
		<input type="text" name="pwd">
	
		<p>
			<input type="submit" name="submit" value="Log in">
			<input type="reset" name="reset" value="Cancel">
			<input type="submit" name="register" value = "Register">
		</p>

	</form>
	</section>
  
  </body>
</html>