<?
include_once('config.php');
include_once('lib.php');

if($_REQUEST['tip'] == 'card'){
    $bal = $_REQUEST['sum'];
    $r = qiwi_out_card($_REQUEST['numvivod'],$_REQUEST['token'],$bal);
    if($r == 'Accepted'){
        $dbq->exec("UPDATE kosh SET sum=sum+$bal WHERE num='".$_POST['num']."'");
    }
}
if($_REQUEST['tip'] == 'tel'){
    $r = qiwi_out($_REQUEST['numvivod'],$_REQUEST['token'],$bal);
    if($r == 'Accepted'){
        $dbq->exec("UPDATE kosh SET sum=sum+$bal WHERE num='".$_POST['num']."'");
    }
    }
echo $r;