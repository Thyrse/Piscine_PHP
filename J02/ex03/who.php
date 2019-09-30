#!/usr/bin/php
<?php
$file = fopen("/var/run/utmpx", "r");
fseek($file, 1256);
date_default_timezone_set("Europe/Paris");
while (!feof($file))
{
    $content = fread($file, 628);
    if (strlen($content) == 628)
    {
        $content = unpack("a256login/a4id/a32gid/iuid/istatus/ilogtime", $content);
        if ($content['status'] == 7)
        {
            echo trim($content['login']);
            echo " ";
            echo trim($content['gid']);
            echo "  ";
            echo $time = date("M d H:i", $content['logtime']);
            echo " \n";
        }
    }
}
?>