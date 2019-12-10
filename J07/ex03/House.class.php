<?php
class House {
    public function introduce() {
        print("House " . $this->getHouseName() . " of ");
        print($this->getHouseSeat() . " : ");
        print("\"" . $this->getHouseMotto() . "\"" . PHP_EOL);
    }
}
?>