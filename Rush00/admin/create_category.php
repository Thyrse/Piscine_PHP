<?php

session_start();

include('../core/database_infos.php');
include('../core/functions.php');
include('../core/restrict.php');

if (!isset($_SESSION['idUser']) || !check_admin($link, $_SESSION['idUser'])) {
	header('Location: ../index.php');
	exit();
}

if (isset($_POST['submit'])) {

	if (isset($_POST['name'])) {
		$name = mysqli_escape_string($link, $_POST['name']);

		$checkCat_req = "SELECT name FROM category WHERE name = '".$name."'";
		$checkCat_que = mysqli_query($link, $checkCat_req);
		if (mysqli_num_rows($checkCat_que) > 0) {
			$error = "<p style=\"color:red\">Une categorie porte deja ce nom !</p>";
			goto end;
		}
		$req = "INSERT INTO category (name) VALUES ('".$name."')";
		$que = mysqli_query($link, $req);
		if ($que)
			$success = "<p style=\"color:green\">La categorie a ete correctement cree !</p>";
		else
			echo mysqli_error($link);
	}
	else
		$error = "<p style=\"color:red\">Tout les champs sont obligatoires !</p>";
	end:
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Créer une categorie</title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <script type="text/javascript" src="../script.js"></script>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id="main">
        <div class="create">
            <h3>Créer une catégorie</h3>
            <form name="submit" method="post" action="">
                <div class="create_form">
                    <label for="name">Nom de la catégorie :</label>
                    <input type="text" name="name" required>
                <?php 
                if (isset($error))
                    echo $error;
                elseif (isset($success))
                    echo $success;
                ?>
                </div>
                <div class="create_button">
                    <button type="submit" name="submit">Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <?php include('inc/footer.php');?>
    </footer>
</body>
</html>