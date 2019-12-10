<?php

if ( isset($_GET['action']) && $_GET['action'] == "logout" ) {
	$logout = mysqli_query( $link, "UPDATE users SET logged = 0 WHERE idUser = '".$_SESSION['idUser']."'");
	session_destroy();
}

?>