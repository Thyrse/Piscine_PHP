<?php
function ft_is_sort($tab)
{
    $i = 0;
    $array = $tab;
    $params = count($array);
    sort($array);
    $state = 1;

    while ($i < $params)
    {
        if ($array[$i] != $tab[$i])
        {
            $state = 0;
        }
        $i++;
    }
    return $state;
}
?>