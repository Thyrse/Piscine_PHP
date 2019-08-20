#!/usr/bin/php
<?php
if ($argc >= 2)
{
    foreach (array_slice($argv, 1) as $i) {
        echo "$i\n";
    }
}
?>