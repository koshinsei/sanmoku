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
//セッション開始
session_start();

//データベース接続
require_once 'connectDB.php' ;
$pdo=connectDB();

$stmt = $pdo -> query('SELECT id, player, win, lose, draw  FROM game_result' ) ;
$player_results = $stmt ->fetchAll(PDO::FETCH_ASSOC);
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
       </tr> 
<?php foreach ($player_results as $player_result) {?>
<tr>
<?php foreach ($player_result as $key => $value) {?>
   <td id="<?php echo htmlspecialchars($key)?>"><?php echo htmlspecialchars($value)?></td>  
  <?php };?>  
  <td id = "rate"><?php echo sprintf("%.2f%%", ($player_result["win"] / ($player_result["win"] +$player_result["lose"]+ $player_result["draw"] )) * 100)?></td>
<!--   <td></td> -->
</tr>
<?php }?>   
      </table>
    </form>
  </div>
  <div>
  
  </div>
  <div>
  <form>
  
  </form>
  </div>
  <div class="game-container">
    <p class="message" id="turn-text"></p>
    <table class="game-board">
      <tr>
        <td id="cell-0" data-index="0"></td>
        <td id="cell-1" data-index="1"></td>
        <td id="cell-2" data-index="2"></td>
      </tr>
      <tr>
        <td id="cell-3" data-index="3"></td>
        <td id="cell-4" data-index="4"></td>
        <td id="cell-5" data-index="5"></td>
      </tr>
      <tr>
        <td id="cell-6" data-index="6"></td>
        <td id="cell-7" data-index="7"></td>
        <td id="cell-8" data-index="8"></td>
      </tr>
    </table>
    <button class="none" id="replay">再開</button>
  </div>

  <script src="js/marubatu.js"></script>
</body>
</html>
