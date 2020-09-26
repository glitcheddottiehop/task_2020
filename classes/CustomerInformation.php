<?php 

include 'GetData.php';

$data = new GetData();
$json = json_encode($data->getCustomerInformation());
echo $json;
