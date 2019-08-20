#!/usr/bin/php
<?php
if ($argc == 4)
{
    $tab = array();
    foreach (array_slice($argv, 1) as $x)
    {
        $array = explode(" ", $x);
        $tmp = array_filter($array, 'trim');
        foreach ($tmp as $y) {
            array_push($tab, $y);
        }
    }
    if ($tab[1] == "+")
        echo "$tab[0]" + "$tab[2]";
    elseif ($tab[1] == "*")
        echo "$tab[0]" * "$tab[2]";
    elseif ($tab[1] == "%")
        echo "$tab[0]" % "$tab[2]";
    elseif ($tab[1] == "-")
        echo "$tab[0]" - "$tab[2]";
    elseif ($tab[1] == "/")
        echo "$tab[0]" / "$tab[2]";

    echo "\n";
}
else
    echo "Incorrect Parameters\n";
?>