#!/usr/bin/php
<?php
if ($argc == 2)
{
    $ch = curl_init();
    $curlopt = [
        CURLOPT_URL => $argv[1],
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ];
    curl_setopt_array($ch, $curlopt);
    $html = curl_exec($ch);
    curl_close($ch);
    $regex_img = '#(<img.*?src=)(.*?)(\s|>)#i';
    $regex_dirname = '#(http.*?//)(.*?)($)#i';
    $dirname = preg_match($regex_dirname, $argv[1], $dir);
    if (!(is_dir($dir[2])))
    {
        mkdir($dir[2]);
    }
    preg_match_all($regex_img, $html, $match);
    foreach ($match[2] as $i) {
        $i = trim($i, '"');
        if (strpos($i, 'http') === false)
            $i = $argv[1] . '/' . $i;
        $ch = curl_init();
        curl_setopt_array($ch, $curlopt);
        curl_setopt($ch, CURLOPT_URL, $i);
        $html = curl_exec($ch);
        curl_close($ch);
        $img = basename(trim($i, '"'));
        file_put_contents($dir[2] . '/' . $img, $html);
    }
}
?>