<?php
if (isset($_POST['result'])) {
    $result = $_POST['result'];
    
    // 結果に応じて処理を行う
    if ($result === 'win') {
        echo "あなたの勝ちです！";
    } elseif ($result === 'lose') {
        echo "あなたの負けです。";
    } else {
        echo "引き分けです。";
    }
}
?>


<?php
class playerResult {
    private $id;
    private $player;
    private $win;
    private $lose;
    private $draw;
    private $rate;
    private $update;
    
    public function __construct($id,$player,$win, $lose, $draw, $rate,$update) {
        $this->id = $id;
        $this->player = $player;
        $this->win = $win;
        $this->lose = $lose;
        $this->draw = $draw;
        $this->rate = $rate;
        $this->update = $update;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getPlayer(){
        return $this->player;
    }
    
    public function getWin(){
        return $this->win;
    }
    
    public function getLose(){
        return $this->lose;
    }
    
    public function getDraw(){
        return $this->draw;
    }
    
    public function calculateRate(){
        return $this->rate;
    }
    
    public function getUpadte(){
        return $this->update;
    }
}
?>