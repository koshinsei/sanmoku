//要素を取得
const cells = document.querySelectorAll('td');
const replay = document.getElementById('replay');
//定数＆変数の定義
const player = ["〇", "✕"];
const cell_style = ["maru", "batu"];
let round = 0;
let currentPlayer;
let board = Array(9).fill('');
let gameover = false;
let result;


//clickイベント
cells.forEach(cell => {
	cell.addEventListener('click', () => {
		let index = cell.dataset.index;
		if (board[index] === "" && !gameover) {
			Player(index);
			checkWinner();
			if (!gameover) {
				Robot();
				checkWinner();
			}
		}
	});
});
//player
function Player(index) {

	//プレーヤーの変更
	currentPlayer = player[round % 2];
	board[index] = currentPlayer;
	//document.getElementById("turn-text").innerHTML = `${player[(round + 1) % 2]}の番です。`;
	let position = document.getElementById(`cell-${index}`);
	position.classList.add(cell_style[round % 2]);
	round++
	return board[index];
}

//robot player
function Robot() {
	let empty_cells = emptyCheck();
	if (empty_cells.length > 0) {
		robot_position = empty_cells[Math.floor(Math.random() * empty_cells.length)];
		document.getElementById(`cell-${robot_position}`).classList.add(cell_style[round % 2]);
		board[robot_position] = player[round % 2];
		round++;
		return board[robot_position];
	}
}
//empty check
function emptyCheck() {
	let empty_cells = [];
	for (let i = 0; i < board.length; i++) {
		if (board[i] === "") {
			empty_cells.push(i);
		}
	}
	return empty_cells;
}

const winningPatterns = [
	[0, 1, 2],
	[3, 4, 5],
	[6, 7, 8],
	[0, 3, 6],
	[1, 4, 7],
	[2, 5, 8],
	[0, 4, 8],
	[2, 4, 6]
]

function checkWinner() {
	//勝負判断(result:0->maru win; result:1->batu; result:2->draw)
	for (let pattern of winningPatterns) {
		const [a, b, c] = pattern;
		if (board[a] === player[0] && board[a] === board[b] && board[a] === board[c]) {
			gameover = true;
			document.getElementById("turn-text").innerHTML = `${board[a]}の勝ちです！`;
			replay.classList.replace("none", "replay");
			result = 0;
			JsPost();
			return;

		} else if (board[a] === player[1] && board[a] === board[b] && board[a] === board[c]) {
			gameover = true;
			document.getElementById("turn-text").innerHTML = `${board[a]}の勝ちです！`;
			replay.classList.replace("none", "replay");
			result = 1;
			JsPost();
			return;
		}
	}
	//引き分け判断
	if (!board.includes('') && gameover == false) {
		gameover = true;
		document.getElementById("turn-text").innerHTML = `引き分けです！`;
		replay.classList.replace("none", "replay");
		result = 2;
		JsPost();
		return;
	}
}


//replayイベント
replay.addEventListener("click", () => {
	Replay();
	location.reload();
});

function Replay() {
	round = 0;
	board = Array(9).fill('');
	gameover = false;

	cells.forEach(cell => {
		cell.classList.remove(cell_style[0], cell_style[1]);
	});
	replay.classList.replace("replay", "none");
	document.getElementById("turn-text").innerHTML = `再開！`;
}




//resultをPHPに送信
function JsPost() {
	fetch('./updateDB.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json' // JSON形式でデータ送信
		},
		body: JSON.stringify({ result: result }) // JSONオブジェクトを送信
	})
		.then(data => {
			return data;
		})
		//.then(location.reload())
		.catch(error => {
			console.error('送信エラー:', error);
		});
}
