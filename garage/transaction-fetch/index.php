<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'fullview' :
  transaction_fullview();
  break;
  case 'byvehicleId' :
  transaction_byvehicleId();
  break;
  case 'byId' :
  transaction_byId();
  break;
}


function transaction_byvehicleId() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $limit              =   $data->limit;
  $offset             =   $data->offset;
  $pagenation         =   $data->pagenation;
  $VEHICLEID          =   $data->vehicleId;

  if($pagenation){
      $qry = "SELECT * FROM ng_vehicle_transactions WHERE VEHICLEID = '$VEHICLEID' ORDER BY MODIFIEDDATE DESC LIMIT $limit OFFSET $offset";
  } else {
      $qry = "SELECT * FROM ng_vehicle_transactions WHERE VEHICLEID = '$VEHICLEID' ORDER BY MODIFIEDDATE DESC";
    
  }
  $qry_res = mysqli_query($con,$qry);

  $qry_count = mysqli_query($con,"SELECT * FROM ng_vehicle_transactions WHERE VEHICLEID = '$VEHICLEID'");
  $num_rows = mysqli_num_rows($qry_count);

  if(!$qry_res){
    $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($qry_res))
    {
      $data_item[] = array(
        "id"                    =>  $rows['ID'],
        "vehicleId"             =>  $rows['VEHICLEID'],
        "amount"                =>  $rows['AMOUNT'],
        "purpose"               =>  $rows['PURPOSE'],
        "tranxDate"             =>  $rows['TRANXDATE'],
        "item"                  =>  $rows["ITEM"],
        "serviceStation"        =>  $rows["SERVICESTATION"],
        "comment"               =>  $rows["COMMENT"],
        "createdBy"             =>  $rows['CREATEDBY'],
        "createdDate"           =>  $rows['CREATEDDATE'],
        "modifiedBy"            =>  $rows['MODIFIEDBY'],
        "modifiedDate"          =>  $rows['MODIFIEDDATE']
      );
    }
    $data_total=array("collectionSize"=> $num_rows);
    $data[]->ITEM = $data_item;
    $data[]->TOTAL = $data_total;
    $data[]->qry = $qry;
    echo(json_encode($data));
  }
}
function transaction_byId() {
  global $con;
  $ID       =   $_GET['Id'];
  $data = json_decode(file_get_contents("php://input"));
  $qry = "SELECT * FROM ng_vehicle_transactions WHERE ID = $ID";
  $qry_res = mysqli_query($con,$qry);

  if(!$qry_res){
    $arr = array('msg' => "", 'error' => $qry.'E_UNKNOWN');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($qry_res))
    {
      $data = array(
        "id"                    =>  $rows['ID'],
        "vehicleId"             =>  $rows['VEHICLEID'],
        "amount"                =>  $rows['AMOUNT'],
        "purpose"               =>  $rows['PURPOSE'],
        "tranxDate"             =>  $rows['TRANXDATE'],
        "item"                  =>  $rows["ITEM"],
        "serviceStation"        =>  $rows["SERVICESTATION"],
        "comment"               =>  $rows["COMMENT"],
        "createdBy"             =>  $rows['CREATEDBY'],
        "createdDate"           =>  $rows['CREATEDDATE'],
        "modifiedBy"            =>  $rows['MODIFIEDBY'],
        "modifiedDate"          =>  $rows['MODIFIEDDATE']
      );
    }
   
    echo(json_encode($data));
  }
}
?>