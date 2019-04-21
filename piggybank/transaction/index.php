<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'fullview' :
  transaction_fullview();
  break;
  case 'bypbId' :
  transaction_bypbId();
  break;
}

function transaction_fullview() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $limit              =   $data->limit;
  $offset             =   $data->offset;
  $pagenation         =   $data->pagenation;
  $PERSON             =   $data->person;

  if($pagenation){
      $qry = "SELECT * FROM ng_piggybank ORDER BY MODIFIEDDATE DESC LIMIT $limit OFFSET $offset";
  } else {
      $qry = "SELECT * FROM ng_piggybank ORDER BY MODIFIEDDATE DESC";
    
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
        "id"              =>  $rows['ID'],
        "pbId"          =>  $rows['PBID'],
        "amount"       =>  $rows['AMOUNT'],
        "month"       =>  $rows['MONTH'],
        "basket"       =>  $rows['BASKET'],
        "fromPerson"     =>  $rows['FROMPERSON'],
        "basketOwner"    =>  $rows['BASKETOWNER'],
        "comment"         =>  $rows["COMMENT"],
        "createdBy"       =>  $rows['CREATEDBY'],
        "createdDate"     =>  $rows['CREATEDDATE'],
        "modifiedBy"      =>  $rows['MODIFIEDBY'],
        "modifiedDate"    =>  $rows['MODIFIEDDATE']
      );
    }
    $data_total=array("collectionSize"=> $num_rows);
    $data[]->ITEM = $data_item;
    $data[]->TOTAL = $data_total;
    echo(json_encode($data));
  }
}

/** Function to Get Product **/
function transaction_bypbId() {
  global $con;
  $PBID = $_GET['pbId'];
  
  $qry = "SELECT * FROM ng_piggybank WHERE PBID = '$PBID'";
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
        "id"              =>  $rows['ID'],
        "pbId"          =>  $rows['PBID'],
        "amount"       =>  $rows['AMOUNT'],
        "month"       =>  $rows['MONTH'],
        "basket"       =>  $rows['BASKET'],
        "fromPerson"     =>  $rows['FROMPERSON'],
        "basketOwner"     =>  $rows['BASKETOWNER'],
        "comment"         =>  $rows["COMMENT"],
        "createdBy"       =>  $rows['CREATEDBY'],
        "createdDate"     =>  $rows['CREATEDDATE'],
        "modifiedBy"      =>  $rows['MODIFIEDBY'],
        "modifiedDate"    =>  $rows['MODIFIEDDATE']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}

?>