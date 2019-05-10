<?php
include('../../config/config.php');
include('../../config/log_handler.php');

user_basic_details();

/** Function to Get Product **/
function user_basic_details() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $privateToken = $data->privateToken;
  $qry = "SELECT * FROM ng_vw_user WHERE PRIVATETOKEN = '$privateToken'";
  $qry_res = mysqli_query($con,$qry);
  if(!$qry_res){
    $arr = array('msg' => "", 'errorcode' => 'E00000002', 'error' => $qry.'Unknown Exception occurred. Please check the application log for more details.');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($qry_res))
    {
      $data_item[] =  array(
        "userName"              =>  $rows['USERNAME'],
        "firstName"             =>  $rows['FIRSTNAME'],
        "lastName"              =>  $rows['LASTNAME'],
        "role"                  =>  $rows['ROLE'],
        "mobile"                =>  $rows['MOBILE'],
        "email"                 =>  $rows['EMAIL'],
        "about"                 =>  $rows['ABOUT'],
        "avatar"                =>  $rows['AVATAR'],
        "createdBy"             =>  $rows['CREATEDBY'],
        "createdDate"           =>  $rows['CREATEDDATE'],
        "modifiedBy"            =>  $rows['MODIFIEDBY'],
        "modifiedDate"          =>  $rows['MODIFIEDDATE'],
        "language"              =>  $rows['LANGUAGE']
      );
    }
    $data['userBasicDetails'] = $data_item;
    echo(json_encode($data));
  }

}

?>