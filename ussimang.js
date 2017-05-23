var canvas;
var ctx;
var direction;
var score = 0;
var keyPressed = "";
var refreshInterval;

//snake
var snakeRect = 20;
var snakeSpeed = 200;
var snakeTailX = [];
var snakeTailY = [];
var snakeX = 240;
var snakeY = 240;

//food
var foodRect = 20;
var foodX;
var foodY;

window.onload = function(){
	canvas = document.getElementById("paber");
	ctx = canvas.getContext("2d");
	document.getElementById("startBtn").addEventListener("click", startGame);
}

function startGame(){
	document.getElementById("startBtn").innerHTML = "Game Started";
	document.getElementById("startBtn").removeEventListener("click", startGame);
	console.log("Game started!")
	window.addEventListener("keydown", whatKey);
	drawSnake();
	drawFood();
}

function whatKey(e){
	setTimeout(function(){
		if(e.keyCode == 38){
			if(keyPressed == "down" || keyPressed == "up"){} 
			else{
				clearInterval(refreshInterval);
				keyPressed = "up";
				moveUp();
			}
		}
		if(e.keyCode == 40){
			if(keyPressed == "up" || keyPressed == "down"){}
			else{
				clearInterval(refreshInterval);
				keyPressed = "down";
				moveDown();
			}
		}
		if(e.keyCode == 37){
			if(keyPressed == "right" || keyPressed == "left"){}
			else{
				clearInterval(refreshInterval);
				keyPressed = "left";
				moveLeft();
			}
		}
		if(e.keyCode == 39){
			if(keyPressed == "left" || keyPressed == "right"){}
			else{
				clearInterval(refreshInterval);
				keyPressed = "right";
				moveRight();
			}
		}
	}, snakeSpeed);
}

function drawSnake(){
	//kontrollib kas uss on läinud üle canvase ääre
	if(snakeX<(canvas.width-canvas.width)){
		snakeX = canvas.width-snakeRect;
	}
	if(snakeX>canvas.width-snakeRect){
		snakeX = 0;
	}
	if(snakeY<(canvas.height-canvas.height)){
		snakeY = canvas.height-snakeRect;
	}
	if(snakeY>canvas.height-snakeRect){
		snakeY = 0;
	}
	
	//joonistab ussi
	ctx.beginPath();
		ctx.rect(snakeX, snakeY, snakeRect, snakeRect);
		ctx.fill();
	ctx.closePath();
	//kontrollib, kas toit on söödud
	eatFood();
}

function eatFood(){
	if(foodX == snakeX && foodY == snakeY){
		score++;
		document.getElementById("score").innerHTML = score;
		drawFood();
	}
}

function drawFood(){
	var canvasDivided = canvas.width/snakeRect-1;
	foodX = Math.round(Math.random()*canvasDivided)*snakeRect;
	foodY = Math.round(Math.random()*canvasDivided)*snakeRect;
	ctx.beginPath();
		ctx.rect(foodX, foodY, foodRect, foodRect);
		ctx.fill();
	ctx.closePath();
	console.log(foodX, foodY, foodRect, foodRect);
}

function moveUp(){
	if(keyPressed == "up"){
		ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
		snakeY = snakeY - snakeRect;
		drawSnake();
		refreshInterval = setInterval(function(){
			ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
			snakeY = snakeY - snakeRect;
			drawSnake();}, snakeSpeed);
	}
}

function moveDown(){
	if(keyPressed == "down"){
		ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
		snakeY = snakeY + snakeRect;
		drawSnake();
		refreshInterval = setInterval(function(){
			ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
			snakeY = snakeY + snakeRect;
			drawSnake();}, snakeSpeed);
	}
}

function moveLeft(){
	ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
		snakeX = snakeX - snakeRect;
		drawSnake();
	if(keyPressed == "left"){
		refreshInterval = setInterval(function(){
			ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
			snakeX = snakeX - snakeRect;
			drawSnake();}, snakeSpeed);
	}
}

function moveRight(){
	if(keyPressed == "right"){
		ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
		snakeX = snakeX + snakeRect;
		drawSnake();
		refreshInterval = setInterval(function(){
			ctx.clearRect(snakeX, snakeY, snakeRect, snakeRect);
			snakeX = snakeX + snakeRect;
			drawSnake();}, snakeSpeed);
	}
}