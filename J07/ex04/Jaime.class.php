<?php
class Jaime extends Lannister
{
    public function sleepWith($who)
    {
        $class = new ReflectionClass($who);
        if ($class->getName() == "Tyrion")
        {
            print("Not even if I'm drunk !" . PHP_EOL);
        }
        elseif ($class->getName() == "Sansa")
        {
            print("Let's do this." . PHP_EOL);
        }
        elseif ($class->getName() == "Cersei")
        {
            print("With pleasure, but only in a tower in Winterfell, then." . PHP_EOL);
        }
    }
}
?>