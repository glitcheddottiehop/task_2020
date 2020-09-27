<?php

$file ="../data/file_one.csv";
$csv = file_get_contents($file);
$array = array_map("str_getcsv", explode("\n", $csv));
$json = json_encode($array);

var_dump($csv);

print_r(preg_replace("<br>", 'bbb', $csv));

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
        $datas[$key-1][$column_name] = $csv[$column_key];
    }
}

var_dump($datas);
