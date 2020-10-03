<?php 

include 'Data.php';

// Turn off all error reporting
error_reporting(0);

/**
 * Class CustomerInformation
 * 
 * Displays fetched data
 */
class CustomerInformation extends Data 
{
     /**
     * Modify fetched data before displaying
     */
    public function getCustomerInformation()    
    {
        $page = (isset($_GET['page']) ? ($_GET['page'] == 1 ? 0 : $_GET['page']) : 0);
        $perPage = (isset($_GET['per_page']) ? $_GET['per_page'] : 10);
        $data = $this->getData($page, $perPage);
        
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
    }
}

$customerInformation = new CustomerInformation();
echo $customerInformation->getCustomerInformation();
