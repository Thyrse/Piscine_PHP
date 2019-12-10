<?php

include('../core/functions.php');
include('function.php');
include('../core/database_infos.php');

if (!$link = mysqli_connect("$HOSTNAME", "$USER_DB", "$PASSWORD_DB", "$DATABASE_NAME"))
	header('Location: index.php');

if (isset($_POST['submit'])){
	$sitename = htmlentities($_POST['sitename']);
	$user = htmlentities($_POST['user']);
	$password = htmlentities($_POST['password']);
	$confirm_password = htmlentities($_POST['confirm_password']);
	$email = htmlentities( $_POST['email'], ENT_QUOTES, "ISO-8859-1" );

	$check_password = check_password($password, $confirm_password);
	if ($check_password === 1){
		if (create_table($sitename, $user, $password, $email)){
			$_SESSION['email'] = $email ;
			$logged = mysqli_query( $link, "UPDATE users SET logged = 1 WHERE email = '".$_SESSION['email']."'");
    		$req = mysqli_query( $link, "SELECT * FROM users WHERE email = '".$email."'" );
    		if ( mysqli_num_rows($req) ) {
        		$row = mysqli_fetch_assoc( $req );
        		if ($row['logged'] == 1) {

		            $_SESSION['idUser'] = $row['id'];
		            $_SESSION['email'] = $row['email'];
		            $_SESSION['username'] = $row['username'];
		            $_SESSION['firstname'] = $row['firstname'];
		            $_SESSION['lastname'] = $row['lastname'];
	       		}
	       	}
	       	delete_directory("./install");    
			echo "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"../\"</SCRIPT>";
		}
	}
	elseif ($check_password === -1)
		$error_message = "<strong><p style=\"color: red\">Votre mot de passe doit:<br>
			Avoir entre 8 et 20 caractères<br>
			Avoir au moins un chiffre ou un caractère spécial<br>
			Avoir au moins une majuscule<br>
			Avoir au moins une minuscule<br></p></strong>";
	else
		$error_message = "<strong><p style=\"color: red\">Vos mots de passe saisis sont différents.</p></strong>";
}

?>

		   <form method="post" action="">
				 <input type="text" name="sitename" id="sitename" placeholder="Nom du site" required>


					<h3>Administrateur</h3>


				 <input type="text" name="user" id="user" placeholder="Identifiant" required>
				 <input type="password" min="0" name="password" id="password" placeholder="Mot de passe" required>
				 <input type="password" min="0" name="confirm_password" id="password" placeholder="confirmer mot de passe" required>
				 <input type="text" min="0" name="email" id="email" placeholder="Adresse email" required>
				 <button type="submit" name="submit">Finaliser</button>
					<span>Informations</span>

			  <p>Créez votre compte administrateur et préciser le nom de votre site. <strong>Toute ces informations pourront être changées.</strong><br>

			  	<?php if (isset($error_message))
			  		echo $error_message; ?>

			  </p>
		   </form>