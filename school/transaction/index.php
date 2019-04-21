<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'viewtranx' :
  transaction_view();
  break;
  case 'byFeesId' :
  transaction_byFeesId();
  break;
}

function transaction_view() {
  global $con;
  $data = json_decode(file_get_contents("php://input"));
  $limit              =   $data->limit;
  $offset             =   $data->offset;
  $pagenation         =   $data->pagenation;

  if($pagenation){
    $qry = "SELECT * FROM tbl_fees_manager ORDER BY MODIFIEDDATE DESC LIMIT $limit OFFSET $offset";
  } else {
    $qry = "SELECT * FROM tbl_fees_manager ORDER BY MODIFIEDDATE DESC";
  }
  $qry_res = mysqli_query($con,$qry);

  $qry_count = mysqli_query($con,"SELECT * FROM tbl_fees_manager");
  $num_rows = mysqli_num_rows($qry_count);

  if(!$qry_res){
    $arr = array('msg' => "", 'error' => $qry.'Unknown Exception occurred. Please check the application log for more details.');
    $jsn = json_encode($arr);
    trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
    trigger_error(mysqli_error());
    print_r($jsn);
  }else{
    $data = array();
    while($rows = mysqli_fetch_array($qry_res))
    {
      $data_item[] = array(
        "id"            =>  $rows['ID'],
        "feesId"        =>  $rows['FEESID'],
        "month"         =>  $rows['MONTH'],
        "amount"        =>  $rows['AMOUNT'],
        "purpose"       =>  $rows['PURPOSE'],
        "person"        =>  $rows['PERSON'],
        "institution"   =>  $rows['INSTITUTION'],
        "status"        =>  $rows['STATUS'],
        "comment"       =>  $rows["COMMENT"],
        "createdBy"     =>  $rows['CREATEDBY'],
        "createdDate"   =>  $rows['CREATEDDATE'],
        "modifiedBy"    =>  $rows['MODIFIEDBY'],
        "modifiedDate"  =>  $rows['MODIFIEDDATE']
      );
    }
    $data_total=array("collectionSize"=> $num_rows);
    $data[]->ITEM = $data_item;
    $data[]->TOTAL = $data_total;
    echo(json_encode($data));
  }
}

/** Function to Get Product **/
function transaction_byFeesId() {
  global $con;
  $FEESID = $_GET['feesId'];
  
  $qry = "SELECT * FROM tbl_fees_manager WHERE FEESID = '$FEESID'";
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
        "feesId"        =>  $rows['FEESID'],
        "month"        =>  $rows['MONTH'],
        "amount"        =>  $rows['AMOUNT'],
        "purpose"        =>  $rows['PURPOSE'],
        "person"        =>  $rows['PERSON'],
        "institution"        =>  $rows['INSTITUTION'],
        "status"        =>  $rows['STATUS'],
        "createdBy"   =>  $rows['CREATEDBY'],
        "createdDate"   =>  $rows['CREATEDDATE'],
        "modifiedBy"  =>  $rows['MODIFIEDBY'],
        "modifiedDate"  =>  $rows['MODIFIEDDATE'],
        "comment"        =>  $rows['COMMENT']
      );
    }
    echo(json_encode($data));
    return json_encode($data);  
  }
}

?>