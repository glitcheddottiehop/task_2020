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
        $data['data'] = $this->getData($page, $perPage);
        $data['data'] = $this->renameFields($data['data']);

        foreach ($data['data'] as $key => $row){
            if ($row['salutation'] == 'male') {
                $row['salutation'] = 'mr';
            }else if ($row['salutation'] == 'female') {
                $row['salutation'] = 'ms';
            }

            $row['account_balance'] = $row['account_balance'] * 100;
        
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$row['email'])) {
                $row['email'] = null;
            }
           
            $data['data'][$key] = $row;
        }
        $json = json_encode($data);
        echo $json;
    }
    
    /**
     * Rename array keys for display purposes
     * 
     * @data array Fetched data from database
     * @return array
     */
    public function renameFields($data){
        foreach ($data as $key => $values){
            foreach ($values as $field => $value){
                switch($field){
                    case 'id':
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }    
                switch($field){
                    case 'name':
                    $newKey = 'first_name';
                    $values[$newKey] = $values[$field];
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }
                switch($field){
                    case 'surname':
                    $newKey = 'last_name';
                    $values[$newKey] = $values[$field];
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }
                switch($field){
                    case 'gender':
                    $newKey = 'salutation';
                    $values[$newKey] = $values[$field];
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }
                switch($field){
                    case 'soc_security_num':
                    $newKey = 'social_security_num';
                    $values[$newKey] = $values[$field];
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }
                switch($field){
                    case 'balance':
                    $newKey = 'account_balance';
                    $values[$newKey] = $values[$field];
                    unset($values[$field]);
                    $data[$key] = $values;
                    break; 
                }
            }                
        }
        return $data;
    }
}

$customerInformation = new CustomerInformation();
echo $customerInformation->getCustomerInformation();
