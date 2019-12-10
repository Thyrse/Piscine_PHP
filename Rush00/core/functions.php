<?php

function 	protect($param) {
	return (nl2br(addslashes(htmlentities($param))));
}

function 	try_connect($host, $user, $pass, $table) {
	error_reporting(0);
	$link = mysqli_connect($host, $user, $pass);
		if ($link){
			$query = "CREATE DATABASE IF NOT EXISTS ".$table." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			if (mysqli_query($link, $query))
        		return (1);}
		return (0);
}

function 	check_password($password, $confirm_password) {
	if ($password === $confirm_password){
			if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))
				return (1);
			else
				return (-1);
	}
	else
		return (0);
}

function 	delete_directory($target) {
	if (is_dir($target)) {
		$files = glob( $target . '*', GLOB_MARK );
		foreach ($files as $file) {
			delete_directory( $file );
		}
		rmdir( $target );
	} elseif (is_file($target)) {
		unlink( $target );
	}
}

function 	create_category($link, $name) {
		$req = "SELECT COUNT(*) FROM category WHERE name = ".$name."";
		$query = mysqli_query($link, $req);
		if (mysqli_num_rows($query) > 0)
			return ("Cette catégorie existe déjà !");
		$req = "INSERT INTO category (name) VALUES ('".$name."'')";
		$query = mysqli_query($link, $req);
		if ($query)
			return (1);
		else
			return ("Une erreur est survenue !");
	return ("Mauvais identifiants de la base de données !");
}

function 	create_product($link, $name, $desc, $price, $qte, $img, $cat) {
		$req = "SELECT COUNT(*) FROM product WHERE name = ".$name."";
		$query = mysqli_query($link, $req);
		if (mysqli_num_rows($query) > 0)
			return ("Ce produit existe déjà !");
		$req = "INSERT INTO products (name, image, description, price, qte, category)
				VALUES ('".$name."', '".$img."', '".$desc."', ".$price.", ".$qte.", ".$cat.")";
		$query = mysqli_query($link, $req);
		if ($query)
			return (1);
		else
			return ("Une erreur est survenue !");
	return ("Mauvais identifiants de la base de données !");
}

function 	create_user($link, $username, $email) {
		$req = "SELECT id FROM users WHERE email = '".$email."'";
		$query = mysqli_query($link, $req);
		if (mysqli_num_rows($query) > 0)
			return ("Un utilisateur a déjà cet email.");
		$req = "SELECT id FROM users WHERE username = '".$username."'";
		if (mysqli_num_rows($query) > 0)
			return ("Un utilisateur a déjà ce pseudonyme.");
		return (1);
	return ("Mauvais identifiants de la base de données !");
}

function 	count_basket($link, $idUser) {
		$req = "SELECT COUNT(id) FROM basket WHERE active = 1 AND qte > 0 AND idUser = ".$idUser."";
		$query = mysqli_query($link, $req);
		$nb = mysqli_fetch_row($query);
		if ($nb[0] > 0)
			return ("(".$nb[0].")");
}

function 	check_admin($link, $userId) {
	$req = "SELECT id FROM users WHERE isAdmin = 1 AND id = ".$userId."";
	$query = mysqli_query($link, $req);
	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			return (1);
		}
	}
	return (0);
}

function 	clear_basket($link, $userId) {
	$selectProduct = "SELECT idProduct, qte FROM basket WHERE active = 1 AND idUser = ".$userId."";
	$select = mysqli_query($link, $selectProduct);

	$req = "UPDATE basket SET active = 0 WHERE idUser = ".$userId."";
	$que = mysqli_query($link, $req);
	if ($que) {
		while ($updateProduct = mysqli_fetch_assoc($select)) {
			$removeProduct = "UPDATE products SET qte = qte - ".$updateProduct['qte']." WHERE id = ".$updateProduct['idProduct']."";
			$removeProque = mysqli_query($link, $removeProduct);
		}
	}
		return (1);
}

function 	JeChangeDavis($userId, $productId) {
	$req = "UPDATE baskets SET active = 0 WHERE idUser = ".$userId." AND idProduct = ".$productId."";
	$que = mysqli_query($link, $req);
	if ($que)
		return (1);
	return (0);
}

function     addBasket($link, $idUser, $idProduct, $qte) {
    $checkQte_req = "SELECT qte FROM products WHERE id = ".$idProduct."";
    $checkQte_que = mysqli_query($link, $checkQte_req);
    $qteProduct = mysqli_fetch_assoc($checkQte_que);
    $qteBought_req = "SELECT qte FROM basket WHERE idUser = ".$idUser." AND idProduct = ".$idProduct." AND active = 1";
    $qteBought_que = mysqli_query($link, $qteBought_req);
    $qteBought = mysqli_fetch_row($qteBought_que);
    if ($qte + $qteBought[0] <= $qteProduct['qte']) {
        $check_req = "SELECT products.qte, basket.qte AS basketQte
                    FROM products
                    INNER JOIN basket ON idProduct = ".$idProduct." AND idUser = ".$idUser."
                    WHERE products.id = ".$idProduct." AND active = 1";
        $check = mysqli_query($link, $check_req);
        $checkQte = mysqli_fetch_assoc($check);
        $updateBasket_req = "SELECT idProduct FROM basket WHERE active = 1 AND idUser = ".$idUser." AND idProduct = ".$idProduct."";
        $updateBasket_que = mysqli_query($link, $updateBasket_req);
        if (mysqli_num_rows($updateBasket_que) > 0) {
                $update = "UPDATE basket SET qte = qte + ".$qte." WHERE idProduct = ".$idProduct." AND idUser = ".$idUser."";
                $update_que = mysqli_query($link, $update);
                return (1);
        }
        else {
            $req = "INSERT INTO basket (idUser, idProduct, qte) VALUES (".$idUser.", ".$idProduct.", ".$qte.")";
            $que = mysqli_query($link, $req);
            if ($que)
                return (1);
            return (0);
    }
}
    return (-1);
}

function 	check_mail($email) {
	if ( preg_match ( "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/" , $email ) )
		return (1);
	return (0);
}

?>