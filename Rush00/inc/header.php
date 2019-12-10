<?php if (isset($_SESSION['idUser'])) { ?>
<div class="header_basket">
    <div>
        <button class="preview_basket">Panier <?php echo count_basket($link, $_SESSION['idUser']) ?></button>
    </div>
    </div>
<?php } ?>
    <div class="header_logo">
        <a href="index.php"><img src="assets/images/logo.png"></a>
    </div>
<?php 	include('inc/menu.php');
		include('inc/log_bar.php');?>
