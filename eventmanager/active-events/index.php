<?php
include('../../config/config.php');
include('../../config/log_handler.php');

events();

/** Function to Get Product **/
function events() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $qry = "SELECT * FROM ng_events ORDER BY DATE ASC";
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
        "date"          =>  $rows['DATE'],
        "title"          =>  $rows['TITLE'],
        "summary"          =>  $rows['SUMMARY'],
        "status"              =>  $rows['STATUS'],
        "createdBy"          =>  $rows['CREATEDBY'],
        "createdDate"          =>  $rows['CREATEDDATE'],
        "modifiedBy"          =>  $rows['MODIFIEDBY'],
        "modifiedDate"          =>  $rows['MODIFIEDDATE']
      );
    }
    $data['eventList'] = $data_item;
    echo(json_encode($data));
  }

}

?>