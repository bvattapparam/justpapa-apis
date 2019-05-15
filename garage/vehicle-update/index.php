<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_update();

  /** Function to Push Product **/
  function transaction_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $VEHICLEID              =   $data->vehicleId;
    $MODEL                  =   valFORMAT($data->model);
    $MAKE                   =   valFORMAT($data->make);
    $COST                   =   $data->cost;
    $TYPE                   =   valFORMAT($data->type);
    $BOOKEDDATE             =   $data->bookedDate;
    $DELIVERYDATE           =   $data->deliveryDate;
    $REGNUMBER              =   $data->regNumber;
    $DEALER                 =   valFORMAT($data->dealer);
    $RM                     =   valFORMAT($data->rm);
    $ADVANCEPAID            =   $data->advancePaid;
    $FINANCE                =   $data->finance;
    $FINANCEAMOUNT          =   $data->financeAmount;
    $COMMENT                =   valFORMAT($data->comment);
    $MODIFIEDBY             =   $data->modifiedBy;

    $qry = "UPDATE ng_vehicle
    SET MODEL               = '$MODEL', 
    MAKE                    = '$MAKE', 
    COST                    = '$COST',
    TYPE                    = '$TYPE', 
    BOOKEDDATE              = '$BOOKEDDATE', 
    DELIVERYDATE            = '$DELIVERYDATE',
    REGNUMBER               = '$REGNUMBER',
    DEALER                  = '$DEALER',
    RM                      = '$RM',
    ADVANCEPAID             = '$ADVANCEPAID',
    FINANCE                 = '$FINANCE',
    FINANCEAMOUNT           = '$FINANCEAMOUNT',
    COMMENT                 = '$COMMENT',
    MODIFIEDBY              = '$MODIFIEDBY' 
    WHERE VEHICLEID         = '$VEHICLEID'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_VEHICLE_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
