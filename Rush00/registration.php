<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

if (isset($_POST['submit'])) {

	if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['lastname']) && isset($_POST['firstname'])) {
		$username = mysqli_escape_string($link, $_POST['username']);
		$email = mysqli_escape_string($link, $_POST['email']);
		$password = mysqli_escape_string($link, $_POST['password']);
		$confirm_password = mysqli_escape_string($link, $_POST['confirm_password']);
		$lastname = mysqli_escape_string($link, $_POST['lastname']);
		$firstname = mysqli_escape_string($link, $_POST['firstname']);

		if (check_mail($email)) {
			if (check_password($password, $password)) {
				$check_user = create_user($link, $username, $email);
				if ($check_user === 1) {
					$password = hash('sha512', $password);
					$req = "INSERT INTO users (username, email, registration, password, firstname, lastname)
							VALUES ('".$username."', '".$email."', NOW(), '".$password."', '".$firstname."', '".$lastname."')";
					$query = mysqli_query($link, $req);
					if ($query)
						$valid_registration = "<p style=\"color:green\">Votre compte a ete cree avec succes !</p>";
				}
				else
					$error = "<p style=\"color:red\">".$check_user."</p>";
			}
		else if (check_password($_POST['password'], $_POST['confirm_password']) == 0)
			$error = "<p style=\"color:red\">Les mots de passes saisis sont differents</p>";
		else
			$error = "<p style=\"color:red\">Votre mot de passe n'est pas assez securise !</p>";
	}
	else
		$error = "<p style=\"color:red\">Le format du mail est incorrect !</p>";
	}
	else
		$error = "<p style=\"color:red\">Tout les champs sont obligatoires !</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<header>
	    <?php include('inc/header.php'); ?>
	</header>
	<div id="main">
		<div class="create create_user">
				<h3>Inscription</h3>
			<form name="submit" method="post" action="">
				<div class="user_registration">
					<label>Nom :</label>
					<input type="text" name="lastname" placeholder="Nom de famille" required>
					<label>Prénom :</label>
					<input type="text" name="firstname" placeholder="Prénom" required>
					<label for="username">Nom d'utilisateur :</label>
					<input type="text" name="username" maxlength="10" placeholder="Ex: Tintin, Harambe..." required>
					<label for="email">Email :</label>
					<input type="email" name="email" maxlength="30" placeholder="Email" required>
					<label for="password">Mot de passe :</label>
					<input type="password" name="password" maxlength="20" placeholder="Unique pour ce site..." required>
					<label>Confirmer le mot de passe :</label>
					<input type="password" name="confirm_password" maxlength="20" placeholder="Retapez le mot de passe..." required>
				</div>
				<div class="create_button">
					<button type="submit" name="submit">S'inscrire</button>
				</div>
				<?php 
				if (isset($error))
					echo $error;
				elseif (isset($valid_registration))
					echo $valid_registration;
				?>
			</form>
		</div>
	</div>
	<footer>
	    <?php include('inc/footer.php');?>
	</footer>
</body>
</html>