<?php
if (!file_exists("private"))
    mkdir("private");
if (!$_POST["login"] === "" || $_POST["passwd"] === "" || $_POST["submit"] !== "OK")
{
    echo "ERROR\n";
    return ;
}
if (file_exists("private/passwd"))
{
    $serialized = unserialize(file_get_contents("private/passwd"));
    foreach ($serialized as $value)
    {
        if ($value["login"] === $_POST["login"])
        {
            echo "ERROR\n";
            return ;
        }
    }
}
if ($_POST['login'] != '' && $_POST['passwd'] != '')
{
    echo "OK\n";
    // var_dump($unseri);
    // echo $_POST['login'];
    // foreach ($unseri as $value) {
     //   echo $value["login"];
        // echo $_POST['login'];
        // var_dump($unseri);
        // if ($_POST['login'] == $unseri['login'])
        // {
        //     echo "ALREADY EXISTS";
        // }
    // }
    // $user_exists = false;
    // $field["login"] = $_POST["login"];
    // $field["passwd"] = hash('md5', $_POST["passwd"]);
    // $serialized[] = $field;
    $serialized[] = array("login" => $_POST['login'], "passwd" => hash('md5', $_POST['passwd']));
    var_dump($serialized);
    file_put_contents("private/passwd", serialize($serialized));
}


// foreach ($serialized as $key => $value) {
//     if ($value['login'] === $_POST['login'])
//     {
//         $user_exists = true;
//     }
// }
// if ($user_exists == true)
// {
//     echo "ERROR\n";
// }

// var_dump($unseri);
// echo $unseri;
// var_dump($unseri);

?>