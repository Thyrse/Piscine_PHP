<?php
function ft_is_sort($tab)
{
    $i = 0;
    $array = $tab;
    $params = count($array);
    sort($array);
    $state = TRUE;

    while ($i < $params)
    {
        if ($array[$i] != $tab[$i])
        {
            $state = FALSE;
        }
        $i++;
    }
    return $state;
}
?>