#!/usr/bin/php
<?php
if ($argc > 2)
{
    for($i = 2; $i < count($argv); $i++){
        $key_value = explode(":", $argv[$i]);
        $new[$key_value[0]] = $key_value[1];
    }
    $param = $argv[1];
    if (array_key_exists($param, $new))
    {
        echo $new[$param]."\n";
    }
}
?>