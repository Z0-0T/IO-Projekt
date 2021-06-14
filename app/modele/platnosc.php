<?php
    class Platnosc {
        private $platnoscId;
        private $rodzajPlatnosci;

        function __construct() {
        }

        public function getPlatnoscId() {
            return $this->platnoscId;
        }

        public function getRodzajPlatnosci() {
            return $this->rodzajPlatnosci;
        }

        public function setPlatnoscId($platnoscId) {
            $this->platnoscId = $platnoscId;
        }

        public function setRodzajPlatnosci($rodzajPlatnosci) {
            $this->rodzajPlatnosci = $rodzajPlatnosci;
        }

    }
?>