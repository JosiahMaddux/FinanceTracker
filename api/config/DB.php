<?php
    class dataBaseConnection {

        // Database Config Variables
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $database = 'finance_tracker';

        public function getMysqli() {
            return new mysqli($this->host, $this->user, $this->password, $this->database);
        }
    }
?>