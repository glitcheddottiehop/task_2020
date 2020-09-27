<?php

include 'Connection.php';

class GetData extends Connection
{
    public function getCustomerInformation($limit, $per_page)
    {
        if ($limit > 1) {
            (int)$limit = ($limit * 10) - 10;
        }
       $sql = "SELECT * FROM customer_information LIMIT $limit, $per_page";
       $stmt = $this->connect()->query($sql);
       while($row = $stmt->fetchAll()){
           return $row;
       }
    }
}
