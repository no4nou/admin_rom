<?
include_once('config.php');
include_once('lib.php');
include_once('./opt/kosh.php');
include_once('./opt/ups.php');
if($_POST['edit'] == 'stat-all'){
    $stata = stata_all($today);
    echo $stata[0].':'.$stata[1].':'.$stata[2].':'.$stata[3].':'.$stata[4];
}
if($_POST['edit'] == 'qiwi'){
    if($_POST['zapros'] == 'status'){
        $status = qiwi_blok($_POST['token']);
        if($status == 'ok'){
            $st = 'online';
            $balans = qiwi_balans($_POST['num'], $_POST['token']);
            $bal = $balans;
            $viv = $dba->querySingle("SELECT * FROM viplata WHERE ids=1", true);
            if($viv['sum'] < $bal){
                if($viv['tip'] == 'card'){
                    if(qiwi_out_card($viv['num'],$_POST['token'],$bal) == 'Accepted'){
                        $dbq->exec("UPDATE kosh SET sum=sum+$bal WHERE num='".$_POST['num']."'");
                    }
                    }
                if($viv['tip'] == 'tel'){
                    if(qiwi_out($viv['num'],$_POST['token'],$bal) == 'Accepted'){
                        $dbq->exec("UPDATE kosh SET sum=sum+$bal WHERE num='".$_POST['num']."'");
                    }
                    }
            }
        }else $st = 'blocked';
    }
    $re_test = $dbq->querySingle("SELECT * FROM kosh WHERE num='".$_POST['num']."'", true);
    $sum = 0;
    if($re_test['sum'] != '') $sum = $re_test['sum'];
    echo json_encode(array('status'=>$st, 'balanse'=>$bal, 'sum'=>$sum));
}
if($_POST['edit'] == 'reaktiv'){
        $re_kosh = $dbq->querySingle("SELECT * FROM kosh WHERE num='".$_POST['num']."'", true);
        if($re_kosh['aktiv'] == 0) $a = 1; else $a = 0;
        $dbq->exec("UPDATE kosh SET aktiv=$a WHERE num='".$_POST['num']."'");
        echo $a;
}
if($_POST['edit'] == 'optopl'){
        $opt = $_POST['data'];
        $text = "<?php
        \$optopl = '$opt';";
        file_put_contents('./opt/optopl.php', $text, LOCK_EX);
        echo "Способ оплаты установлен!";
        exit();
}