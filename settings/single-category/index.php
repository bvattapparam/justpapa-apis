<?php
include('../../config/config.php');
include('../../config/log_handler.php');

switch($_GET['action']) {
  case 'byId' :
  single_category_byId();
  break;
}

/** Function to Get Product **/
function single_category_byId() {
  global $con;
  $id = $_GET['id'];
  
  $qry = "SELECT * FROM tbl_category WHERE ID = $id";
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
        "category"    =>  $rows['CATEGORY'],
        "createdBy"   =>  $rows['MODIFIEDBY'],
        "modifiedBy"  =>  $rows['MODIFIEDBY']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}


?>