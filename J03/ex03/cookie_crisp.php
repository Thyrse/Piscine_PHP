<?php
    if ($_GET[action] == "set" && $_GET[name] != '' && $_GET[value] != '')
    {
        setcookie($_GET[name], $_GET[value], time()+3600);
    }
    elseif ($_GET[action] == "get" && $_GET[name] != '')
    {
        echo $_COOKIE[$_GET[name]];
    }
    elseif ($_GET[action] == "del" && $_GET[name] != '')
    {
        setcookie($_GET[name], NULL, time()-3600);
    }
?>