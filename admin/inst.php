<?
$pass = 'z11102006'; //пароль админа

$today = date("d.m.Y"); 
if(!file_exists('../step/stata/'.$today.'.db')){
    $db = new SQLite3('../step/stata/'.$today.'.db');
    $db->exec("CREATE TABLE 'user'
               ('ip' VARCHAR(20), 
               'open' INT(11), 
               'oplata' INT(11), 
               'sum' INT(11), 
               'success' INT(11), 
               'succsumm' INT(11))");
}else{
    $db = new SQLite3('../step/stata/'.$today.'.db');
}
if(!file_exists('./database/vipl.db')){
    $dbv = new SQLite3('./database/vipl.db');
    $dbv->exec("CREATE TABLE 'vipl'
               ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
               'sum' INT(11),
               'num' TEXT, 
               'tip' TEXT)");
}else{
    $dbv = new SQLite3('./database/vipl.db');
    //79803301604  5f5cfd5d22698846ea190c752d560a82
}
if(!file_exists('./database/qkosh.db')){
    $dbq = new SQLite3('./database/qkosh.db');
    $dbq->exec("CREATE TABLE 'kosh'
               ('id' INT(11),
               'num' TEXT, 
               'token' TEXT, 
               'hook' TEXT, 
               'key' TEXT, 
               'status' INT(11), 
               'sum' VARCHAR(20), 
               'blok' INT(11),
               'aktiv' INT(11))");
}else{
    $dbq = new SQLite3('./database/qkosh.db');
}
//header("Location: ./");