<?php
//セッション開始
session_start();

//PDOでデータベース接続
$db_user = "root" ;
$db_pass = "password" ;
$db_host = "localhost" ;
$db_name = "pineapple" ;
$db_type = "mysql" ;

$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8" ;
try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
    $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE) ;
    print "接続しました...<br>" ;
} catch (PDOException $Exception) {
    die("エラー：".$Exception -> getMessage()) ;
}

$stmt = $pdo -> query('SELECT  * FROM game_result' ) ;
$result = $stmt ->fetchAll(PDO::FETCH_ASSOC);
?>