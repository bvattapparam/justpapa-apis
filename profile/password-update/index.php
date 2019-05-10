<?php
include('../../config/config.php');
include('../../config/log_handler.php');

password_update();

  /** Function to Push Product **/
  function password_update() {
    global $con;
   
    $data = json_decode(file_get_contents("php://input"));
    $USERNAME           =   $data->userName;
    $PASSWORD           =   $data->password;
    $MODIFIEDBY         =   $data->modifiedBy;
    $qry = "UPDATE ng_user 
    SET PASSWORD        = '$PASSWORD',
    MODIFIEDBY          = '$MODIFIEDBY' 
    WHERE USERNAME      = '$USERNAME'";
    
    $result = mysqli_query($con,$qry);
    if(!$result){
        $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
        $jsn = json_encode($arr);
        trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
        trigger_error(mysqli_error());
        print_r($jsn);
    }else{
        $arr = array('msg' => "SUCCESS_PASSWORD_UPDATED", 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
}
?>
