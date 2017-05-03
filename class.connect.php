<?php
    class connect
    {
        //database parameter
        public $server = "luyihan.cohqper7h0x2.us-east-1.rds.amazonaws.com";
        public $username = "root";
        public $password = "root1234";

        //get Mysql Connection
        public function getConnect($database)
        {
            $conn = new mysqli($this->server,$this->username,$this->password,$database);
            if($conn)
            {
                return $conn;    
            } 
            else
            {
                return null;
            }
        }
    }
?>