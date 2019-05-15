<?php
include('../../config/config.php');
include('../../config/log_handler.php');

house_update();

  /** Function to Push Product **/
  function house_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    
    $HOUSEID                =   $data->houseId;
    $BUILDER                =   valFORMAT($data->builder);
    $BHK                    =   $data->bhk;
    $TYPE                   =   valFORMAT($data->type);
    $LOCATION               =   valFORMAT($data->location);
    $FINANCE                =   $data->finance;
    $FINANCEAMOUNT          =   $data->financeAmount;
    $BANK                   =   valFORMAT($data->bank);
    $RM                     =   valFORMAT($data->rm);
    $BOOKEDDATE             =   $data->bookedDate;
    $HANDOVERDATE           =   $data->handoverDate;
    $COMMENT                =   valFORMAT($data->comment);
    $MODIFIEDBY             =   $data->modifiedBy;

    $qry = "UPDATE ng_house 
    SET BUILDER       = '$BUILDER', 
    BHK               = '$BHK',
    TYPE              = '$TYPE', 
    LOCATION          = '$LOCATION', 
    FINANCE           = '$FINANCE',
    FINANCEAMOUNT     = '$FINANCEAMOUNT',
    BANK              = '$BANK',
    RM                = '$RM',
    BOOKEDDATE        = '$BOOKEDDATE',
    HANDOVERDATE      = '$HANDOVERDATE',
    COMMENT           = '$COMMENT',
    MODIFIEDBY        = '$MODIFIEDBY' 
    WHERE HOUSEID     = '$HOUSEID'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_HOUSE_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
