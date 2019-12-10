#!/usr/bin/php
<?php
function upmatch($matchs)
{
    $string = $matchs[1].strtoupper($matchs[2]).$matchs[3];
	return ($string);
}
    $regex_title = '#(<.*?title=")(.*?)(">)#i';
    $regex_a = '#(<a.*?>)(.*?)(<.*?/a>)#i';
    $regex_abis = '#(<a.*?>)(.*?)(<.*?</a>)#i';
    $regex_asingle = '#(<a.*?>)(.*?)(<.*/a>)#i';
    $file = file_get_contents($argv[1]);
    $upper = strtoupper($match[1]);
    $i = 0;
    $file = preg_replace_callback($regex_title, "upmatch", $file);
    $file = preg_replace_callback($regex_a, "upmatch", $file);
    $file = preg_replace_callback($regex_abis, "upmatch", $file);
    $file = preg_replace_callback($regex_asingle, "upmatch", $file);
    echo $file;
?>