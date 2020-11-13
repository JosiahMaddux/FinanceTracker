<?php
    class dataBaseConnection {

        // Database Config Variables
        private $host = 'localhost';
        private $user = 'root';
        private $password = 'prosk8er.aZ95';
        private $database = 'finance_tracker';

        public function getMysqli() {
            return new mysqli($this->host, $this->user, $this->password, $this->database);
        }
    }
?>