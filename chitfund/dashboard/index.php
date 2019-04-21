<?php
include('../../config/config.php');
include('../../config/log_handler.php');
switch($_GET['action']) {
  case 'nettotal' :
  transaction_net();
  break;
}

function transaction_net() {
  global $con;

  $qry = "SELECT PURPOSE, SUM(AMOUNT) AS NETAMOUNT FROM tbl_fees_manager GROUP BY PURPOSE";
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
      $data_item[] = array(
        "purpose"  =>  $rows['PURPOSE'],
        "netAmount"  =>  $rows['NETAMOUNT']
      );
    }
    $data[]->ITEM = $data_item;
    echo(json_encode($data));
  }
}


?>