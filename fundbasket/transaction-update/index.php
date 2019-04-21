<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_update();

  /** Function to Push Product **/
  function transaction_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $FBID           =   $data->fbId;
    $MONTH          =   $data->month;
    $AMOUNT         =   $data->amount;
    $BASKET         =   $data->basket;
    $PURPOSE        =   $data->purpose;
    $COMMENT        =   $data->comment;
    $MODIFIEDBY     =   $data->modifiedBy;

    $qry = "UPDATE ng_fundbasket   
    SET MONTH       = '$MONTH', 
    AMOUNT          = '$AMOUNT', 
    BASKET          = '$BASKET',
    PURPOSE         = '$PURPOSE', 
    COMMENT         = '$COMMENT',
    MODIFIEDBY      = '$MODIFIEDBY' 
    WHERE FBID      = '$FBID'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_FUNDBASKET_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
