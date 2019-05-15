<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_add();

  /** Function to Push Product **/
  function transaction_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $MONTH              =   $data->month;
    $AMOUNT             =   $data->amount;
    $BASKET             =   $data->basket;
    $FROMPERSON         =   $data->fromPerson;
    $BASKETOWNER        =   $data->basketOwner;
    $COMMENT            =   valFORMAT($data->comment);
    $CREATEDBY          =   $data->modifiedBy;
    $MODIFIEDBY         =   $data->modifiedBy;

    $qry_count = mysqli_query($con,"SELECT * from ng_piggybank");
    $num_rows = mysqli_num_rows($qry_count);
    if($num_rows > 0){
        $count = $num_rows + 1;
    }else{
        $count = 1;
    }
    $PBID = idCREATOR('PIGBANK', $num_rows);

    $qry = "INSERT INTO ng_piggybank (
        PBID,
        AMOUNT, 
        MONTH, 
        BASKET, 
        FROMPERSON,
        BASKETOWNER,
        COMMENT, 
        CREATEDBY, 
        MODIFIEDBY) 
    VALUES (
        '$PBID',
        '$AMOUNT', 
        '$MONTH', 
        '$BASKET', 
        '$FROMPERSON', 
        '$BASKETOWNER',
        '$COMMENT', 
        '$CREATEDBY', 
        '$MODIFIEDBY')";
     $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_PIGGYBANK_ADDED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
