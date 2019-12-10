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

$idProduct = mysqli_escape_string($link, $_GET['id']);
$checkId = "SELECT name, description, price, qte FROM products WHERE id = ".$idProduct."";
$checkId_que = mysqli_query($link, $checkId);
if (mysqli_num_rows($checkId_que) == 0) {
	header('Location: index.php');
	exit();
}
$product = mysqli_fetch_assoc($checkId_que);

if (isset($_GET['delete']) AND isset($_GET['id']) AND $_GET['id'] == $product['id']) {
    $delete_req = "DELETE FROM products WHERE id = ".$product['id']."";
    $delete_que = mysqli_query($link, $delete_req);
    $delete_cat_req = "DELETE FROM product_category WHERE idProduct = ".$product['id']."";
    $delete_cat_que = mysqli_query($link, $delete_cat_req);
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
	
	if (!empty($_POST['name']) && $_POST['name'] != $product['name']) {
        $name = mysqli_escape_string($link, $product['name']);
        $updateName_req = "UPDATE products SET name = '".$name."' WHERE id = ".$idProduct."";
        $updateName_que = mysqli_query($link, $updateName_req);
    }

	if (!empty($_POST['description']) && $_POST['description'] != $product['description']) {
        $desc = protect($product['description']);
        $updateDesc_req = "UPDATE products SET description = '".$desc."' WHERE id = ".$idProduct."";
        $updateDesc_que = mysqli_query($link, $updateDesc_req);
    }

	if (!empty($_POST['qte']) && $_POST['qte'] != $product['qte']) {
        $qte = mysqli_escape_string($link, $product['qte']);
        if (is_numeric($qte)) {
	        $updateQte_req = "UPDATE products SET qte = '".$qte."' WHERE id = ".$idProduct."";
	        $updateQte_que = mysqli_query($link, $updateQte_req);
	    }
	    else
	    	$error = "La quantité doit être une valeur numérique.";
    }

	if (!empty($_POST['price']) && $_POST['price'] != $product['price']) {
        $price = mysqli_escape_string($link, $product['price']);
        if (is_numeric($price)) {
	        $updatePrice_req = "UPDATE products SET price = '".$price."' WHERE id = ".$idProduct."";
	        $updatePrice_que = mysqli_query($link, $updatePrice_req);
	    }
	    else
	    	$error = "Le prix doit être une valeur numérique.";
    }

    if ( isset($_FILES['image']) AND $_FILES['image']['error'] == 0 ) {
		$error = false;
		$newName = 'product_'.$idProduct;
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
		           else {
		            	$error = "<p style=\"color:red\">Le format du fichier est invalide !</p>";
		            	goto end;
		           }

		} else {
		    @unlink($path.'/'.$newName.'.'.$extension);
		    echo "Une erreur s'est produite";
		    goto end;
    	}
	}

	if (isset($_POST['category'])) {
		$clear_cat_req = "DELETE FROM product_category WHERE idProduct = ".$idProduct."";
		$clear_cat_que = mysqli_query($link, $clear_cat_req);
		foreach($_POST['category'] as $val) {
			$val = mysqli_escape_string($link, $val);
			if (is_numeric($val)) {
				$linkCat = "INSERT INTO product_category (idProduct, idCategory) VALUES (".$idProduct.", ".$val.")";
				$linkCat_query = mysqli_query($link, $linkCat);
			}
			else
				goto end;
		}
	}

	end:
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un produit</title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <script type="text/javascript" src="../script.js"></script>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id="main">
        <div class="create">
            <h3>Modifier un produit (<?php echo $product['name'];?>)</h3>
            <form name="submit" method="post" action="" enctype="multipart/form-data">
                <div class="create_form">
                    <label for="name">Nom du produit :</label>
                    <input type="text" name="name" value="<?php echo $product['name'];?>">
                    <label for="desc">Description du produit : </label>
	                <textarea name="desc" rows="8" cols="21"><?php echo $product['description'];?></textarea>
                    <label for="image">Image du produit :</label>
                    <input type="file" name="image">
                    <label>Prix du produit :</label>
                    <input type="text" name="price" value="<?php echo $product['price'];?>">
                    <label>Quantité disponible à la vente :</label>
                    <input type="text" name="qte" value="<?php echo $product['qte'];?>">
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
                    <button type="submit" name="submit">Modifier le produit</button>
                </div>
	                <?php 
                    ?>
            </form>
            <a id="delete_confirm" href="?delete=1&id=<?php echo $user['id'];?>">Supprimer ce produit</a>
        </div>

    </div>

    <footer>
    	<?php include('inc/footer.php');?>
    </footer>
</body>
</html>