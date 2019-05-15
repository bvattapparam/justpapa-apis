<?php
include('../../config/config.php');
include('../../config/log_handler.php');

chitfund_group_edit();

  /** Function to Push Product **/
  function chitfund_group_edit() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $CHITID             =   $data->chitId;
    $CHITGROUP          =   strtoupper($data->chitGroup);
    $CHITVALUE          =   $data->chitValue;
    $STARTDATE          =   $data->startDate;
    $MATUREDDATE        =   $data->maturedDate;
    $STATUS             =   $data->status;
    $POC                =   $data->poc;
    $PERSON             =   $data->person;
    $COMMENT            =   valFORMAT($data->comment);
    $MODIFIEDBY         =   $data->modifiedBy;


    $qry = "UPDATE ng_chitfund 
    SET CHITGROUP       = '$CHITGROUP', 
    CHITVALUE           = '$CHITVALUE', 
    STARTDATE           = '$STARTDATE',
    MATUREDDATE         = '$MATUREDDATE', 
    STATUS              = '$STATUS', 
    POC                 = '$POC', 
    PERSON              = '$PERSON', 
    COMMENT             = '$COMMENT',
    MODIFIEDBY          = '$MODIFIEDBY' 
    WHERE CHITID        = '$CHITID'";

    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_CHITGROUP_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
