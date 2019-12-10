#!/usr/bin/php
<?php
    $tab = array();
    $i = 1;
    foreach (array_slice($argv, 1) as $x)
    {
        $array = explode(" ", $x);
        $tmp = array_filter($array, 'trim');
        foreach ($tmp as $y) {
            array_push($tab, $y);
        }
    }
    sort($tab, SORT_FLAG_CASE | SORT_STRING);
    foreach ($tab as $j)
    {
        if (($j[0] >= 'a' && $j[0] <= 'z') || ($j[0] >= 'A' && $j[0] <= 'Z'))
        {
            echo "$j\n";
        }
    }
    foreach ($tab as $j)
    {
        if (($j[0] >= '0' && $j[0] <= '9'))
        {
            echo "$j\n";
        }
    }
    foreach ($tab as $j)
    {
        if (!(($j[0] >= 'a' && $j[0] <= 'z') || ($j[0] >= 'A' && $j[0] <= 'Z')) && !($j[0] >= '0' && $j[0] <= '9'))
        {
            echo "$j\n";
        }
    }
?>