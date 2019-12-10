<?php

	include('database_infos.php');

	if (!isset( $link ) OR !isset( $DATABASE_NAME )) {
		header('Location: ../install/');
		exit();
	}

	if (isset($_GET['action']) AND $_GET['action'] == 'logout') {
		session_destroy();
		header('Location: index.php');
	}

?>