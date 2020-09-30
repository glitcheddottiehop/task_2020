<?php

include 'Connection.php';

// Turn off all error reporting
error_reporting(0);

class CSVAggregator extends Connection 
{
    public function getFiles()
    {
        $dir    = '../data';
        $files = scandir($dir);
        $refactoredList = [];

        foreach ($files as $file){
            if (strpos($file, '.csv') !== false) {
                $refactoredList[] = $file;
            }
        }
        return $this->CSVToArray($refactoredList);
    }

    public function CSVToArray($list)
    {
        foreach ($list as $item) {
            $file ="../data/$item";
            $csv = file_get_contents($file);
            $array = array_map("str_getcsv", explode("\n", $csv));
            $json = json_encode($array);

            $datas = [];
            $column_names = [];
            $data = '';  

            foreach ($array[0] as $single_csv) {
                $column_names[] = $single_csv;
            }

            foreach ($array as $key => $csv) {
                if ($key === 0) {
                    continue;
                }   
                foreach ($column_names as $column_key => $column_name) {
                    $datas[$key][$column_name] = $csv[$column_key]; 
                }
            }
            foreach($datas as $entry) {
                $columns = array_keys($entry);    
                $columnName = '';
                foreach($columns as $column){
                    $columnName .= $column . ', ';    
                    $data .= "'" . $entry[$column] . "', ";
                }
                $formatValues = substr($data, 0, -2) . ')';

                return $this->createSQL($columnName, $formatValues);
            }
        }
    }

    public function createSQL($columns, $values)
    {
        $sql = "";
        $sql = "INSERT INTO customer_information (" . substr($columns, 0, strpos($columns, ',', -2)) .  ") VALUES ($values";
        return $this->insert($sql);
    }

    public function insert($sql)
    {

        //TODO return all id's of inserted rows

        // return $this->connect()->query("INSERT INTO customer_information (name, surname, email, address, city, gender, soc_security_num,balance) VALUES ('', '', '', '', '', '', '', '')");
        $this->connect()->query($sql);
        // return $this->pdo->errorCode();
        // return $this->pdo->lastInsertId();
        // ->execute() returns true on success. 
        // ->errorCode() which you can check for errors.
    }
}

$csvAggregator = new CSVAggregator();
echo $csvAggregator->getFiles();
