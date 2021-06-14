<?php
    class Role {
        private $roleId;
        private $roleName;

        function __construct() {
        }

        public function setRoleId($roleId) {
            $this->roleId = $roleId;
        }

        public function setRoleName($roleName) {
            $this->roleName = $roleName;
        }

        public function getRoleId() {
            return $this->roleId;
        }

        public function getRoleName() {
            return $this->roleName;
        }

        public function roleShortcutToFull() {
            switch($this->roleName) {
                case "KL":
                    $out = "Klient";
                    break;
                case "PI":
                    $out = "Pilot";
                    break;
                case "OD":
                    $out = "Operator Danych";
                    break;
                case "OL":
                    $out = "Operator Lotów";
                    break;
                case "OS":
                    $out = "Operator Systemu";
                    break;
                case "OZ":
                    $out = "Operator Zamówień";
                    break;
            }
            return $out;
        }


    }
?>