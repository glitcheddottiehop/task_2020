<?php

include 'Connection.php';

// Turn off all error reporting
error_reporting(0);

$dir    = '../data';
$files = scandir($dir);

$refactoredList = [];
foreach ($files as $file){
    if (strpos($file, '.csv') !== false) {
        $refactoredList[] = $file;
    }
}


foreach ($refactoredList as $item){
    $file ="../data/$item";
    $csv = file_get_contents($file);
    $array = array_map("str_getcsv", explode("\n", $csv));
    $json = json_encode($array);

    $datas = [];
    $column_names = [];

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

        
   
    $count = count($datas);
    $data = '';
    foreach($datas as $entry){
        $columns = array_keys($entry);    
        $columnName = '';
        
        foreach($columns as $column){
            $columnName .= $column . ', ';
            
        }
        
        foreach($entry as $key => $value){
            if($count == 1){
                $data .= "'" . $value . "', ";
            } else {

            }
           
        }
        $sql = "";
        $sql .= "INSERT INTO customer_information (" . substr($columnName, 0, strpos($columnName, ',', -2)) .  ") VALUES ($data)";
        
    }
   var_dump($sql);
   print_r($datas);
} 
