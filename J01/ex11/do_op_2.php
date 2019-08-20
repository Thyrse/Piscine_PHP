#!/usr/bin/php
<?php
if ($argc == 2)
{
$array = array();
$new = array();
if (strpos($argv[1], "*") !== FALSE)
{
    $array = explode("*", $argv[1]);
    $operator = "*";
}
elseif (strpos($argv[1], "+") !== FALSE)
{
    $array = explode("+", $argv[1]);
    $operator = "+";
}
elseif (strpos($argv[1], "/") !== FALSE)
{
    $array = explode("/", $argv[1]);
    $operator = "/";
}
elseif (strpos($argv[1], "%") !== FALSE)
{
    $array = explode("%", $argv[1]);
    $operator = "%";
}
elseif (strpos($argv[1], "-") !== FALSE)
{
    $array = explode("-", $argv[1]);
    $operator = "-";
}
foreach ($array as $y)
{
    array_push($new, trim($y));
}
if (is_numeric($new[0]) && is_numeric($new[1]) && count($new) == 2)
{
    switch ($operator)
    {
        case '*':
            echo $new[0] * $new[1];
            break;
        case '+':
            echo $new[0] + $new[1];
            break;
        case '/':
            echo $new[0] / $new[1];
            break;
        case '%':
            echo $new[0] % $new[1];
            break;
        case '-':
            echo $new[0] - $new[1];
            break;
    }
}
else
    echo "Syntax Error";
echo "\n";
}
else
    echo "Incorrect Parameters\n";
?>