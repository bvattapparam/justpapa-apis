<?php
include('../../config/config.php');
include('../../config/log_handler.php');

switch($_GET['action']) {
  case 'byCategory' :
  single_reference_byCategory();
  break;
  case 'byCode' :
  single_reference_byCode();
  break;
}

/** Function to Get Product **/
function single_reference_byCategory() {
  global $con;
  $CATEGORYCODE = $_GET['categoryCode'];
  
  $qry = "SELECT * FROM tbl_reference WHERE CATEGORYCODE = '$CATEGORYCODE'";
  $result = mysqli_query($con,$qry);

  if(!$result){
    $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($result))
    {
      $data[] = array(
        "id"          =>  $rows['ID'],
        "code"        =>  $rows['CODE'],
        "name"        =>  $rows['NAME'],
        "categoryCode"    =>  $rows['CATEGORYCODE'],
        "createdBy"   =>  $rows['MODIFIEDBY'],
        "modifiedBy"  =>  $rows['MODIFIEDBY']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}
/** Function to Get Product **/
function single_reference_byCode() {
  global $con;
  $CODE = $_GET['refCode'];
  
  $qry = "SELECT * FROM tbl_reference WHERE CODE = '$CODE'";
  $result = mysqli_query($con,$qry);

  if(!$result){
    $arr = array('msg' => "", 'error' => 'Unknown Exception occurred. Please check the application log for more details.');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($result))
    {
      $data[] = array(
        "id"          =>  $rows['ID'],
        "code"        =>  $rows['CODE'],
        "referenceName"        =>  $rows['NAME'],
        "categoryCode"    =>  $rows['CATEGORYCODE'],
        "createdBy"   =>  $rows['MODIFIEDBY'],
        "modifiedBy"  =>  $rows['MODIFIEDBY']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}


?>