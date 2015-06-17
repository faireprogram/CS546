<!DOCTYPE html>
<html>
  <head>
    <title>CS546 Final Project</title>
    <meta name="description=" content="My name is Zejie Ding. I work with Wen Zhang on CS546 final project">
    <meta charset="UTF-8">
  </head>
  
  <body>  
	<section id = "login">
	<form method="GET" action="./php/utils/LoginVerify.php">
		<header>
		<b>User please log in here.</b><br>
		</header>
		<br>
		<b>User Name:</b>
		<input type="text" name="uname" size="25"/>
		<br>
		<br>
		<b>  Password:</b>
		<input type="text" name="pwd" size="25"/>
	
		<p>
			<input type="submit" name="submit" value="Log in"/>
			<input type="reset" name="reset" value="Cancel"/>
			<label><a href="./php/Register.php">Register</a></label>
		</p>

	</form>
	</section>
  
  </body>
</html>