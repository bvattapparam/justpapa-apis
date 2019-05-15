<?php
include('../../config/config.php');
include('../../config/log_handler.php');

switch($_GET['action']) {
  case 'housePayment' :
  house_payment_update();
  break;
  case 'byvehicleId' :
  transaction_byvehicleId();
  break;
  case 'byId' :
  transaction_byId();
  break;
  case 'housePaymentByHouseId' :
  housePayment_byHouseId();
  break;
}

  /** Function to Push Product **/
  function house_payment_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $ID                 =   $data->id;
    $HOUSEID            =   $data->houseId;
    $PAIDDATE           =   $data->paidDate;
    $PAYMODE            =   $data->payMode;
    $PMNUMBER           =   valFORMAT($data->pmNumber);
    $PURPOSE            =   valFORMAT($data->purpose);
    $AMOUNT             =   $data->amount;
    $RECEIPT            =   valFORMAT($data->receipt);
    $POC                =   valFORMAT($data->poc);
    $COMMENT            =   valFORMAT($data->comment);
    $MODIFIEDBY         =   $data->modifiedBy;

    $qry = "UPDATE ng_house_payment  
    SET PAIDDATE     =  '$PAIDDATE', 
    PAYMODE          =  '$PAYMODE', 
    PMNUMBER         =  '$PMNUMBER',
    PURPOSE          =  '$PURPOSE', 
    AMOUNT           =  '$AMOUNT', 
    RECEIPT          =  '$RECEIPT',
    POC              =  '$POC',
    COMMENT          =  '$COMMENT',
    MODIFIEDBY       =  '$MODIFIEDBY' 
    WHERE ID         =  '$ID'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_HOUSE_PAYMENT_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
