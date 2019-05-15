<?php
include('../../config/config.php');
include('../../config/log_handler.php');

transaction_update();

  /** Function to Push Product **/
  function transaction_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $VEHICLEID              =   $data->vehicleId;
    $AMOUNT                 =   $data->amount;
    $TRANXDATE              =   $data->tranxDate;
    $PURPOSE                =   valFORMAT($data->purpose);
    $SERVICESTATION         =   valFORMAT($data->serviceStation);
    $ITEM                   =   valFORMAT($data->item);
    $COMMENT                =   valFORMAT($data->comment);
    $MODIFIEDBY             =   $data->modifiedBy;

    $qry = "UPDATE ng_vehicle_transactions 
    SET AMOUNT              = '$AMOUNT', 
    TRANXDATE               = '$TRANXDATE', 
    PURPOSE                 = '$PURPOSE',
    SERVICESTATION          = '$SERVICESTATION', 
    ITEM                    = '$ITEM', 
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
        $arr = array('msg' => "SUCCESS_VHTRANSACTION_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
