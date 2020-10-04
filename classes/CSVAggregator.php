<?php

include 'Connection.php';

// Turn off all error reporting
error_reporting(0);

/**
 * Class CSVAggregator
 * 
 * Inserts data from given CSV files to database
 */
class CSVAggregator extends Connection 
{
     /**
     * Fetch CSV files
     * 
     * @return string
     */
    public function getFiles()
    {
        $dir    = '../test_data';
        $files = scandir($dir);

        foreach ($files as $file){
            if (strpos($file, '.csv') !== false) {
                  $this->CSVToArray($file);
            }
        }

        $host = "http://$_SERVER[HTTP_HOST]";
        $link = '<a target="_blank" href= "' . $host . '/classes/CustomerInformation.php">HERE</a>';
        return "<br>Data processed! Check inserted data: $link";
    }

    /**
     * Refactor each file's data into array type
     */
    public function CSVToArray($CSVfile)
    {
        $file ="../test_data/$CSVfile";
        $csv = file_get_contents($file);
        $array = array_map("str_getcsv", explode("\n", $csv));
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
            $data = '';  
            $columnName = '';

            foreach($columns as $column){
                $columnName .= $column . ', ';
                if ($entry[$column] == '') {
                    $entry[$column] = "NULL";
                    $data .= $entry[$column] . ", ";
                }else {
                    $data .= "'" . $entry[$column] . "', ";
                }
            }
            $formatValues = substr($data, 0, -2) . ')';
            $this->createSQL($columnName, $formatValues);
        }
    }

    /**
     * Create executable SQL
     */
    public function createSQL($columns, $values)
    {
        $sql = "";
        $sql = "INSERT INTO customer_information (" . substr($columns, 0, strpos($columns, ',', -2)) .  ") VALUES ($values";
        $this->insert($sql);
    }

    /**
     * Insert data into databse
     */
    public function insert($sql)
    {
        $stmt = $this->connect();
        if (!$stmt->query($sql)) { 
            print_r($stmt->errorInfo());
        }
        // $stmt->rowCount();
        // return $this->pdo->errorCode();
        // return $this->pdo->lastInsertId();
        // ->execute() returns true on success. 
        // ->errorCode() which you can check for errors.
    }
}

$csvAggregator = new CSVAggregator();
echo $csvAggregator->getFiles();
