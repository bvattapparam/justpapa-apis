<?php
include('../../config/config.php');
include('../../config/log_handler.php');

//get_reference_data();
get_public_data();
function get_public_data() {
  global $con;
  // Fetch Reference details with category...
  $qry = "select * from tbl_reference WHERE STATUS = 1 ORDER BY CATEGORYCODE";
  $result = mysqli_query($con, $qry);
  $DATA  = array();
  while($rows	=	mysqli_fetch_array($result)){
    $data[]	=	array(
      "ID"          	=>  $rows['ID'],
      "CODE"   		    =>  $rows['CODE'],
      "NAME"      	  =>  $rows['NAME'],
      "STATUS"    	  =>  $rows['STATUS'],
      "CATEGORYCODE"    	  =>  $rows['CATEGORYCODE']
      );
  };
  $output = [];
  foreach($data as $element) {
    $output[$element['CATEGORYCODE']][] = ['value' => $element['CODE'], 'name' => $element['NAME']];
  }

  // Fetch Category...
  $qry_cat = "select * from tbl_category ORDER BY CATEGORY ASC";
  $result_cat = mysqli_query($con, $qry_cat);
  $DATA_CAT  = array();
  while($rows_cat	=	mysqli_fetch_array($result_cat)){
    $data_cat[]	=	array(
      "ID"          	    =>  $rows_cat['ID'],
      "CODE"   		        =>  $rows_cat['CODE'],
      "CATEGORY"      	  =>  $rows_cat['CATEGORY'],
      );
  };
  $refCategory = [];
  $refCategory = $data_cat;

  $defaultParam = array();
  $defaultParam['references'] = $output;
  $defaultParam['refcategory'] = $refCategory;
  echo(json_encode($defaultParam));

}
?>
