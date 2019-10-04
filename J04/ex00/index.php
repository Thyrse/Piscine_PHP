<?php
    session_start();
    if ($_GET['login'] != '' && $_GET['passwd'] != '' && $_GET['submit'] == "OK")
    {
        $_SESSION['login'] = $_GET['login'];
        $_SESSION['passwd'] = $_GET['passwd'];
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>print_get</title>
  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE">
</head>
<body>
<form action="index.php" method="get">
  <div>
    <label for="login">Identifiant : </label>
    <input type="text" name="login" id="login" value="<?php echo $_SESSION['login']; ?>" required>
    <label for="passwd">Mot de passe : </label>
    <input type="password" name="passwd" id="passwd" value="<?php echo $_SESSION['passwd']; ?>" required>
    <input type="submit" name="submit" value="OK">
  </div>
</form>
</body>
</html>
</html>