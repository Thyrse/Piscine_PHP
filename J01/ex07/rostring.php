#!/usr/bin/php
<?php
if ($argc >= 2)
{
    $array = explode(" ", $argv[1]);
    $tmp = array_filter($array, 'trim');
    foreach(array_slice($tmp, 1) as $x)
    {
        echo "$x ";
    }
    echo $tmp[0]."\n";
}
?>