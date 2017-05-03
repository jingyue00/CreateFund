<?php
    class checkfollow
    {

        //get loginname and following relationship 
        public function getConnect($loginname,$following)
        {
            
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