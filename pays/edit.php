<?
include_once('../admin/lib.php');
if(!empty($_REQUEST['tip']) && !empty($_REQUEST['data'])){
    if($_REQUEST['tip'] == 'opl'){
        $dann = explode(':', $_REQUEST['data']);
        $order = order_form($dann[0],'../step/stata/');
        //print_r($order);
        if($order['success'] == 1){
            stata_edit($dann[1],$dann[2],date("d.m.Y"),'../step/stata/');
            echo 1;
        }
        exit();
    }
}