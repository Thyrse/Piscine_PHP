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
    sort($tab);
    foreach ($tab as $j)
    {
        echo "$j\n";
    }
?>