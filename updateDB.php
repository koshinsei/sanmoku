<?php
$json = file_get_contents('php://input');
$data = json_decode($json, true); // JSONを配列としてデコード
$result = $data['result' ] ?? null;  

require_once 'connectDB.php' ;
$pdo=connectDB();

$stmt = $pdo -> query('SELECT id, player, win, lose, draw  FROM game_result' ) ;

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
            $sql_1 = "UPDATE game_result SET draw= draw + 1 WHERE id = 1";
            $sql_2 = "UPDATE game_result SET draw = draw + 1 WHERE id = 2";
        }
        
        $stmt = $pdo->prepare($sql_1);
        $stmt -> execute();
        
        $stmt = $pdo->prepare($sql_2);
        $stmt -> execute();
        
        // トランザクションの確定
        $pdo->commit();
        
        //exit;
    }else{
        //echo "no updating";
        echo $result;
    }
} catch (Exception $e){
    $pdo->rollBack();
    echo 'トランザクション失敗: ' . $e->getMessage();
}    
?>