<?php

    class Miasto {

        private $miastoId;
        private $nazwaMiasta;

        function __construct() {
        }

        public function getMiastoId() {
            return $this->miastoId;
        }

        public function getNazwaMiasta() {
            return $this->nazwaMiasta;
        }

        public function setMiastoId($miastoId) {
            $this->miastoId = $miastoId;
        }

        public function setNazwaMiasta($nazwaMiasta) {
            $this->nazwaMiasta = $nazwaMiasta;
        }

    }

?>