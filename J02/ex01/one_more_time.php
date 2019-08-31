#!/usr/bin/php
<?php
function regex_day($day)
{
    $day = preg_match("/(^[L|l]undi|^[M|m]ardi|^[M|m]ercredi|^[J|j]eudi|^[V|v]endredi|^[S|s]amedi|^[D|d]imanche)$/", $day);
    return $day;
}
function regex_month($month)
{
    $month = preg_match("/(^[J|j]anvier|^[F|f][é|e]vrier|^[M|m]ars|^[A|a]vril|^[M|m]ai|^[J|j]uin|^[J|j]uillet|^[A|a]o[û|u]t|^[S|s]eptembre|^[O|o]ctobre|^[N|n]ovembre|^[D|d][é|e]cembre)$/", $month);
    return $month;
}
function nb_month($month)
{
    if ($month == "janvier" || $month == "Janvier")
        return 1;
    elseif ($month == "fevrier" || $month == "Fevrier" || $month == "février" || $month == "Février")
        return 2;
    elseif ($month == "mars" || $month == "Mars")
        return 3;
    elseif ($month == "avril" || $month == "Avril")
        return 4;
    elseif ($month == "mai" || $month == "Mai")
        return 5;
    elseif ($month == "juin" || $month == "Juin")
        return 6;
    elseif ($month == "juillet" || $month == "Juillet")
        return 7; 
    elseif ($month == "aout" || $month == "Aout" || $month == "août" || $month == "Août")
        return 8;
    elseif ($month == "septembre" || $month == "Septembre")
        return 9;
    elseif ($month == "octobre" || $month == "Octobre")
        return 10;
    elseif ($month == "novembre" || $month == "Novembre")
        return 11;
    elseif ($month == "decembre" || $month == "Decembre" || $month == "décembre" || $month == "Décembre")
        return 12;
}
function ft_print($argc, $argv)
{
    if ($argc == 2)
    {
        $array = explode(" ", $argv[1]);
        if (count($array) != 5)
        {
            echo "Wrong Format\n";
            return FALSE;
        }
        $years = preg_match("/^[0-9]{4}$/", $array[3], $year);
        $days = preg_match("/^[0-9]{1,2}$/", $array[1], $day);
        $time = explode(":", $array[4]);
        $hours = preg_match("/^[0-9]{2}$/", $time[0]);
        $minutes = preg_match("/^[0-9]{2}$/", $time[1]);
        $seconds = preg_match("/^[0-9]{2}$/", $time[2]);
        if (regex_day($array[0]) == 0 || regex_month($array[2]) == 0 || $years == 0 || $days == 0 || $hours == 0 || $minutes == 0 || $seconds == 0)
        {
            echo "Wrong Format\n";
            return FALSE;
        }
        $id_month = nb_month($array[2]);
        array_push($array, "$id_month");
        date_default_timezone_set("Europe/Paris");
        $result = mktime($time[0], $time[1], $time[2], $array[5], $day[0], $year[0]);
        echo "$result\n";
    }
}
ft_print($argc, $argv);
?>