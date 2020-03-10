<?
include_once('./config.php');
include_once('./lib.php');
if(!empty($_POST['tip'])){
    if($_POST['tip'] == 'vipl'){
        $opt = explode(':', $_POST['data']);
        //$dba = new SQLite3('./database/viplata.db');
          $re_test = $dba->querySingle("SELECT * FROM viplata WHERE ids=1");
			if(!empty($re_test)){
    			$dba->exec("UPDATE viplata SET sum='$opt[0]', num='$opt[1]', tip='$opt[2]' WHERE ids=1");
                $kos = 'update';
			}else{
                $dba->exec("INSERT INTO viplata VALUES (1, '$opt[0]', '$opt[1]', '$opt[2]')");
                $kos = 'insert';
			}
            echo $kos;
    }
    if($_POST['tip'] == 'system'){
        $opt = json_decode($_POST['data']);
        $text = "<?php
        \$system = array(
            ";
        $text .= "'api_domain' => '".$opt->api_domain."',
            'offer_domain' => '".$opt->offer_domain."',
            ";
        $text .= ");";
        file_put_contents('./opt/plserv.php', $text, LOCK_EX);
        echo "Настройки записаны!";
        exit();
    }
    if($_POST['tip'] == 'billix'){
        $opt = json_decode($_POST['data']);
        $text = "<?php
        \$billix = array(
            ";
            $text .= "'mid' => '".$opt->mid."',
            'api_key' => '".$opt->api_key."',
            'secret_key' => '".$opt->secret_key."',
            ";
        $text .= ");";
        file_put_contents('./opt/billix.php', $text, LOCK_EX);
        echo "Настройки записаны!";
        exit();
    }
    if($_POST['tip'] == 'kosh'){
        $opt = $_POST['data'];
        $text = "<?php
        \$arr = array(
            ";
        foreach($opt as $value){
            $text .= "'$value',
            ";
        }
        $text .= ");";
        file_put_contents('./opt/kosh.php', $text, LOCK_EX);
        echo "Кошельки успешно записаны!";
        exit();
    }
    if($_POST['tip'] == 'delkosh'){
        $id = $_POST['data'] + 1;
        $dbq->exec("DELETE FROM kosh WHERE id=$id");
        for($i =  0; $i < 10; $i++){
            $id = $i + 1;
            $newid = $i + 2;
            $re_test = $dbq->querySingle("SELECT * FROM kosh WHERE id=$id");
			if(empty($re_test)){
				@$dbq->exec("UPDATE kosh SET id=$id WHERE id=$newid");
			}
        }
        echo 'Успешно';
    }
    if($_POST['tip'] == 'qkosh'){
        $opt = explode(':', $_POST['data']);
        if($opt[1] == ''){echo 'Не указан номер кошелька!'; exit();}
        if($opt[2] == ''){echo 'Не указан token кошелька!'; exit();}
        if(qiwi_blok($opt[2]) == 'block'){echo 'Кошелек заблокирован или неверный токен!'; exit();}
        $hook = qiwi_hook_see($opt[2]);
        $err = '';
        if($hook == 'no'){
            $hook = qiwi_hook_add($opt[2]);
            if($hook == 'no') $err = "no";
        }else{
            qiwi_hook_del($hook,$opt[2]);
            $hook = qiwi_hook_add($opt[2]);
            if($hook == 'no') $err = "no";
        }
        if($err != 'no'){
        $re_test = $dbq->querySingle("SELECT * FROM kosh WHERE num='$opt[1]'");
			if(!empty($re_test)){
			 $key = qiwi_key_reload($hook, $opt[2]);
				$dbq->exec("UPDATE kosh SET token='$opt[2]', hook='$hook', key='$key', status=1 WHERE num='$opt[1]'");
                $kos = 'update';
			}else{
             $key = qiwi_key($hook, $opt[2]);
             if($key == ''){echo 'Не могу получить key'; exit();}
                $dbq->exec("INSERT INTO kosh VALUES (".($opt[0]+1).", '$opt[1]','$opt[2]','$hook','$key',1,0,0,1)");
                $kos = 'insert';
			}
            $dbq->close();
        }else{
            $kos = 'no';
        }
        echo json_encode(array('kos'=>$kos,'id'=>($opt[0]+1),'num'=>$opt[1],'token'=>$opt[2],'hook'=>$hook,'key'=>$key,'status'=>'detecting','sum'=>'detecting','blok'=>0,'aktiv'=>0));
        exit();
    }
    if($_POST['tip'] == 'aps'){
        $url = $_POST['url'];
        $sum = $_POST['sum'];
        $text = "<?php
        \$url = array(
            ";
        foreach($url as $value){
            $text .= "'$value',
            ";
        }
        $text .= ");
        \$sum = array(
            ";
        foreach($sum as $value){
            $text .= "'$value',
            ";
        }
        $text .= ");";
        
        file_put_contents('./opt/ups.php', $text, LOCK_EX);
        echo "Настройки цен успешно записаны!";
        exit();
    }
}