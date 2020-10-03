<?php

include 'Connection.php';

/**
 * Class Data
 * 
 * Executes query to get data from database
 */
class Data extends Connection
{
    /**
     * Fetch data
     * 
     * @page int Set record displaying start position
     * @per_page int Set record limit per page
     * @return array
     */
    public function getData($page, $per_page)
    {
        if ($page > 1) {
            (int)$page = ($page * 10) - 10;
        }
       $sql = "SELECT * FROM customer_information LIMIT $page, $per_page";
       $stmt = $this->connect()->query($sql);
       while($row = $stmt->fetchAll()){
           return $row;
       }
    }
}
