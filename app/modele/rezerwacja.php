<?php
    class Rezerwacja {
        private $kodMiejsca;
        private $znizka;

        function __construct() {
        }

        public function getKodMiejsca() {
            return $this->kodMiejsca;
        }
        public function getZnizka() {
            return $this->znizka;
        }

        public function setKodMiejsca($kodMiejsca) {
            $this->kodMiejsca = $kodMiejsca;
        }
        public function setZnizka($znizka) {
            $this->znizka = $znizka;
        }

        public function toString() {
            return $this->kodMiejsca . " - " . $this->znizka . "%";
        }

    }
?>