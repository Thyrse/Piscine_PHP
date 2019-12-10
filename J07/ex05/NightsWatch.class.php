<?php
class NightsWatch {
    public $members = [];
    public function recruit($who) {
        $this->members[] = $who;
    }
    public function fight() {
        foreach ($this->members as $member) {
            $class = new ReflectionClass($member);
            $methods = $class->getMethods();
            foreach ($methods as $method) {
                if ($method->getName() == "fight")
                {
                    $member->fight();
                }
            }
        }
    }
}

?>