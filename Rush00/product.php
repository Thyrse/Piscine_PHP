<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

if (isset($_GET['id'])) {
    $getId = $_GET['id'];
    $product_req = "SELECT * FROM products WHERE id = ".$getId."";
    $product_que = mysqli_query($link, $product_req);
    if (mysqli_num_rows($product_que) == 0)
        header('Location: index.php');
    $products = mysqli_fetch_assoc($product_que);
}
else
    header('Location: index.php');

if (isset($_POST['submit'])) {
    $qte = mysqli_escape_string($link, $_POST['qte']);
    $idProduct = mysqli_escape_string($link, $_POST['id']);
    if (!is_numeric($qte))
        $error = "<p style=\"color:red\">La quantité doit etre une valeur numérique !</p>";
    else {
        $addBasket = addBasket($link, $_SESSION['idUser'], $idProduct, $qte);
        if ($addBasket == -1)
            $error = "<p style=\"color:red\">Il n'y a pas assez de produit en stock !</p>";
        else if ($addBasket == 0)
            $error = "<p style=\"color:red\">Une erreur est survenue...</p>";
        else
            $error = "<p style=\"color:green\">Votre commande a bien été ajoutée au panier !</p>";
    }
}

$page = "product";

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="assets/images/" rel="shortcut icon" />
    <script type="text/javascript" src="script.js"></script>
	<title>Rush 00</title>
</head>
<body>
<header>
<?php include('inc/header.php'); ?>
</header>
    <div id ="main">

        <?php include('inc/category_list.php');?>

        <div class="product">
            <div class="product_back">
                <div class="product_arrow"><a href="product.php"><img src="assets/images/back-arrow.svg"></a></div>
                <div class="product_title"><h3><?php echo $products['name']?></h3></div>
                    <?php 
                    if (isset($error))
                        echo $error;
                    ?>
            </div>
            <div class="product_infos">
                <div class="product_carac">
                    <div class="product_img">
                        <img src="assets/images/<?php echo $products['image']?>">
                    </div>
                    <div class="product_desc">
                        <?php echo $products['description']?>
                    </div>
                </div>
                <div class="product_buy">
                    <p class="buying_name"><?php echo $products['name']?></p>
                    <p class="buying_price">Prix : <?php echo $products['price']?>$</p>
                    <?php if ($products['qte'] > 0) { ?>
                    <p class="buying_qte">Stock : <?php echo $products['qte']?></p>
                    <?php if (isset($_SESSION['idUser'])) { ?>
                    <form method="post" name="submit" action="">
                        <input type="text" name="qte" placeholder="Quantite" value="1">
                        <input type="hidden" name="id" value="<?php echo $products['id']?>">
                        <button class="product_add" type="submit" name="submit">Ajouter</button>
                    </form>
                    <?php } ?>
                <?php } else echo '<p style="color:red">Rupture de stock</p>' ?>
                </div>
            </div>
        </div>
    </div>

<footer>
<?php include('inc/footer.php');?>
</footer>
</body>
</html>