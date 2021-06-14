<?php
    class Miejsce {
        private $miejsceId;
        private $kodMiejsca;
        private $samolot;

        function __construct() {

        }

        function getMiejsceId() {
            return $this->miejsceId;
        }

        function getKodMiejsca() {
            return $this->kodMiejsca;
        }

        function getSamolot() {
            return $this->samolot;
        }

        function setMiejsceId($miejsceId) {
            $this->miejsceId = $miejsceId;
        }

        function setKodMiejsca($kodMiejsca) {
            $this->kodMiejsca = $kodMiejsca;
        }

        function setSamolot($samolot) {
            $this->samolot = $samolot;
        }

    }
?>