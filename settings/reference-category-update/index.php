<?php
include('../../config/config.php');
include('../../config/log_handler.php');

category_update();

  /** Function to Push Product **/
  function category_update() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $CATEGORY       =   strtoupper($data->category);
    $CODE             =   $data->code;
    $MODIFIEDBY     =   $data->modifiedBy;

    
    $qry = "UPDATE tbl_category 
    SET CATEGORY = '$CATEGORY', 
    MODIFIEDBY = '$MODIFIEDBY' 
    WHERE CODE = '$CODE'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => '', 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_REF_CATEGORY_UPDATED", 'msgclass' => "success",'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
/** Function to Push Product **/
function add_reference() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $CATEGORYCODE   =   $data->CATEGORYCODE;
    $NAME           =   $data->NAME;
    $MODIFIEDBY     =   $data->MODIFIEDBY;
    $CREATEDBY      =   $data->MODIFIEDBY;
    $STATUS         =   1;

    $qry_count = mysqli_query($con,"SELECT * from tbl_reference WHERE CATEGORYCODE = '$CATEGORYCODE'");
    $num_rows = mysqli_num_rows($qry_count);
    if($num_rows > 0){
        $count = $num_rows + 1;
    }else{
        $count = 1;
    }
    $CODE       =   $CATEGORYCODE . $count;

    $qry = "INSERT INTO tbl_reference (CODE, NAME, CATEGORYCODE, CREATEDBY, MODIFIEDBY, STATUS) VALUES ('$CODE', '$NAME',  '$CATEGORYCODE', '$CREATEDBY', '$MODIFIEDBY', $STATUS)";
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'Unknown Exception occurred. Please check the application log for more details.');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => 'S_REFERENCE_ADDED', 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    } 
    

}
?>
