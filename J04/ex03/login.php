<?php
require_once("auth.php");
session_start();
$loggued_on_user = "";
if ($_GET['login'] != '' && $_GET['passwd'] != '')
{
    if (auth($_GET['login'], $_GET['passwd']))
    {
        $_SESSION['loggued_on_user'] = $_GET['login'];
    }
}
if ($_SESSION['loggued_on_user'] === "")
{
    echo "ERROR\n";
}
else
{
    echo "OK\n";
}
?>