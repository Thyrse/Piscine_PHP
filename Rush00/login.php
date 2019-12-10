<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

if (isset($_POST['submit'])) {
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		$username = mysqli_escape_string($link, $_POST['username']);
		$password = mysqli_escape_string($link, $_POST['password']);
		$req = "SELECT id, username, email, firstname, lastname FROM users WHERE username = '".$username."' AND password = '".hash('sha512', $password)."'";
		$query = mysqli_query($link, $req);
		if ($query && mysqli_num_rows($query) > 0) {
			$user_infos = mysqli_fetch_assoc($query);
			$_SESSION['idUser'] = $user_infos['id'];
			$_SESSION['username'] = $user_infos['username'];
			$_SESSION['email'] = $user_infos['email'];
			$_SESSION['firstname'] = $user_infos['firstname'];
			$_SESSION['lastname'] = $user_infos['lastname'];
			header('Location: index.php');
		}
		else
			$error = "<p style=\"color:red\">Les identifiants sont incorrects !</p>";
	}
	else
		$error = "<p style=\"color:red\">Tout les champs sont obligatoires !</p>";
}


?>





<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<header>
	    <?php include($_SERVER["DOCUMENT_ROOT"].'/inc/header.php'); ?>
	</header>
	<div id="main">
		<div class="create create_user">
			<h3>Connexion</h3>
<form name="submit" method="post" action="">
	<div class="user_registration">
	<label>Username</label>
	<input type="text" name="username" maxlength="10" required>
	<label>Mot de passe</label>
	<input type="password" name="password" maxlength="20" required>
	<div class="create_button">
	<button type="submit" name="submit">Se connecter</button>
</div>
	<?php 
	if (isset($error))
		echo $error;
	?>
</form>
</div>
</div>
</body>
</html>