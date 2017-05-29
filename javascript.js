var valueCounter = {
  "pHead": 0,
  "pLeftHand": 0,
  "pChest": 0,
  "pRightHand": 0,
  "pLeftLeg": 0,
  "pRightLeg":0,
  "head": 0,
  "leftHand": 0,
  "chest": 0,
  "rightHand": 0,
  "leftLeg": 0,
  "rightLeg":0
};
var colors = ["#ffc0cb", "#b3b3b3", "#966d4f"];  // roosa, hõbedane, pruun
var types = ["head", "leftHand", "chest", "rightHand", "leftLeg", "rightLeg"];
var pTypes = ["pHead", "pLeftHand", "pChest", "pRightHand", "pLeftLeg", "pRightLeg"];
var AICreatureParts = document.getElementsByClassName("AICreature");
var playerPoints = 0;
var AIPoints = 0;


window.onload = function(){

  window.addEventListener("click", function(e) {
    console.log(e);
  });

  pHead.addEventListener("click", function() {changeValue(colors, pHead, "pHead");} );
  pHead.addEventListener("mouseover", function() {pointer(pHead);} );

  pLeftHand.addEventListener("click", function() {changeValue(colors, pLeftHand, "pLeftHand");} );
  pLeftHand.addEventListener("mouseover", function() {pointer(pLeftHand);} );

  pChest.addEventListener("click", function() {changeValue(colors, pChest, "pChest");} );
  pChest.addEventListener("mouseover", function() {pointer(pChest);} );

  pRightHand.addEventListener("click", function() {changeValue(colors, pRightHand, "pRightHand");} );
  pRightHand.addEventListener("mouseover", function() {pointer(pRightHand);} );

  pLeftLeg.addEventListener("click", function() {changeValue(colors, pLeftLeg, "pLeftLeg");} );
  pLeftLeg.addEventListener("mouseover", function() {pointer(pLeftLeg);} );

  pRightLeg.addEventListener("click", function() {changeValue(colors, pRightLeg, "pRightLeg");} );
  pRightLeg.addEventListener("mouseover", function() {pointer(pRightLeg);} );

  play.addEventListener("click", function() {startPlay();} );
  play.addEventListener("mouseover", function() {pointer(play);} );

  refresh.addEventListener("click", function() {refreshPage();} );
  refresh.addEventListener("mouseover", function() {pointer(refresh);} );

};


function changeValue(list, object, type) {
  for(var i=0; i<list.length; i++);
    valueCounter[type] += 1;
    if (valueCounter[type] == list.length+1) {
      valueCounter[type] = 1;
    }
    object.style.backgroundColor = list[valueCounter[type]-1];
}

function pointer(object) {
  object.style.cursor = "pointer";
}

function startPlay() {
  console.log("mäng algab");

  for(var i=0; i<AICreatureParts.length; i++) {
    giveAIValue(AICreatureParts[i], types[i]);
  }

  
  
  
  for(var j=0; j<types.length; j++) {
    AIPoints += valuate(valueCounter[types[j]], pTypes);
  }

  for(var k=0; k<types.length; k++) {
    playerPoints += valuate(valueCounter[pTypes[k]], types);
  }
  
  
  
  for(var l=0; l<types.length; l++) {
    AIPoints += valuate2(valueCounter[types[l]], valueCounter[pTypes[l]]);
  }
  
  for(var m=0; m<pTypes.length; m++) {
    playerPoints += valuate2(valueCounter[pTypes[m]], valueCounter[types[m]]);
  }

  


  
  console.log("AI points: " + AIPoints);
  console.log("player points: " + playerPoints);

  var playerScore = document.getElementById('playerScore');
  playerScore.innerHTML = getPlayerScore();

  var AIScore = document.getElementById('AIScore');
  AIScore.innerHTML = getAIScore();

  winner();

}

function randomizer() {
  return Math.floor((Math.random() * 3) + 1);
}

function giveAIValue(object, type) {
  var value = randomizer();
  object.style.backgroundColor = colors[value-1];
  valueCounter[type] = value;
}

function valuate(partValue, list) {
  var points = 0;
  if(partValue==1) {
    for(var i=0; i<list.length; i++) {
      if(valueCounter[list[i]]==2 || valueCounter[list[i]]===0){
        points +=1;
      }
    }
  }
  else if(partValue==2) {
    for(var j=0; j<list.length; j++) {
      if(valueCounter[list[j]]==3 || valueCounter[list[j]]===0){
        points +=1;
      }
    }
  }
  else if(partValue==3) {
    for(var k=0; k<list.length; k++) {
      if(valueCounter[list[k]]==1 || valueCounter[list[k]]===0){
        points +=1;
      }
    }
  }
  return points;
}



function valuate2(subjectPartValue, partValue) {
  var points = 0;
  if(subjectPartValue==1) {
	if(partValue==2 || partValue===0) {
    points += 1;
	}
  }
  if(subjectPartValue==2) {
	if(partValue==3 || partValue===0) {
    points += 1;
	}
  }
  if(subjectPartValue==3) {
	if(partValue==1 || partValue===0) {
    points += 1;
	}
  }
  return points;
}




function refreshPage() {
  window.location.reload();
}

function winner(){

  AIScore.style.backgroundColor = "#eee";
  playerScore.style.backgroundColor = "#eee";

  if(AIPoints===0 && playerPoints===0) {}

  else if(AIPoints>playerPoints) {
    AIScore.style.backgroundColor = "yellow";
  }

  else if(AIPoints<playerPoints) {
    playerScore.style.backgroundColor = "yellow";
  }

  else{
    AIScore.style.backgroundColor = "yellow";
    playerScore.style.backgroundColor = "yellow";
  }

}

function getPlayerScore() {
  this.score = playerPoints;
  return score;
}

function getAIScore() {
  this.score = AIPoints;
  return score;
}
