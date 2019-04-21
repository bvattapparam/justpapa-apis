<?php
include('../../config/config.php');
include('../../config/log_handler.php');

category_add();

/** Function to Push Product **/
function category_add() {
    global $con;
    $data = json_decode(file_get_contents("php://input"));

    $CATEGORY           =   strtoupper($data->category);
    $CODE               =   strtoupper($data->code);
    $CREATEDBY          =   $data->createdBy;
    $MODIFIEDBY         =   $data->createdBy;
    $STATUS             =   1;
    $qry_count = mysqli_query($con,"SELECT * from tbl_category WHERE CODE = '$CODE'");
    $num_rows = mysqli_num_rows($qry_count);

    if($num_rows > 0){
        $arr = array('msg' => "", 'error' => 'E_CATEGORY_AVAILABLE');
        $jsn = json_encode($arr);
        print_r($jsn);
    }else{
        $qry = "INSERT INTO tbl_category (CATEGORY, CODE, CREATEDBY, MODIFIEDBY) VALUES ('$CATEGORY', '$CODE', '$CREATEDBY', '$MODIFIEDBY')";
        $result = mysqli_query($con,$qry);
        if(!$result){
            $arr = array('msg' => "", 'error' => 'E_UNKNOWN');
            $jsn = json_encode($arr);
            trigger_error("Issue with mysql_query. Please check the detailed log", E_USER_NOTICE);
            trigger_error(mysqli_error());
            print_r($jsn);
        }else{
            $arr = array('msg' => 'S_CATEGORY_ADDED', 'error' => '');
            $jsn = json_encode($arr);
            print_r($jsn);
        } 
    }
    

}
?>
