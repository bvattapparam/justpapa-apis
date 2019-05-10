<?php
include('../../config/config.php');
include('../../config/log_handler.php');

house_add();

/** Function to Push Product **/
function house_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));

    $HOUSEID                =   $data->houseId;
    $BUILDER                =   $data->builder;
    $BHK                    =   $data->bhk;
    $TYPE                   =   $data->type;
    $LOCATION               =   $data->location;
    $FINANCE                =   $data->finance;
    $FINANCEAMOUNT          =   $data->financeAmount;
    $BANK                   =   $data->bank;
    $RM                     =   $data->rm;
    $BOOKEDDATE             =   $data->bookedDate;
    $HANDOVERDATE           =   $data->handoverDate;
    $COMMENT                =   $data->comment;
    $CREATEDBY              =   $data->modifiedBy;
    $MODIFIEDBY             =   $data->modifiedBy;

    $sql_validate = mysqli_query($con, "SELECT * from ng_house WHERE HOUSEID = '$HOUSEID'");
    $num_valid_rows = mysqli_num_rows($sql_validate);
    if($num_valid_rows > 0){
        $arr = array('msg' => "", 'error' => 'HOUSE_ALREADY_AVAILABLE');
        $jsn = json_encode($arr);
        print_r($jsn);
    }else{
        $qry = "INSERT INTO ng_house (
            HOUSEID,
            BUILDER, 
            BHK, 
            TYPE, 
            LOCATION,
            FINANCE,
            FINANCEAMOUNT,
            BANK, 
            RM, 
            BOOKEDDATE,
            HANDOVERDATE,
            CREATEDBY,
            MODIFIEDBY,
            COMMENT) 
        VALUES (
            '$HOUSEID',
            '$BUILDER', 
            '$BHK', 
            '$TYPE', 
            '$LOCATION',
            '$FINANCE',
            '$FINANCEAMOUNT',
            '$BANK', 
            '$RM', 
            '$BOOKEDDATE',
            '$HANDOVERDATE',
            '$CREATEDBY',
            '$MODIFIEDBY',
            '$COMMENT'
            )";
         $result = mysqli_query($con,$qry);
        if(!$result){
            $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
            $jsn = json_encode($arr);
            trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
            trigger_error(mysqli_error());
            print_r($jsn);
        }else{
            $arr = array('msg' => "SUCCESS_HOUSE_ADDED", 'error' => '');
            $jsn = json_encode($arr);
            print_r($jsn);
        }
        
    }
}
