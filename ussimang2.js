var canvas;
var ctx;
var direction;
var score = 1;
var keyPressed = "";
var refreshInterval;

//snake
var snakeRect = 20;
var snakeSpeed = 200;
var snakeTailX = [];
var snakeTailY = [];
var snakeX = 240;
var snakeY = 240;
snakeTailX[0] = snakeX;
snakeTailY[0] = snakeY;


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
	newFood();
	drawSnake();
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
	//puhastab canvase
	canvas.width = canvas.width;
	//kontrollib kas uss on läinud üle canvase ääre
	/*
	if(snakeTailX[snakeTailX.length-1]<(canvas.width-canvas.width)){
		snakeX = canvas.width-snakeRect;
	}
	if(snakeTailX[snakeTailX.length-1]>canvas.width-snakeRect){
		snakeX = 0;
	}
	if(snakeTailY[snakeTailY.length-1]<(canvas.height-canvas.height)){
		snakeY = canvas.height-snakeRect;
	}
	if(snakeTailY[snakeTailY.length-1]>canvas.height-snakeRect){
		snakeY = 0;
	}*/
	
	if(score == snakeTailX.length){
		snakeTailX.splice(0, 1);
		snakeTailY.splice(0, 1);
	}
	
	for(var i = 0; i==score; i++){
		ctx.beginPath();
			ctx.rect(snakeTailX[i], snakeTailY[i], snakeRect, snakeRect);
			ctx.fill();
		ctx.closePath();

	}
	
	
	//joonistab ussi
	/*ctx.beginPath();
		ctx.rect(snakeX, snakeY, snakeRect, snakeRect);
		ctx.fill();
	ctx.closePath();*/
	//joonistab toidu
	drawFood();
	//kontrollib, kas toit on söödud
	eatFood();
}

function drawFood(){
	ctx.beginPath();
		ctx.rect(foodX, foodY, foodRect, foodRect);
		ctx.fill();
	ctx.closePath();
}

function eatFood(){
	if(foodX == snakeX && foodY == snakeY){
		score++;
		document.getElementById("score").innerHTML = score;
		newFood();
	}
}

function newFood(){
	var canvasDivided = canvas.width/snakeRect-1;
	foodX = Math.round(Math.random()*canvasDivided)*snakeRect;
	foodY = Math.round(Math.random()*canvasDivided)*snakeRect;
	console.log(foodX, foodY, foodRect, foodRect);
}

function moveUp(){
	if(keyPressed == "up"){
		console.log(snakeTailY, snakeTailY);
		snakeY = snakeTailY[snakeTailY.length-1] - snakeRect;
		snakeTailX.push(snakeX);
		snakeTailY.push(snakeY);
		drawSnake();
		refreshInterval = setInterval(function(){
			snakeY = snakeTailY[snakeTailY.length-1] - snakeRect;
			snakeTailX.push(snakeX);
			snakeTailY.push(snakeY);
			drawSnake();}, snakeSpeed);
	}
}

function moveDown(){
	if(keyPressed == "down"){
		snakeY = snakeTailY[snakeTailY.length-1] - snakeRect;
		snakeTailX.push(snakeX);
		snakeTailY.push(snakeY);
		drawSnake();
		refreshInterval = setInterval(function(){
			snakeY = snakeTailY[snakeTailY.length-1] + snakeRect;
			snakeTailX.push(snakeX);
			snakeTailY.push(snakeY);
			drawSnake();}, snakeSpeed);
	}
}

function moveLeft(){
		snakeX = snakeTailX[snakeTailX.length-1] - snakeRect;
		snakeTailX.push(snakeX);
		snakeTailY.push(snakeY);
		drawSnake();
	if(keyPressed == "left"){
		refreshInterval = setInterval(function(){
			snakeX = snakeTailX[snakeTailX.length-1] - snakeRect;
			snakeTailX.push(snakeX);
			snakeTailY.push(snakeY);
			drawSnake();}, snakeSpeed);
	}
}

function moveRight(){
	if(keyPressed == "right"){
		snakeX = snakeTailX[snakeTailX.length-1] + snakeRect;
		snakeTailX.push(snakeX);
		snakeTailY.push(snakeY);
		drawSnake();
		refreshInterval = setInterval(function(){
			snakeX = snakeTailX[snakeTailX.length-1] + snakeRect;
			snakeTailX.push(snakeX);
			snakeTailY.push(snakeY);
			drawSnake();}, snakeSpeed);
	}
}