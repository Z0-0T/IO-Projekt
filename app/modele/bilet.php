<?php 
    class Bilet {
        
        private $lot;
        private $iloscOsob;
        private $bagaze;
        private $kodBiletu;
        private $rezerwacja;

        function __construct() {
        }

        public function getLot() {
            return $this->lot;
        }
        public function getIloscOsob() {
            return $this->iloscOsob;
        }
        public function getBagaze() {
            return $this->bagaze;
        }
        public function getKodBiletu() {
            return $this->kodBiletu;
        }

        public function getRezerwacja() {
            return $this->rezerwacja;
        }

        public function setLot($lot) {
            $this->lot = $lot;
        }
        public function setIloscOsob($iloscOsob) {
            $this->iloscOsob = $iloscOsob;
        }
        public function setBagaze($bagaze) {
            $this->bagaze = $bagaze;
        }
        public function setKodBiletu($kodBiletu) {
            $this->kodBiletu = $kodBiletu;
        }
        public function setRezerwacja($rezerwacja) {
            $this->rezerwacja = $rezerwacja;
        }
    }
?>