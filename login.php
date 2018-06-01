<?php
	require 'database.php';
	session_start();

	$email = $password = $error = "";

	if(!empty($_POST))
	{
		$email = checkInput($_POST['email']);
		$password = checkInput($_POST['password']);

		$db = Database::connect();
		$statement = $db->prepare("SELECT * FROM users WHERE email = ? and password = ?");
		$statement->execute(array($email,$password));
		Database::disconnect();

		if($statement->fetch())
		{
			$_SESSION['email'] = $email;
			header("Location: admin.php");
		}
		else
		{
			$error = "Votre email ou mot de passe sont incorrects";
		}		
	}

	function checkInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Burger Code</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale-1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type="text/css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>

		<h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
		<div class="container admin">
			<div class="row">
				
				<h1><strong>Login</strong></h1>
				<br>
				<form class="form" role="form" action="login.php" method="post">
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

					</div>
					<div class="form-group">
						<label for="password">Mot de passe:</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" value="<?php echo $password; ?>">
					</div>
				
					<span class="help-inline"><?php echo $error; ?></span>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Se connecter</button>
					</div>	
				</form>
			</div>
		</div>
	</body>
</html>
