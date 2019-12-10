<?php
function auth($login, $passwd)
{
    if (file_exists("../private/passwd"))
    {
        $serialized = unserialize(file_get_contents("../private/passwd"));
        foreach ($serialized as $key => $value)
        {
            if ($value["login"] === $login && $value["passwd"] === hash('whirlpool', $passwd))
            {
                return true;
            }
        }
        return false;
    }
}
?>