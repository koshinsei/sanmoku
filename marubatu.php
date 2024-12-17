<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>三目並べゲーム</title>
<link href="css/marubatu.css" rel="stylesheet">
<link href="css/normalize.css" rel="stylesheet">
</head>
<body>

<?php 
/* $json = file_get_contents('php://input');
$data = json_decode($json, true); // JSONを配列としてデコード
$result = $data['result'] ?? null; */

//セッション開始
session_start();
if(!empty($result)){
    $_SESSION["result" ]=$result;
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

$stmt = $pdo -> query('SELECT id, player, win, lose, draw  FROM game_result' ) ;
$player_results = $stmt ->fetchAll(PDO::FETCH_ASSOC);

/* try {
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
        $stmt -> execute();
        
        $stmt = $pdo->prepare($sql_2);
        $stmt -> execute();
        
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
} */
?>
  <div class="result-calculator">
    <form action="marubatu.php"  method="POST">
      <table class="result-table">
        <tr>
        <th>ID</th>
          <th>Player</th>
          <th>勝ち</th>
          <th>負け</th>
          <th>引分け</th>
          <th>勝率</th>
<!--          <th>更新時間</th> -->
       </tr> 
<?php foreach ($player_results as $player_result) {?>
<tr>
<?php foreach ($player_result as $key => $result) {?>
   <td id="<?php echo htmlspecialchars($key)?>"><?php echo htmlspecialchars($result)?></td>
  <?php };?>  
  <td id = "rate"></td>
<!--   <td></td> -->
</tr>
<?php }?>   
      </table>
      <input type="submit" value="Submit">
    </form>
  </div>
  <div>
  
  </div>
  <div class="game-container">
    <p class="message" id="turn-text"></p>
    <table class="game-board">
      <tr>
        <td id="cell-1" data-index="0"></td>
        <td id="cell-2" data-index="1"></td>
        <td id="cell-3" data-index="2"></td>
      </tr>
      <tr>
        <td id="cell-4" data-index="3"></td>
        <td id="cell-5" data-index="4"></td>
        <td id="cell-6" data-index="5"></td>
      </tr>
      <tr>
        <td id="cell-7" data-index="6"></td>
        <td id="cell-8" data-index="7"></td>
        <td id="cell-9" data-index="8"></td>
      </tr>
    </table>
    <button class="none" id="replay">再開</button>
  </div>
 
  <script src="js/marubatu.js"></script>
</body>
</html>
