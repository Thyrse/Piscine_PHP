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
	
	if (isset($_POST['name']) && isset($_POST['desc']) && isset($_FILES['image']) && isset($_POST['price']) && isset($_POST['qte'])
		&& !empty($_POST['category'])) {

		$name = mysqli_escape_string($link, $_POST['name']);

		$checkProd_req = "SELECT name FROM products WHERE name = '".$name."'";
		$checkProd_que = mysqli_query($link, $checkProd_req);
		if (mysqli_num_rows($checkProd_que) > 0) {
			$error = "<p style=\"color:red\">Un produit porte déjà ce nom !</p>";
			goto end;
		}

		$desc = protect($_POST['desc']);
		if (!is_numeric($_POST['price']) || !is_numeric($_POST['qte'])) {
			$error = "<p style=\"color:red\">Le prix et la quantité doivent être des valeurs numériques !</p>";
			goto end;
		}
		$price = mysqli_escape_string($link, $_POST['price']);
		$qte = mysqli_escape_string($link, $_POST['qte']);


		$lastProd_req = "SELECT id FROM products ORDER BY id DESC LIMIT 1";
		$lastProd_que = mysqli_query($link, $lastProd_req);
		if (mysqli_num_rows($lastProd_que) > 0)
			$lastProd = mysqli_fetch_row($lastProd_que);
		else
			$lastProd[0] = '0';

		if ( $_FILES['image']['error'] == 0 ) {
			$error = false;
			$newName = 'product_'.$lastProd[0];
			$path = "../assets/images";
			$legalExtensions = array("jpg", "png", "JPG", "PNG");
			$legalSize = "1000000"; // 1 MO
			$file = $_FILES['image'];
			$actualName = $file['tmp_name'];
			$actualSize = $file['size'];
			$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
			if ($_FILES['image']['tmp_name'] === 0 OR $actualSize == 0) {
				$error = "<p style=\"color:red\">Le fichier entré n'est pas valide !</p>";
				goto end;
			}
    		if (file_exists($path.'/'.$newName.'.'.$extension))
    			unlink($path.'/'.$newName.'.'.$extension);
    		if (!$error) {
		    	if ($actualSize < $legalSize) {
		        	if (in_array($extension, $legalExtensions))
		            	move_uploaded_file($actualName, $path.'/'.$newName.'.jpg'); }
		            else
		            	$error = "<p style=\"color:red\">Le format du fichier est invalide !</p>";

			} else {
		    	@unlink($path.'/'.$newName.'.'.$extension);
		    	echo "Une erreur s'est produite";
    		}
		}
		else {
			$error = "<p style=\"color:red\">Il y a une erreur sur le fichier !</p>";
			goto end;
		}

		$fileNewName = $newName.'.jpg';

		$req = "INSERT INTO products (name, image, description, price, qte)
				VALUES ('".$name."', '".$fileNewName."', '".$desc."', ".$price.", ".$qte.")";
		$que = mysqli_query($link, $req);

		$lastId = "SELECT id FROM products ORDER BY id DESC LIMIT 1";
		$lastId_get = mysqli_query($link, $lastId);
		echo mysqli_error($link);
		$idProduct = mysqli_fetch_array($lastId_get);

		foreach($_POST['category'] as $val) {
			$val = mysqli_escape_string($link, $val);
			if (is_numeric($val)) {
				$linkCat = "INSERT INTO product_category (idProduct, idCategory) VALUES (".$idProduct[0].", ".$val.")";
				$linkCat_query = mysqli_query($link, $linkCat);
			}
			else
				goto end;
		}
		$success = "<p style=\"color:green\">Le produit a été correctement crée !</p>";
	}
	else
		$error = "<p style=\"color:red\">Tout les champs sont obligatoires !</p>";
	end:
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Creer un produit</title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <script type="text/javascript" src="../script.js"></script>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id="main">
        <div class="create">
            <h3>Créer un produit</h3>
            <form name="submit" method="post" action="" enctype="multipart/form-data">
                <div class="create_form">
                    <label for="name">Nom du produit :</label>
                    <input type="text" name="name" placeholder="Nom" required>
                    <label for="desc">Description du produit : </label>
	                <textarea name="desc" rows="8" cols="21" placeholder="Description..." required></textarea>
                    <label for="image">Image du produit :</label>
                    <input type="file" name="image" required>
                    <label>Prix du produit :</label>
                    <input type="text" name="price" placeholder="Prix" required>
                    <label>Quantité disponible à la vente :</label>
                    <input type="text" name="qte" placeholder="Quantité" required>
                    <label>Catégorie(s)</label>
	                	<?php 
	                			$selectCat 	 = "SELECT name, id FROM category";
	                			$selectCat_q = mysqli_query($link, $selectCat);
	                			if (mysqli_num_rows($selectCat_q) == 0)
	                				echo '<em>Aucune catégorie</em>';
	                			else
	                				while ($data = mysqli_fetch_assoc($selectCat_q))
	                				echo '<span><input type="checkbox" name="category[]" value="'.$data['id'].'" id="'.$data['id'].'"><label for="'.$data['id'].'">'.$data['name'].'</label></span>';
     	                if (isset($error))
	                		echo $error;
	                	if (isset($success))
	                		echo $success;
       					?>
                </div>
                <div class="create_button">
                    <button type="submit" name="submit">Créer le produit</button>
                </div>
	                <?php 
                    ?>
            </form>
        </div>

    </div>

    <footer>
    	<?php include('inc/footer.php');?>
    </footer>
</body>
</html>