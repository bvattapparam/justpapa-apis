<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_update();

  /** Function to Push Product **/
  function transaction_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $FEESID            =   $data->feesId;
    $MONTH          =   $data->month;
    $AMOUNT         =   $data->amount;
    $PURPOSE        =   $data->purpose;
    $PERSON         =   $data->person;
    $INSTITUTION    =   $data->institution;
    $STATUS         =   $data->status;
    $COMMENT        =   $data->comment;
    $MODIFIEDBY     =   $data->modifiedBy;

    $qry = "UPDATE tbl_fees_manager 
    SET MONTH = '$MONTH', AMOUNT = '$AMOUNT', PURPOSE = '$PURPOSE',
    PERSON = '$PERSON', INSTITUTION = '$INSTITUTION', STATUS = '$STATUS', COMMENT = '$COMMENT',
    MODIFIEDBY = '$MODIFIEDBY' WHERE FEESID = '$FEESID'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_TRANSACTION_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
