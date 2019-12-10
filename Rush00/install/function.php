<?php
function 	create_table($sitename, $user, $password, $email) {
	include('../core/database_infos.php');
	$link = mysqli_connect("$HOSTNAME", "$USER_DB", "$PASSWORD_DB", "$DATABASE_NAME");
	$password = hash('sha512', $password);
	if ($link) {

		$query = "CREATE TABLE IF NOT EXISTS users (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			  username varchar(20) NOT NULL,
			  email varchar(20) NOT NULL,
			  password varchar(255) NOT NULL,
			  registration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  lastname varchar(30) NOT NULL,
			  firstname varchar(30) NOT NULL,
			  logged tinyint(1) NOT NULL DEFAULT '1',
			  active tinyint(1) NOT NULL DEFAULT '1',
			  isAdmin tinyint(1) NOT NULL DEFAULT '0');";

		$query .= "CREATE TABLE IF NOT EXISTS basket (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			idUser int(11) NOT NULL,
  			idProduct int(11) NOT NULL,
  			qte int(11) NOT NULL,
  			active tinyint(1) NOT NULL DEFAULT '1');";

		$query .= "CREATE TABLE IF NOT EXISTS category (
			id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  			name varchar(100) NOT NULL);";

		$query .= "CREATE TABLE IF NOT EXISTS products (
			 id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			 name varchar(30) NOT NULL,
			 image varchar(50) NOT NULL,
			 description text NOT NULL,
			 price int(11) NOT NULL,
			 active tinyint(1) NOT NULL DEFAULT '1',
			 qte int(11) NOT NULL);";

		$query .= "CREATE TABLE IF NOT EXISTS product_category (
			 id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			 idProduct int(11) NOT NULL,
			 idCategory int(11) NOT NULL);";

		$insert = 	"INSERT INTO users (
					username,
					password,
					email,
					registration,
					isAdmin,
					firstname,
					lastname)

					VALUES (
					'$user',
					'$password',
					'$email',
					NOW(),
					1,
					'',
					'');";

		if (mysqli_multi_query($link, $query)){	
			while (mysqli_more_results($link))
					mysqli_next_result($link);
		}
		else
			echo mysqli_error($link);

		if (mysqli_multi_query($link, $insert)){	
			while (mysqli_more_results($link))
					mysqli_next_result($link);
		}
		else
			echo mysqli_error($link);
	}
	else
    	echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
	mysqli_close($link);
	return (1);
}
?>