<?php
if (isset($_POST['login'])) {
    if ( isset($_POST['username']) && isset($_POST['password']) ) {
        $username = mysqli_escape_string($link, $_POST['username']);
        $password = mysqli_escape_string($link, $_POST['password']);
        $req = "SELECT id, username, email, firstname, lastname FROM users WHERE username = '".$username."' AND password = '".hash('sha512', $password)."'";
        $query = mysqli_query($link, $req);
        if ($query && mysqli_num_rows($query) > 0) {
            $user_infos = mysqli_fetch_assoc($query);
            $_SESSION['idUser'] = $user_infos['id'];
            $_SESSION['username'] = $user_infos['username'];
            $_SESSION['email'] = $user_infos['email'];
            $_SESSION['firstname'] = $user_infos['firstname'];
            $_SESSION['lastname'] = $user_infos['lastname'];
            header('Location: index.php');
        }
        else
            $error = "<p style=\"color:red\">Les identifiants sont incorrects !</p>";
    }
    else
        $error = "<p style=\"color:red\">Tout les champs sont obligatoires !</p>";
}
?>
<div class="toggle toggle_login" id="toggle_login">
        <h3>Se connecter</h3>
    <form name="login" method="post" action="">
        <div class="login_fields">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="username" maxlength="10" placeholder="Nom d'utilisateur" required>
            <label>Mot de passe :</label>
            <input type="password" name="password" maxlength="20" placeholder="Mot de passe" required>
        </div>
        <div class="toggle_button">
            <button type="submit" name="login">OK</button>
        </div>
        <?php
        if (isset($error))
            echo $error;
        ?>
    </form>
</div>
    <?php 

            $checkBasket_req = "SELECT COUNT(id) AS nbBasket FROM basket WHERE qte > 0 AND active = 1";
            $checkBasket_que = mysqli_query($link, $checkBasket_req);
            $nbBasket = mysqli_fetch_row($checkBasket_que);
                $basket_req = "SELECT       products.id, products.name, products.image, products.price, products.qte, basket.qte AS qteBought
                                FROM        basket
                                INNER JOIN  products ON products.id = idProduct
                                WHERE       active = 1 AND basket.qte > 0";
                $basket_que = mysqli_query($link, $basket_req);
    ?>
<div class="toggle toggle_basket" id="toggle_basket">
    <h3>Votre panier</h3>
<?php 
                while ($basket = mysqli_fetch_assoc($basket_que)) {
                    echo 'wat';
                    if ($basket['qteBought'] > $basket['qte']) {
                        $changeBasket = "UPDATE basket SET qte = ".$basket['qte']." WHERE idUser = ".$_SESSION['idUser']." AND idProduct = ".$basket['id']." AND active = 1 AND qte > 0";
                        $changeBasket_que = mysqli_query($link, $changeBasket);
                    } ?>
    <div class="basket_preview">
        <div class="basket_miniature">
            <img src="assets/images/<?php echo $basket['image'];?>">
        </div>
        <div class="toggle_basket_desc">
            <p><?php echo $basket['name'];?></p>
            <p><?php echo $basket['qteBought'] * $basket['price'];?></p>
        </div>
        <div class="toggle_basket_qte">
            <p><?php echo $basket['qteBought'];?></p>
        </div>
    </div>
    <?php } ?>
    <button onclick="window.location.href='basket.php'" name="consulter">Consulter</button>
</div>

<div class="toggle toggle_user" id="toggle_user">
    <h3>Votre compte</h3>
    <div class="user_actions">
        <div><a href="account.php">Informations du compte</a></div>
        <?php if (check_admin($link, $_SESSION['idUser'])) { ?>
        <div><a href="admin/create_category.php">Créer une catégorie</a></div>
        <div><a href="admin/create_product.php">Ajouter un produit</a></div>
        <div><a href="admin/products_list.php">Modifier un produit</a></div>
        <div><a href="admin/users_list.php">Modifier un utilisateur</a></div>
        <?php } ?>
    </div>
</div>