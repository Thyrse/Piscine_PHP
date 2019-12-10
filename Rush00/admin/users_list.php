<?php

session_start();

include('../core/database_infos.php');
include('../core/functions.php');
include('../core/restrict.php');

if (!isset($_SESSION['idUser']) || !check_admin($link, $_SESSION['idUser'])) {
	header('Location: ../index.php');
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <script type="text/javascript" src="../script.js"></script>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id="main">
        <?php 
        $what = "Utilisateurs";
        $page = "modify_user.php";
        $req = "SELECT id, username AS name FROM users";
        $query = mysqli_query($link, $req);
        include('inc/search_list.php');
        ?>

    </div>

    <footer>
    	<?php include('inc/footer.php');?>
    </footer>
</body>
</html>