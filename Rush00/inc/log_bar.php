    <div class="header_sign">
        <?php 
                if (!isset($_SESSION['idUser'])) {
        ?>
        <a href="registration.php">Inscription</a>
        <a href="#" class="sign_in">Connexion</a>
        <?php } else { ?>
        <span class="infos_user">Bonjour, <?php echo $_SESSION['username'];?></span>
        <a href="?action=logout">Déconnexion</a>
    <?php } ?>
    </div>