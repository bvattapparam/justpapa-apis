<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_add();

  /** Function to Push Product **/
  function transaction_add() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $FEESID         =   $data->feesId;
    $MONTH          =   $data->month;
    $AMOUNT         =   $data->amount;
    $PURPOSE        =   $data->purpose;
    $PERSON         =   $data->person;
    $INSTITUTION    =   $data->institution;
    $STATUS         =   $data->status;
    $COMMENT        =   valFORMAT($data->comment);
    $MODIFIEDBY     =   $data->modifiedBy;
    $CREATEDBY      =   $data->modifiedBy;

    $qry_count = mysqli_query($con,"SELECT * from tbl_fees_manager");
    $num_rows = mysqli_num_rows($qry_count);
    if($num_rows > 0){
        $count = $num_rows + 1;
    }else{
        $count = 1;
    }
    $FEESID = idCREATOR('FEESMNGR', $num_rows);

    $qry = "INSERT INTO tbl_fees_manager (
        FEESID, 
        MONTH, 
        AMOUNT, 
        PURPOSE, 
        PERSON, 
        INSTITUTION, 
        STATUS, 
        COMMENT, 
        CREATEDBY, 
        MODIFIEDBY) 
    VALUES (
        '$FEESID', 
        '$MONTH', 
        '$AMOUNT', 
        '$PURPOSE', 
        '$PERSON', 
        '$INSTITUTION', 
        '$STATUS', 
        '$COMMENT', 
        '$CREATEDBY', 
        '$MODIFIEDBY')";


     $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'Unknown Exception occurred. Please check the application log for more details.');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_TRANSACTION_ADDED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
