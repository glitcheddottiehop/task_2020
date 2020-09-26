<?php

include 'Connection.php';

class GetData extends Connection
{
    public function getCustomerInformation()
    {
       $sql = "SELECT * FROM customer_information";
       $stmt = $this->connect()->query($sql);
       while($row = $stmt->fetchAll()){
           return $row;
       }
    }
}
