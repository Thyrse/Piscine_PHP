<?php
if (!file_exists("../private"))
    mkdir("../private");
if ($_POST["login"] === "" || $_POST["passwd"] === "" || $_POST["submit"] !== "OK")
{
    echo "ERROR\n";
    return ;
}
if (file_exists("../private/passwd"))
{
    $serialized = unserialize(file_get_contents("../private/passwd"));
    foreach ($serialized as $value)
    {
        if ($value["login"] === $_POST["login"])
        {
            echo "ERROR\n";
            return;
        }
    }
}
if ($_POST['login'] != '' && $_POST['passwd'] != '')
{
    echo "OK\n";
    $serialized[] = array("login" => $_POST['login'], "passwd" => hash('whirlpool', $_POST['passwd']));
    file_put_contents("../private/passwd", serialize($serialized));
}
?>