<?php
include('../../config/config.php');
include('../../config/log_handler.php');

passbook_update();

  /** Function to Push Product **/
  function passbook_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $PASSBOOKID         =   $data->passbookId;
    $MONTH              =   $data->month;
    $AMOUNT             =   $data->amount;
    $PAYMODE            =   $data->payMode;
    $COMMENT            =   $data->comment;
    $MODIFIEDBY         =   $data->modifiedBy;
    
    $qry = "UPDATE ng_chitfund_passbook  
    SET MONTH           = '$MONTH', 
    AMOUNT              = '$AMOUNT', 
    PAYMODE             = '$PAYMODE',
    COMMENT             = '$COMMENT',
    MODIFIEDBY          = '$MODIFIEDBY' 
    WHERE PASSBOOKID    = '$PASSBOOKID'";

    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_PASSBOOK_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
