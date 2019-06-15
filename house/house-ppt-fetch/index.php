<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'fullview' :
  vehicle_fullview();
  break;
  case 'byHouseId' :
  ppt_byHouseId();
  break;
}


/** Function to Get Product **/
function ppt_byHouseId() {
  global $con;
  $HOUSEID = $_GET['houseId'];
  
  $qry = "SELECT * FROM ng_house_pt WHERE HOUSEID = '$HOUSEID'";
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
        "id"                    =>  $rows['ID'],
        "houseId"               =>  $rows['HOUSEID'],
        "bill"                  =>  $rows['BILL'],
        "paidDate"              =>  $rows['PAIDDATE'],
        "amount"                =>  $rows['AMOUNT'],
        "payMode"               =>  $rows['PAYMODE'],
        "comment"               =>  $rows["COMMENT"],
        "createdBy"             =>  $rows['CREATEDBY'],
        "createdDate"           =>  $rows['CREATEDDATE'],
        "modifiedBy"            =>  $rows['MODIFIEDBY'],
        "modifiedDate"          =>  $rows['MODIFIEDDATE']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}

?>