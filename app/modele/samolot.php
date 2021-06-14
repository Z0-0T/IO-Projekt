<?php

    class Samolot {

        private $samolotId;
        private $nazwaSamolotu;

        function __construct() {
        }

        public function getSamolotId() {
            return $this->samolotId;
        }

        public function getNazwaSamolotu() {
            return $this->nazwaSamolotu;
        }

        public function setSamolotId($samolotId) {
            $this->samolotId = $samolotId;
        }

        public function setNazwaSamolotu($nazwaSamolotu) {
            $this->nazwaSamolotu = $nazwaSamolotu;
        }

    }

?>