<?php 

include 'GetData.php';

$dataObj = new GetData();

$data = $dataObj->getCustomerInformation((isset($_GET['page']) ? ($_GET['page'] == 1 ? 0 : $_GET['page']) : 0), (isset($_GET['per_page']) ? $_GET['per_page'] : 10));

foreach ($data as $row){
    if ($row['gender'] == 'male') {
        $row['gender'] = 'mr';
    }else if ($row['gender'] == 'female') {
        $row['gender'] = 'ms';
    }
    
    $row['balance'] = $row['balance'] * 100;

    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$row['email'])) {
        $row['email'] = null;
    }

    $json = json_encode($row);
    echo $json;
}
