<?php
include('../../config/config.php');
include('../../config/log_handler.php');

reference_category();
/** Function to Get Product **/
function reference_category() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $qry = "SELECT * FROM tbl_category ORDER BY ID ASC";
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