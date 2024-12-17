//idで要素を取得する
const cells = document.querySelectorAll('td');
const replay = document.getElementById('replay');
//function GameStart(){
//定数＆変数の定義
const player = ["〇", "✕"];
const cell_style = ["maru", "batu"];
let round = 0;
let currentPlayer;

let board = Array(9).fill('');
let gameover = false;
let result = 3;	
//}

//clickイベント
cells.forEach(cell => {
	cell.addEventListener('click', () => {
		let index = cell.dataset.index;
		//GameStart();
		if (board[index] === "" && !gameover) {
			//プレーヤーの変更
			currentPlayer = player[round % 2];
			document.getElementById("turn-text").innerHTML = `${player[(round + 1) % 2]}の番です。`;
			cell.classList.add(cell_style[round % 2]);
			
			/*if (round % 2 === 1) {
				cell.classList.add("maru");
			} else {
				cell.classList.add("batu");
			}*/

			board[index] = currentPlayer;
			round++;
			checkWinner();
			//POST();			
		}
	});
});

const winningPatterns = [
	[0,1,2],
	[3,4,5],
	[6,7,8],
	[0,3,6],
	[1,4,7],
	[2,5,8],
	[0,4,8],
	[2,4,6]
]

function checkWinner() {
	//勝負判断(result:0->maru win; result:1->batu; result:2->draw)
	for (let pattern of winningPatterns) {
		const [a, b, c] = pattern;
		if (board[a]=== player[0] && board[a] === board[b] && board[a] === board[c]) {
			gameover = true;
			document.getElementById("turn-text").innerHTML = `${board[a]}の勝ちです！`;
			replay.classList.replace("none", "replay");
			return result = 0;
		}else if(board[a]=== player[1] && board[a] === board[b] && board[a] === board[c]){
			gameover = true;
			document.getElementById("turn-text").innerHTML = `${board[a]}の勝ちです！`;
			replay.classList.replace("none", "replay");
			return result = 1;
		}
	}
	//引き分け判断
	if (!board.includes('') && gameover == false) {
		gameover = true;
		document.getElementById("turn-text").innerHTML = `引き分けです！`;
		replay.classList.replace("none", "replay");
		return result = 2;
	}
}


//replayイベント
replay.addEventListener("click", () => {
	Replay();
})

function Replay(){
	round = 0;
	board = Array(9).fill('');
	gameover = false;
	
	cells.forEach(cell =>{
		cell.classList.remove(cell_style[0],cell_style[1]);
	});
	replay.classList.replace("replay","none");
	document.getElementById("turn-text").innerHTML = `再開！`;
}


//robot player


//resultをPHPに送信
function POST(){
fetch('./newfile.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ result: result })
})
.then(response => {
    if (!response.ok) {
        throw new Error(`HTTPエラー! ステータス: ${response.status}`);
    }
    return response.json();
})
.then(data => {
    return data;
})
//.then(location.reload())
.catch(error => {
    console.error('送信エラー:', error);
});
}
