<?php

session_start();

include('core/database_infos.php');
include('core/functions.php');
include('core/restrict.php');

$page = "index";
//echo hash('sha512', '[Y3mfsdfsd5rC_N~');
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" />
    <link href="assets/images/" rel="shortcut icon" />
    <link rel="icon" type="image/png" href="assets/images/logo.png" />
	<script type="text/javascript" src="script.js"></script>
	<title>E-commerce</title>
</head>
<body>
<header>
	<?php include('inc/header.php'); ?>
</header>
    <div id ="main">
        <?php include('inc/category_list.php');?>
        <div class="items-block">
            <div class="items-list">

                <?php

                if (isset($_GET['id'])) {
                	$idCat 	= mysqli_escape_string($link, $_GET['id']);
                	$req 	= "SELECT 		products.id, name, image, price
                				FROM 		products
                				LEFT JOIN 	product_category ON product_category.idCategory = ".$idCat."
                				WHERE 		product_category.idProduct = products.id";
                }
                else
                	$req = "SELECT id, name, image, price FROM products";
                $que = mysqli_query($link, $req);
                while ($products = mysqli_fetch_assoc($que)) { ?>

                <div class="item">
                <div class="item_image"><img src="assets/images/<?php echo $products['image'];?>"></div>
                    <a href="product.php?id=<?php echo $products['id'];?>" class="item_name"><?php echo $products['name'];?></p>
                    <div class="item_desc">

                    <?php 
                    	$whichCat_req 	= "SELECT name, category.id
                    						FROM category
                    						LEFT JOIN product_category ON idProduct = ".$products['id']."
                    						WHERE category.id = idCategory";

                    	$whichCat_que 	= mysqli_query($link, $whichCat_req);
                    	while ( $whichCat = mysqli_fetch_assoc($whichCat_que) ) { ?>
                    	<a href="index.php?id=<?php echo $whichCat['id'];?>"><?php echo $whichCat['name'];?></a>&nbsp
                    <?php } ?>

                    </div>
                    <p class="item_price"><?php echo $products['price'];?> $</p>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
<footer>
    <?php include('inc/footer.php');?>
</footer>
</body>
</html>