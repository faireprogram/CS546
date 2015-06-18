<!DOCTYPE html>
<html lang = "en-us">
<head>
<meta charset="UTF-8">
<title>User Register</title>
</head>
<body>
	<section id = "Register">
	<form method="POST" action="./php/utils/RegisterVerify.php">
		<header>
		<b>User please register here.</b><br>
		</header>
		<br>
		<b>User Name:</b>
		<input type="text" id="uname" name="uname" size="25"/>
		<br>
		<br>
		<b>  Password:</b>
		<input type="text" id="pwd" name="pwd" size="25"/>
		<b>  Confirm Password:</b>
		<input type="text" id="cpwd" name="cpwd" size="25"/>
		<b> 	E-Mail:</b>
		<input type="text" id="e-mail" name="e-mail" size="25"/>
		<b> Cellphone:</b>
		<input type="text" id="cell" name="cell" size="25"/>
		<b> Address:</b>
		<input type="text" id="address" name="address" size="25"/>
		<b> Age:</b>
		<input type="text" id="age" name="age" size="25"/>
		<b> Gender:</b>
		<input type="radio" name="gender" id="male"
				value="male" /> <label for="male">Male</label>
		<input type="radio" name="gender" id="female"
				value="female" /> <label for="female">Female</label>
		<b> What is the name of your first school?</b>
		<input type="text" id="rq1" name="rq1" size="25"/>
		<b> What is your pet's name?</b>
		<input type="text" id="rq2" name="rq2" size="25"/>
		<b> What is your last name</b>
		<input type="text" id="rq3" name="rq3" size="25"/>
		<p>
			<input type="hidden" name="formsubmitted" value="TRUE" />
      		<input type="submit" value="Register" />
		</p>
	</form>
	</section>
</body>
</html>