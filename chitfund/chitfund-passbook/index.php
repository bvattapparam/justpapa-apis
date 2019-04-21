<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'fullview' :
  chitfund_passbook_fullview();
  break;
  case 'byChitId' :
  passbookByChitId();
  break;
  case 'byPassbookId' :
  passbookByPassbookId();
  break;
}

/** Function to Get Product **/
function passbookByChitId() {
  global $con;
  $CHITID = $_GET['chitId'];
  
  $qry = "SELECT * FROM ng_chitfund_passbook WHERE CHITID = '$CHITID' ORDER BY MONTH DESC";
  $result = mysqli_query($con,$qry);
//echo $qry;
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
        "chitId"          =>  $rows['CHITID'],
        "passbookId"      =>  $rows['PASSBOOKID'],
        "month"           =>  $rows['MONTH'],
        "payMode"         =>  $rows['PAYMODE'],
        "amount"          =>  $rows['AMOUNT'],
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

/** Function to Get Product **/
function passbookByPassbookId() {
  global $con;
  $PASSBOOKID = $_GET['passbookId'];
  
  $qry = "SELECT * FROM ng_chitfund_passbook WHERE PASSBOOKID = '$PASSBOOKID'";
  $result = mysqli_query($con,$qry);
//echo $qry;
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
        "passbookId"      =>  $rows['PASSBOOKID'],
        "chitId"          =>  $rows['CHITID'],
        "month"           =>  $rows['MONTH'],
        "payMode"         =>  $rows['PAYMODE'],
        "amount"          =>  $rows['AMOUNT'],
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