<?php
    function ft_split($array)
    {
        $array = explode(" ", $array);
        $new = array_filter($array, 'trim');
        sort($new);
        return $new;
    }
    print_r(ft_split("Bonjour ca va ?"));
?>