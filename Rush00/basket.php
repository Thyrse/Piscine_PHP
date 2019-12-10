<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

$page = "basket";

if (!isset($_SESSION['idUser']))
    header('Location: index.php');

if (isset($_POST['submit'])) {
    clear_basket($link, $_SESSION['idUser']);
    goto clear;
}

if (isset($_GET['action']) AND isset($_GET['id'])) {
    $action = $_GET['action'];
    $idProd = mysqli_escape_string($link, $_GET['id']);

    if ($action == "remove") {
        $checkQteBasket =   "SELECT COUNT(id) AS nb
                            FROM basket
                            WHERE active = 1 AND qte > 0 AND idProduct = ".$idProd." AND idUser = ".$_SESSION['idUser']."";
        $checkQteBasket_que = mysqli_query($link, $checkQteBasket);
        $checkQte = mysqli_fetch_row($checkQteBasket_que);
        if ($checkQte[0] > 0) {
            $removeOne_req =    "UPDATE basket
                                SET qte = qte - 1
                                WHERE active = 1 AND idUser = ".$_SESSION['idUser']." AND idProduct = ".$idProd.";";
            $removeOne_que = mysqli_query($link, $removeOne_req);
        }
    }

    if ($action == "add") {
        $checkQteBasket =   "SELECT basket.qte
                            FROM basket
                            INNER JOIN products ON products.id = ".$idProd."
                            WHERE active = 1 AND basket.qte < products.qte AND products.qte > 0 AND idProduct = ".$idProd." AND idUser = ".$_SESSION['idUser']."";
        $checkQteBasket_que = mysqli_query($link, $checkQteBasket);
        $checkQte = mysqli_fetch_row($checkQteBasket_que);
        if ($checkQte[0] > 0) {
            $removeOne_req =    "UPDATE basket
                                SET qte = qte + 1
                                WHERE active = 1 AND idUser = ".$_SESSION['idUser']." AND idProduct = ".$idProd."";
            $removeOne_que = mysqli_query($link, $removeOne_req);
        }
    }
}

clear:


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="assets/images/" rel="shortcut icon" />
    <script type="text/javascript" src="script.js"></script>
	<title>Panier</title>
</head>
<body>
<header>
    <?php include('inc/header.php'); ?>
</header>
    <div id ="main">
        <div class="basket">
            <h2>Votre panier</h2>

            <?php 

            $checkBasket_req = "SELECT COUNT(id) AS nbBasket FROM basket WHERE qte > 0 AND active = 1";
            $checkBasket_que = mysqli_query($link, $checkBasket_req);
            $nbBasket = mysqli_fetch_row($checkBasket_que);
            if ($nbBasket[0] > 0) {
                $basket_req = "SELECT       products.id, products.name, products.image, products.price, products.qte, basket.qte AS qteBought
                                FROM        basket
                                INNER JOIN  products ON products.id = idProduct
                                WHERE       active = 1 AND basket.qte > 0";
                $basket_que = mysqli_query($link, $basket_req);
                while ($basket = mysqli_fetch_assoc($basket_que)) {
                    if ($basket['qteBought'] > $basket['qte']) {
                        $changeBasket = "UPDATE basket SET qte = ".$basket['qte']." WHERE idUser = ".$_SESSION['idUser']." AND idProduct = ".$basket['id']." AND active = 1 AND qte > 0";
                        $changeBasket_que = mysqli_query($link, $changeBasket);
                    }
            ?>
            <form name="submit" method="post" action="">

            <div class="basket_item">
                <div class="basket_image">
                    <img src="assets/images/<?php echo $basket['image'];?>">
                </div>
                <div class="basket_desc">
                    <p class="item_name"><?php echo $basket['name'];?></p>
                    <span>Quantité : <?php echo $basket['qteBought'];?></span>
                    <p class="item_price"><?php echo $basket['qteBought'] * $basket['price'];?> $</p>
                </div>
                <div class="basket_qte">
                    <?php if ($basket['qteBought'] > 0) { ?>
                    <button><a href="?action=remove&id=<?php echo $basket['id'];?>">-</a></button>
                    <?php } if ($basket['qte'] > 0) { ?>
                    <button><a href="?action=add&id=<?php echo $basket['id'];?>">+</a></button>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>

            <div class="basket_buy">
                <button type="submit" name="submit">Acheter</button>
            </div>
            </form>
        <?php } else { ?>
            <em>Votre panier est vide.</em>
        <?php } ?>

        </div>
    </div>
<footer>
    <?php include('inc/footer.php');?>
</footer>
</body>
</html>