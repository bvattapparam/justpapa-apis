<?php
include('../../config/config.php');

// switch($_GET['action']) {
//   case 'get_user_data' :
//   get_user_data();
//   break;
//   case 'validate_user_password' :
//   validate_user_password();
//   break;

// }
validate_username();
// Validate user and password, return private token.
function validate_username(){
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $USERNAME = $data->username;
  $qry = "SELECT USERNAME FROM ng_user WHERE USERNAME = '$USERNAME'";
  $qry_res = mysqli_query($con,$qry);
  if(!$qry_res){
    $arr = array('msg' => "", 'errorcode' => 'E00000001', 'error' => $qry.'Unknown Exception occurred. Please check the application log for more details.');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($qry_res))
    {
      $data_item[] =  array(
        "USERNAME"          =>  $rows['USERNAME']
      );
    }
    $data['AUTHDETAILS'] = $data_item;
    echo(json_encode($data));
  }
  
}

?>
