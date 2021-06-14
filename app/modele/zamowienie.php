<?php
    class Zamowienie {

        private $zamowienieId;
        private $dataZamowienia;
        private $cenaZamowienia;
        private $czyOplacono;
        private $platnosc;
        private $bilet;

        function __construct() {
        }


        public function getZamowienieId() {
            return $this->zamowienieId;
        }
        public function getDataZamowienia() {
            return $this->dataZamowienia;
        }
        public function getCenaZamowienia() {
            return $this->cenaZamowienia;
        }
        public function getCzyOplacono() {
            return $this->czyOplacono;
        }
        public function getPlatnosc() {
            return $this->platnosc;
        }
        public function getBilet() {
            return $this->bilet;
        }

        public function getCzyOplaconoString() {
            if($this->czyOplacono == 1) {
                return "TAK";
            } else {
                return "NIE";
            }
        }

        public function setZamowienieId($zamowienieId) {
            $this->zamowienieId = $zamowienieId;    
        }

        public function setDataZamowienia($dataZamowienia) {
            $this->dataZamowienia = $dataZamowienia;    
        }

        public function setCenaZamowienia($cenaZamowienia) {
            $this->cenaZamowienia = $cenaZamowienia;
        }
        public function setCzyOplacono($czyOplacono) {
            $this->czyOplacono = $czyOplacono;
        }
        public function setPlatnosc($platnosc) {
            $this->platnosc = $platnosc;
        }
        public function setBilet($bilet) {
            $this->bilet = $bilet;
        }

    }
?>