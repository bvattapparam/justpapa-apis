<?php
include('../../config/config.php');
include('../../config/log_handler.php');

vehicle_add();

  /** Function to Push Product **/
  function vehicle_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));

    $MODEL                  =   strtoupper($data->model);
    $MAKE                   =   $data->make;
    $COST                   =   $data->cost;
    $TYPE                   =   strtolower($data->type);
    $BOOKEDDATE             =   $data->bookedDate;
    $DELIVERYDATE           =   $data->deliveryDate;
    $REGNUMBER              =   $data->regNumber;
    $DEALER                 =   strtoupper($data->dealer);
    $RM                     =   $data->rm;
    $ADVANCEPAID            =   $data->advancePaid;
    $FINANCE                =   $data->finance;
    $FINANCEAMOUNT          =   $data->financeAmount;
    $COMMENT                =   $data->comment;
    $CREATEDBY              =   $data->modifiedBy;
    $MODIFIEDBY             =   $data->modifiedBy;

    $qry_count = mysqli_query($con,"SELECT * from ng_vehicle");
    $num_rows = mysqli_num_rows($qry_count);
    if($num_rows > 0){
        $count = $num_rows + 1;
    }else{
        $count = 1;
    }
    $VEHICLEID = idCREATOR('VH', $num_rows);

    $qry = "INSERT INTO ng_vehicle (
        VEHICLEID,
        MODEL, 
        MAKE, 
        COST, 
        TYPE,
        BOOKEDDATE,
        DELIVERYDATE,
        REGNUMBER, 
        DEALER, 
        RM,
        ADVANCEPAID,
        FINANCE,
        FINANCEAMOUNT,
        CREATEDBY,
        CREATEDDATE,
        MODIFIEDBY,
        MODIFIEDDATE,
        COMMENT) 
    VALUES (
        '$VEHICLEID',
        '$MODEL', 
        '$MAKE', 
        '$COST', 
        '$TYPE',
        '$BOOKEDDATE',
        '$DELIVERYDATE',
        '$REGNUMBER', 
        '$DEALER', 
        '$RM',
        '$ADVANCEPAID',
        '$FINANCE',
        '$FINANCEAMOUNT',
        '$CREATEDBY',
        '$CREATEDDATE',
        '$MODIFIEDBY',
        '$MODIFIEDDATE',
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
        $arr = array('msg' => "SUCCESS_VEHICLE_ADDED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
