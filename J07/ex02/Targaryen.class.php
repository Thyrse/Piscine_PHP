<?php
class Targaryen {
    var $daenerys = "emerges naked but unharmed";
    var $viserys = "burns alive";
    public function resistsFire() {
		return False;
	}
    public function getBurned() {
        if ($this->resistsFire() == False)
        {
            return $this->viserys;
        }
        else {
            return $this->daenerys;
        }
	}
}
?>