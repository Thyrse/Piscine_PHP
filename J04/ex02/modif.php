<?php
if ($_POST["login"] === "" || $_POST["oldpw"] === "" || $_POST["newpw"] === "" || $_POST["submit"] !== "OK")
{
    echo "ERROR\n";
    return ;
}
$status = false;
if (file_exists("../private/passwd"))
{
    $serialized = unserialize(file_get_contents("../private/passwd"));
    foreach ($serialized as $key => $value)
    {
        if ($value["login"] === $_POST["login"] && $value["passwd"] === hash('whirlpool', $_POST["oldpw"]))
        {
            $serialized[$key]["passwd"] = hash('whirlpool', $_POST["newpw"]);
            $status = true;
        }
    }
}
$serialized = file_put_contents("../private/passwd", serialize($serialized));
if ($status == false)
{
    echo "ERROR\n";
}
else
{
    echo "OK\n";
}
?>