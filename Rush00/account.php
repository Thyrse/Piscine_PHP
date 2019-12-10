<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

if (!isset($_SESSION['idUser'])) {
    header('Location: index.php');
}


if (isset($_GET['delete']) AND isset($_GET['id']) AND $_GET['id'] == $_SESSION['idUser']) {
    $delete_req = "DELETE FROM users WHERE id = ".$_SESSION['idUser']."";
    $delete_que = mysqli_query($link, $delete_req);
    header('Location: index.php?action=logout');
}

if (isset($_POST['submit'])) {

    if (!empty($_POST['username']) && $_POST['username'] != $_SESSION['username']) {
        $username = mysqli_escape_string($link, $_POST['username']);
        $updateUsername_req = "UPDATE users SET username = '".$username."' WHERE id = ".$_SESSION['idUser']."";
        $updateUsername_que = mysqli_query($link, $updateUsername_req);
        $_SESSION['username'] = $username;
    }

    if (!empty($_POST['lastname']) && $_POST['lastname'] != $_SESSION['lastname']) {
        $lastname = mysqli_escape_string($link, $_POST['lastname']);
        $updateLastname_req = "UPDATE users SET lastname = '".$lastname."' WHERE id = ".$_SESSION['idUser']."";
        $updateLastname_que = mysqli_query($link, $updateLastname_req);
        $_SESSION['lastname'] = $lastname;
    }

    if (!empty($_POST['firstname']) && $_POST['firstname'] != $_SESSION['firstname']) {
        $firstname = mysqli_escape_string($link, $_POST['firstname']);
        $updateFirstname_req = "UPDATE users SET firstname = '".$firstname."' WHERE id = ".$_SESSION['idUser']."";
        $updateFirstname_que = mysqli_query($link, $updateFirstname_req);
        $_SESSION['firstname'] = $firstname;
    }

    if (!empty($_POST['email']) && $_POST['email'] != $_SESSION['email']) {
        $email = mysqli_escape_string($link, $_POST['email']);
        if ( checkmail($email) ) { 
            $updateEmail_req = "UPDATE users SET email = '".$email."' WHERE id = ".$_SESSION['idUser']."";
            $updateEmail_que = mysqli_query($link, $updateEmail_req);
            $_SESSION['email'] = $email;
        }
        else
            $error = '<p style="color:red">Le format de l\'email est incorrect !</p>';
    }

    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $password = mysqli_escape_string($link, $_POST['password']);
        $confirm_password = mysqli_escape_string($link, $_POST['confirm_password']);
        $checkPass = check_password($password, $confirm_password);
        if ($checkPass == 1) {
            $password = hash('sha512', $password);
            $updatePass_req = "UPDATE users SET password = '".$password."' WHERE id = ".$_SESSION['idUser']."";
            $updatePass_que = mysqli_query($link, $updatePass_req);
        }
        elseif ($checkPass == 0) {
            $error = '<p style="color:red">Les mots de passes saisis sont différents !</p>';
        }
        else
            $error = '<p style="color:red">Le mot de passe n\'est pas assez sécurisé !</p>';
    }


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Compte</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <header>
    	<?php include('inc/header.php'); ?>
    </header>
    <div id="main">
    	<div class="create create_user">
    			<h3>Informations de compte</h3>
    		<form name="submit" method="post" action="">
    			<div class="user_registration">
    				<label>Nom :</label>
    				<input type="text" name="lastname" placeholder="Nom de famille" value="<?php echo $_SESSION['lastname'];?>" required>
    				<label>Prénom :</label>
    				<input type="text" name="firstname" placeholder="Prénom" value="<?php echo $_SESSION['firstname'];?>" required>
    				<label for="username">Nom d'utilisateur :</label>
    				<input type="text" name="username" maxlength="10" placeholder="Ex: Tintin, Harambe..." value="<?php echo $_SESSION['username'];?>" required>
    				<label for="email">Email :</label>
    				<input type="email" name="email" maxlength="30" placeholder="Email" value="<?php echo $_SESSION['email'];?>" required>
    				<label for="password">Mot de passe :</label>
    				<input type="password" name="password" maxlength="20" placeholder="Unique pour ce site...">
    				<label>Confirmer le mot de passe :</label>
    				<input type="password" name="confirm_password" maxlength="20" placeholder="Retapez le mot de passe...">
    			</div>
    			<div class="create_button">
    				<button type="submit" name="submit">Modifier</button>
    			</div>
                <a id="delete_confirm" href="?delete=1&id=<?php echo $_SESSION['idUser'];?>">Supprimer son compte</a>
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