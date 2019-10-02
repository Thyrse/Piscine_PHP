<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>print_get</title>
  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE">
</head>
<body>
    <?php
        foreach($_GET as $key => $value)
        {
            echo $key . ": " . $value . "\n";
        }
    ?>
</body>
</html>