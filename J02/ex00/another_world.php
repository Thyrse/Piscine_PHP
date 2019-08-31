#!/usr/bin/php
<?php
if ($argc >= 2)
{
    $array = explode(" ", $argv[1]);
    $tmp = array_filter($array, 'trim');
    $new = implode(" ", $tmp);
    echo "$new\n";
}
?>