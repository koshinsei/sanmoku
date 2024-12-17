<?php
$json = file_get_contents('php://input');
$data = json_decode($json, true); // JSONを配列としてデコード
$result = $data['result'] ?? null;

//セッション開始
session_start();
if(!empty($result)){
    $_SESSION["result" ][]=$result;
}
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
$player_results = $stmt ->fetchAll(PDO::FETCH_ASSOC);

try {
    $pdo -> beginTransaction();
    
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        if ($result == 0) {
            $sql_1 = "UPDATE game_result SET win = win + 1 WHERE id = 1";
            $sql_2 = "UPDATE game_result SET lose = lose + 1 WHERE id = 2";
        } elseif ($result == 1) {
            $sql_1 = "UPDATE game_result SET lose= lose + 1 WHERE id = 1";
            $sql_2 = "UPDATE game_result SET win = win + 1 WHERE id = 2";
        } elseif ($result == 2) {
            $sql_1 = "UPDATE game_result SET draw= lose + 1 WHERE id = 1";
            $sql_2 = "UPDATE game_result SET draw = win + 1 WHERE id = 2";
        }

        $stmt = $pdo->prepare($sql_1);
        $stmt = execute();
        
        $stmt = $pdo->prepare($sql_2);
        $stmt = execute();
        
        // トランザクションの確定
        $pdo->commit();
        echo "データベースを正常に更新しました。";
        
        exit;
     }else{
        echo "no updating";
        echo $result;
    } 
} catch (Exception $e){
    $pdo->rollBack();
    echo 'トランザクション失敗: ' . $e->getMessage();
}

?>