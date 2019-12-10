<?php

session_start();

include('../core/database_infos.php');
include('../core/functions.php');
include('../core/restrict.php');

if (!isset($_SESSION['idUser']) || !check_admin($link, $_SESSION['idUser'])) {
	header('Location: ../index.php');
	exit();
}

if (!isset($_GET['id'])) {
	header('Location: ../index.php');
	exit();
}

$idUser = mysqli_escape_string($link, $_GET['id']);
$checkId = "SELECT id, username, email, lastname, firstname, isAdmin FROM users WHERE id = ".$idUser."";
$checkId_que = mysqli_query($link, $checkId);
if (mysqli_num_rows($checkId_que) == 0) {
	header('Location: index.php');
	exit();
}
$user = mysqli_fetch_assoc($checkId_que);


if (isset($_GET['delete']) AND isset($_GET['id']) AND $_GET['id'] == $user['id']) {
    $delete_req = "DELETE FROM users WHERE id = ".$user['id']."";
    $delete_que = mysqli_query($link, $delete_req);
    header('Location: index.php');
}

if (isset($_POST['submit'])) {

    if (!empty($_POST['username']) && $_POST['username'] != $user['username']) {
        $username = mysqli_escape_string($link, $_POST['username']);
        $updateUsername_req = "UPDATE users SET username = '".$username."' WHERE id = ".$user['id']."";
        $updateUsername_que = mysqli_query($link, $updateUsername_req);
    }

    if (!empty($_POST['lastname']) && $_POST['lastname'] != $user['lastname']) {
        $lastname = mysqli_escape_string($link, $_POST['lastname']);
        $updateLastname_req = "UPDATE users SET lastname = '".$lastname."' WHERE id = ".$user['id']."";
        $updateLastname_que = mysqli_query($link, $updateLastname_req);
    }

    if (!empty($_POST['firstname']) && $_POST['firstname'] != $user['firstname']) {
        $firstname = mysqli_escape_string($link, $_POST['firstname']);
        $updateFirstname_req = "UPDATE users SET firstname = '".$firstname."' WHERE id = ".$user['id']."";
        $updateFirstname_que = mysqli_query($link, $updateFirstname_req);
    }

    if (!empty($_POST['email']) && $_POST['email'] != $user['email']) {
        $email = mysqli_escape_string($link, $_POST['email']);
        if ( checkmail($email) ) { 
            $updateEmail_req = "UPDATE users SET email = '".$email."' WHERE id = ".$user['id']."";
            $updateEmail_que = mysqli_query($link, $updateEmail_req);
        }
        else
            $error = '<p style="color:red">Le format de l\'email est incorrect !</p>';
    }

    if ($_POST['isAdmin'] == 1) {
            $updateAdmin_req = "UPDATE users SET isAdmin = 1 WHERE id = ".$user['id']."";
            $updateAdmin_que = mysqli_query($link, $updateAdmin_req);
        }

    if ($_POST['isAdmin'] == 0) {
            $updateAdmin_req = "UPDATE users SET isAdmin = 0 WHERE id = ".$user['id']."";
            $updateAdmin_que = mysqli_query($link, $updateAdmin_req);
        }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <script type="text/javascript" src="../script.js"></script>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id="main">
        <div class="create">
            <h3>Modifier un utilisateur (<?php echo $user['username'];?>)</h3>
            <form name="submit" method="post" action="" enctype="multipart/form-data">
                <div class="create_form">
                    <label>Nom :</label>
    				<input type="text" name="lastname" placeholder="Nom de famille" value="<?php echo $user['lastname'];?>" required>
    				<label>Prénom :</label>
    				<input type="text" name="firstname" placeholder="Prénom" value="<?php echo $user['firstname'];?>" required>
    				<label for="username">Nom d'utilisateur :</label>
    				<input type="text" name="username" maxlength="10" placeholder="Ex: Tintin, Harambe..." value="<?php echo $user['username'];?>" required>
    				<label for="email">Email :</label>
    				<input type="email" name="email" maxlength="30" placeholder="Email" value="<?php echo $user['email'];?>" required>
                    <label>Administrateur</label>
                    <input type="checkbox" name="isAdmin" value ="1" <?php if ($user['isAdmin'] == 1) { echo 'checked'; }?>>
                </div>
                <div class="create_button">
                    <button type="submit" name="submit">Modifier l'utilisateur</button>
                </div>
            </form>
            <a id="delete_confirm" href="?delete=1&id=<?php echo $user['id'];?>">Supprimer ce compte</a>
        </div>

    </div>

    <footer>
    	<?php include('inc/footer.php');?>
    </footer>
</body>
</html>