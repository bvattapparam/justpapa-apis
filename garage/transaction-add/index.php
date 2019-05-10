<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_add();

  /** Function to Push Product **/
  function transaction_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $VEHICLEID              =   $data->vehicleId;
    $AMOUNT                 =   $data->amount;
    $TRANXDATE              =   $data->tranxDate;
    $PURPOSE                =   $data->purpose;
    $ITEM                   =   $data->item;
    $SERVICESTATION         =   strtoupper($data->serviceStation);
    $COMMENT                =   $data->comment;
    $CREATEDBY              =   $data->modifiedBy;
    $MODIFIEDBY             =   $data->modifiedBy;

    $qry = "INSERT INTO ng_vehicle_transactions (
        VEHICLEID,
        AMOUNT, 
        TRANXDATE, 
        PURPOSE, 
        ITEM,
        SERVICESTATION,
        CREATEDBY,
        MODIFIEDBY,
        COMMENT) 
    VALUES (
        '$VEHICLEID',
        '$AMOUNT', 
        '$TRANXDATE', 
        '$PURPOSE', 
        '$ITEM',
        '$SERVICESTATION',
        '$CREATEDBY',
        '$MODIFIEDBY',
        '$COMMENT'
        )";
     $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_VHTRANSACTION_ADDED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
