<?php
class Tyrion extends Lannister
{
    public function sleepWith($who)
    {
        $class = new ReflectionClass($who);
        if ($class->getName() == "Jaime")
        {
            print("Not even if I'm drunk !" . PHP_EOL);
        }
        elseif ($class->getName() == "Sansa")
        {
            print("Let's do this." . PHP_EOL);
        }
        elseif ($class->getName() == "Cersei")
        {
            print("Not even if I'm drunk !" . PHP_EOL);
        }
    }
}
?>