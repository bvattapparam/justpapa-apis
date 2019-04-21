<?php
include('../../config/config.php');
include('../../config/log_handler.php');

reference_list_update();

/** Function to Push Product **/
function reference_list_update() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    
    $CODE           =   $data->refCode;
    $NAME           =   strtoupper($data->referenceName);
    $MODIFIEDBY     =   $data->modifiedBy;

    $qry = "UPDATE tbl_reference SET NAME = '$NAME', MODIFIEDBY = '$MODIFIEDBY' WHERE CODE = '$CODE'";
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => 'SUCCESS_REFERENCE_EDITED', 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    } 
    
}
?>
