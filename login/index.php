<?php
include('../config/config.php');

switch($_GET['action']) {
  case 'get_user_data' :
  get_user_data();
  break;
  case 'validate_user_password' :
  validate_user_password();
  break;

}
// Validate user and password, return private token.
function validate_user_password(){
  global $con;
  $data = json_decode(file_get_contents("php://input"));

  $USERNAME = $data->USERNAME;
  $PASSWORD = $data->PASSWORD;
  $qry = "SELECT USERNAME, PASSWORD, PRIVATETOKEN FROM ng_user WHERE USERNAME = '$USERNAME'  AND PASSWORD = '$PASSWORD'";
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
      $data_item[] = array(
        "USERNAME"          =>  $rows['USERNAME'],
        "STATUS"            =>  $rows['STATUS'],
        "PRIVATEKEY"        =>  $rows['PRIVATEKEY']
      );
    }
    $data[]->AUTHDETAILS = $data_item;
    echo(json_encode($data));
  }
  $data = array();
}

/** Function to Get Product **/
function get_user_data() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $USERID = $data->USERID;
  $PASSWORD = $data->PASSWORD;
  $qry = "SELECT * FROM tbl_authentication WHERE USERID = '$USERID'  AND PASSWORD = '$PASSWORD'";
  $qry_res = mysqli_query($con,$qry);
  $data = array();
    
  while($rows = mysqli_fetch_array($qry_res))
  {
    $data[] = array(
      "USERID" => $rows['USERID'],
      "PASSWORD" => $rows['PASSWORD'],
      "FULLNAME" => $rows['FULLNAME'],
      "MOBILE" => $rows['MOBILE'],
      "AVATAR" => $rows['AVATAR'],
      "PERMISSIONS" =>[$rows["ROLE"]],
      "CREATEDBY" => $rows['CREATEDBY'],
      "CREATEDDATE" => $rows['CREATEDDATE'],
      "MODIFIEDBY" =>$rows['MODIFIEDBY'],
      "MODIFIEDDATE" => $rows['MODIFIEDDATE']

    );
    //$data_ROLE

   // $data_role=array("ROLE"=> $rows['ROLE']);
   // $data.role[]=array(
     // "ROLE" => $rows['ROLE']);
  }
echo(json_encode($data));
return json_encode($data);
}

?>
