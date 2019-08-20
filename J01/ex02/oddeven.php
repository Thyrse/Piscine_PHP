#!/usr/bin/php
<?php
while(1)
{
    echo "Entrez un nombre: ";
    $prompt = rtrim(fgets(STDIN), "\n\r");

    if (feof(STDIN))
    {
        echo "\n";
        exit();
    }
    if (!is_numeric($prompt))
        echo "'$prompt' n'est pas un chiffre\n";
    else if (is_numeric($prompt))
    {
        if ($prompt % 2 == 0)
            echo "Le chiffre $prompt est Pair\n";
        else
            echo "Le chiffre $prompt est Impair\n";
    }
}
?>