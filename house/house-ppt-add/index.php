<?php
include('../../config/config.php');
include('../../config/log_handler.php');

ppt_add();

/** Function to Push Product **/
function ppt_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));

    $HOUSEID                =   $data->houseId;
    $BILL                   =   valFORMAT($data->bill);
    $PAIDDATE               =   $data->paidDate;
    $AMOUNT                 =   $data->amount;
    $PAYMODE                =   $data->payMode;
    $COMMENT                =   valFORMAT($data->comment);
    $CREATEDBY              =   $data->modifiedBy;
    $MODIFIEDBY             =   $data->modifiedBy;

    $sql_validate = mysqli_query($con, "SELECT * from ng_house_pt WHERE HOUSEID = '$HOUSEID' AND BILL = '$BILL'");
    $num_valid_rows = mysqli_num_rows($sql_validate);
    if($num_valid_rows > 0){
        $arr = array('msg' => "", 'error' => 'HOUSE_PT_ALREADY_AVAILABLE');
        $jsn = json_encode($arr);
        print_r($jsn);
    }else{
        $qry = "INSERT INTO ng_house (
            HOUSEID,
            BILL, 
            PAIDDATE, 
            AMOUNT, 
            PAYMMODE,
            CREATEDBY,
            MODIFIEDBY,
            COMMENT) 
        VALUES (
            '$HOUSEID',
            '$BILL', 
            '$PAIDDATE', 
            '$AMOUNT', 
            '$PAYMODE',
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
            $arr = array('msg' => "SUCCESS_HOUSE_PT_ADDED", 'error' => '');
            $jsn = json_encode($arr);
            print_r($jsn);
        }
        
    }
}
