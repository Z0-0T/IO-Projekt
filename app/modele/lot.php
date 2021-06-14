<?php
    class lot {
        private $miastoWylotu;
        private $miastoPrzylotu;
        private $godzinaWylotu;
        private $godzinaPrzylotu;
        private $dataWylotu;
        private $dataPrzylotu;
        private $cena;
        private $samolot;
        private $pilot;

        function __construct() {
        }

        function getMiastoWylotu() {
            return $this->miastoWylotu;
        }

        function getMiastoPrzylotu() {
            return $this->miastoPrzylotu;
        }

        function getGodzinaWylotu() {
            return $this->godzinaWylotu;
        }
        function getGodzinaPrzylotu() {
            return $this->godzinaPrzylotu;
        }
        function getDataWylotu() {
            return $this->dataWylotu;
        }
        function getDataPrzylotu() {
            return $this->dataPrzylotu;
        }
        function getCena() {
            return $this->cena;
        }
        function getSamolot() {
            return $this->samolot;
        }
        function getPilot() {
            return $this->pilot;
        }


        function setMiastoWylotu($miastoWylotu) {
            $this->miastoWylotu = $miastoWylotu;
        }

        function setMiastoPrzylotu($miastoPrzylotu) {
            $this->miastoPrzylotu = $miastoPrzylotu;
        }

        function setGodzinaWylotu($godzinaWylotu) {
            $this->godzinaWylotu = $godzinaWylotu;
        }
        function setGodzinaPrzylotu($godzinaPrzylotu) {
            $this->godzinaPrzylotu = $godzinaPrzylotu;
        }
        function setDataWylotu($dataWylotu) {
            $this->dataWylotu = $dataWylotu;
        }
        function setDataPrzylotu($dataPrzylotu) {
            $this->dataPrzylotu = $dataPrzylotu;
        }
        function setCena($cena) {
            $this->cena = $cena;
        }
        function setSamolot($samolot) {
            $this->samolot = $samolot;
        }
        function setPilot($pilot) {
            $this->pilot = $pilot;
        }


    }
?>