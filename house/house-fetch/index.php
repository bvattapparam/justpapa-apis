<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'fullview' :
  vehicle_fullview();
  break;
  case 'byHouseId' :
  house_byHouseId();
  break;
}

function vehicle_fullview() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $limit              =   $data->limit;
  $offset             =   $data->offset;
  $pagenation         =   $data->pagenation;
  $PERSON             =   $data->person;

  if($pagenation){
      $qry = "SELECT * FROM ng_vehicle ORDER BY MODIFIEDDATE DESC LIMIT $limit OFFSET $offset";
  } else {
      $qry = "SELECT * FROM ng_vehicle ORDER BY MODIFIEDDATE DESC";
    
  }
  $qry_res = mysqli_query($con,$qry);

  $qry_count = mysqli_query($con,"SELECT * FROM ng_piggybank");
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
        "model"                 =>  $rows['MODEL'],
        "make"                  =>  $rows['MAKE'],
        "type"                  =>  $rows['TYPE'],
        "cost"                  =>  $rows['COST'],
        "bookedDate"            =>  $rows['BOOKEDDATE'],
        "deliveryDate"          =>  $rows['DELIVERYDATE'],
        "regNumber"             =>  $rows["REGNUMBER"],
        "dealer"                =>  $rows["DEALER"],
        "rm"                    =>  $rows["RM"],
        "advancePaid"           =>  $rows["ADVANCEPAID"],
        "finance"               =>  $rows["FINANCE"],
        "financeAmount"         =>  $rows["FINANCEAMOUNT"],
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
    echo(json_encode($data));
  }
}

/** Function to Get Product **/
function house_byHouseId() {
  global $con;
  $HOUSEID = $_GET['houseId'];
  
  $qry = "SELECT * FROM ng_house WHERE HOUSEID = '$HOUSEID'";
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
        "builder"               =>  $rows['BUILDER'],
        "type"                  =>  $rows['TYPE'],
        "bhk"                   =>  $rows['BHK'],
        "location"              =>  $rows['LOCATION'],
        "finance"               =>  $rows['FINANCE'],
        "financeAmount"         =>  $rows['FINANCEAMOUNT'],
        "bank"                  =>  $rows["BANK"],
        "rm"                    =>  $rows["RM"],
        "bookedDate"            =>  $rows["BOOKEDDATE"],
        "handoverDate"          =>  $rows["HANDOVERDATE"],
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