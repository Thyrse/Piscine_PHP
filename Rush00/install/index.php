<?php
include ('../core/functions.php');

if (isset($_POST['submit'])){
	$host = protect($_POST['hostname']);
	$user = protect($_POST['user']);
	$pass = protect($_POST['password']);
	$table = protect($_POST['table']);
	if (!try_connect($host, $user, $pass, $table)){
		$no_database_found = "<strong><p style=\"color: red\">Les informations entrées sont incorrectes. Merci de revérifier.</p></strong>";
	}
	else{
		$file_config = fopen('../core/database_infos.php', 'r+');
		fputs($file_config, "<?php
		\$HOSTNAME = \"".$host."\";
		\$USER_DB = \"".$user."\";
		\$PASSWORD_DB = \"".$pass."\";
		\$DATABASE_NAME = \"".$table."\";
		\$link = mysqli_connect(\"\$HOSTNAME\", \"\$USER_DB\", \"\$PASSWORD_DB\", \"\$DATABASE_NAME\");
		if (!\$link)
			echo \"Failed to connect to MySQL: \" . mysqli_connect_error();
?>");

		fclose( $file_config );
		header('Location: install.php');
		exit();}
}
?>

		   <form method="post" action="">
				 <input type="text" name="hostname" id="hostname" placeholder="Hôte" required>
				 <input type="text" name="user" id="user" placeholder="Identifiant" required>
				 <input type="password" min="0" name="password" id="password" placeholder="Mot de passe">
				 <input type="text" min="0" name="table" id="table" placeholder="Nom de la table" required>
				 <button type="submit" name="submit">Connexion à la base de données</button>

					<span >Informations</span>
			  <p>Vous trouverez ces informations dans un email que vous a envoyé votre hébergeur internet. <strong>La table sera
			  	crée automatiquement si elle n'existe pas dans votre base de données.</strong><br>

			  	<?php if (isset($no_database_found))
			  		echo $no_database_found; ?>

			  </p>
		   </form>