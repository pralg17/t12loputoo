

// **** GLOBAALSED MUUTUJAD ****

// kalkulaatori maatriksi mõõdu muutujad
var m1x, m1y, m2x, m2y;

// harjutusmaatriksi mõõdu muutujad
var Em1x, Em1y, Em2x, Em2y;

// massiivid harjutusmaatriksite väärtuste jaoks
var a = [[null, null, null]];
var b = [[null, null, null]];






// ||||| ----- ----- ----- ----- MAATRIKSITE KALKULAATORI OSA ----- ----- ----- ----- |||||


// **** ÜLDINE FUNKTSIOON MAATRIKSITE GENEREERIMISEKS ****

function generateMatrix() {
	
	m1x = document.getElementById("m1x").value;
	m1y = document.getElementById("m1y").value;
	m2x = document.getElementById("m2x").value;
	m2y = document.getElementById("m2y").value;
	
	
	var m1 = document.getElementById("matrix1");
	var m2 = document.getElementById("matrix2");
	var mA = document.getElementById("matrixAnswer");
	var mFA = document.getElementById("matrixFinalAnswer");
	
	if(m1y === m2x) {
		
		console.log("Saab arvutada");
		console.log("Esimene maatriks on m1x x m1y (" + m1x + " x " + m1y + ")");
		console.log("Teine maatriks on m2x x m2y (" + m2x + " x " + m2y + ")");
		
		if(m1 && m2 && mA && mFA) {
			
			m1.innerHTML = "";
			m2.innerHTML = "";
			mA.innerHTML = "";
			mFA.innerHTML = "";
			
			createMatrix1();
			createMatrix2();
			createMatrixAnswer();
			createMatrixFinalAnswer();
			
		} else {
			
			createMatrix1();
			createMatrix2();
			createMatrixAnswer();
			createMatrixFinalAnswer();
		}
		
	} else {
		
		console.log("Ei saa arvutada");
		alert("Ei saa genereerida, muuda maatriksite suuruseid!");
		
	}
}



// **** FUNKTSIOON, MIS GENEREERIB ESIMESE MAATRIKSI ****

function createMatrix1() {
	
	var matrix1Container = document.getElementById("matrix1Container");
	var m1Width = 42 * m1y;
	var m1Height = 28 * m1x;
	matrix1Container.style.width = m1Width + "px";
	matrix1Container.style.height = m1Height + "px";
	
	var matrix1 = document.getElementById("matrix1");
	var tableBody = document.createElement("tbody");
	
	for(var i = 0; i < m1x; i++) {
		var row = document.createElement("tr");
		
		for(var j = 0; j < m1y; j++) {
			var rowId = i + 1;
			var colId = j + 1;
			var cell = document.createElement("input");
			cell.setAttribute("id", "a" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	matrix1.appendChild(tableBody);
}



// **** FUNKTSIOON, MIS GENEREERIB TEISE MAATRIKSI ****

function createMatrix2() {
	
	var matrix2Container = document.getElementById("matrix2Container");
	var m2Width = 42 * m2y;
	var m2Height = 28 * m2x;
	
	var m1Width = 42 * m1y;
	var m2Position = m1Width + 20;
	
	matrix2Container.style.width = m2Width + "px";
	matrix2Container.style.height = m2Height + "px";
	matrix2Container.style.left = m2Position + "px";
	
	var matrix2 = document.getElementById("matrix2");
	var tableBody = document.createElement("tbody");
	
	for(var i = 0; i < m2x; i++) {
		var row = document.createElement("tr");
		
		for(var j = 0; j < m2y; j++) {
			var rowId = i + 1;
			var colId = j + 1;
			var cell = document.createElement("input");
			cell.setAttribute("id", "b" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	matrix2.appendChild(tableBody);
}



// **** FUNKTSIOON, MIS GENEREERIB VAHEPEALSE VASTUSE MAATRIKSI (see on praegu potentsiaalselt placeholder) ****

function createMatrixAnswer() {
	
	var matrixAnswerContainer = document.getElementById("matrixAnswerContainer");
	var mAnswerWidth = 42 * m2y * 3;
	var mAnswerHeight = 28 * m1x;
	
	var m1Width = 42 * m1y;
	var m2Width = 42 * m2y;
	var mAnswerPosition = m1Width + m2Width + 30;
	
	matrixAnswerContainer.style.width = mAnswerWidth + "px";
	matrixAnswerContainer.style.height = mAnswerHeight + "px";
	matrixAnswerContainer.style.left = mAnswerPosition + "px";
	
	var matrixAnswer = document.getElementById("matrixAnswer");
	var tableBody = document.createElement("tbody");
	
	for(var i = 0; i < m1x; i++) {
		var row = document.createElement("tr");
		
		for(var j = 0; j < m2y; j++) {
			var rowId = i + 1;
			var colId = j + 1;
			var cell = document.createElement("input");
			cell.setAttribute("id", "c" + rowId + colId);
			cell.setAttribute("class", "matrixAnswerInput");
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	matrixAnswer.appendChild(tableBody);
}



// **** FUNKTSIOON, MIS GENEREERIB LÕPLIKU VASTUSE MAATRIKSI ****

function createMatrixFinalAnswer() {
	
	var matrixFinalAnswerContainer = document.getElementById("matrixFinalAnswerContainer");
	var mFinalAnswerWidth = 42 * m2y;
	var mFinalAnswerHeight = 28 * m1x;
	
	var m1Width = 42 * m1y;
	var m2Width = 42 * m2y;
	var mAnswerWidth = 42 * m2y * 3;
	var mFinalAnswerPosition = m1Width + m2Width + mAnswerWidth + 40;
	
	matrixFinalAnswerContainer.style.width = mFinalAnswerWidth + "px";
	matrixFinalAnswerContainer.style.height = mFinalAnswerHeight + "px";
	matrixFinalAnswerContainer.style.left = mFinalAnswerPosition + "px";
	
	var matrixFinalAnswer = document.getElementById("matrixFinalAnswer");
	var tableBody = document.createElement("tbody");
	
	for(var i = 0; i < m1x; i++) {
		var row = document.createElement("tr");
		
		for(var j = 0; j < m2y; j++) {
			var rowId = i + 1;
			var colId = j + 1;
			var cell = document.createElement("input");
			cell.setAttribute("id", "d" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	matrixFinalAnswer.appendChild(tableBody);
}



// **** KÄIVITAB ARVUTAMISE ****

function calculateMatrix() {
	
	calculateMatrixAnswer();
	calculateMatrixFinalAnswer();
	
}



// **** GENEREERIB VAHETULEMUSE ****

function calculateMatrixAnswer() {
	
	var c = 1;
	
	for(var x = 1; x <= m1x; x++) {
		
		for(var y = 1; y <= m2y; y++) {
			
			var matrixAnswer = document.getElementById("c"+x+y);
			var matrixAnswerString = "";
			
			for(var i = 0; i < m1y; i++) {
				
				var a = document.getElementById("a"+x+c).value;
				var b = document.getElementById("b"+c+y).value;
				matrixAnswerString += a + "*" + b + " + ";
				c++;
			}
			var strLength = matrixAnswerString.length;
			matrixAnswer.value = matrixAnswerString.slice(0, strLength - 3);	
			c = 1;
		}
	}
}



// **** ARVUTAB MAATRIKSI VÄÄRTUSE ****

function calculateMatrixFinalAnswer() {
	
	var c = 1;
	
	for(var x = 1; x <= m1x; x++) {
		
		for(var y = 1; y <= m2y; y++) {
			
			var matrixAnswer = document.getElementById("d"+x+y);
			var matrixAnswerString = "";
			
			for(var i = 0; i < m1y; i++) {
				
				var a = document.getElementById("a"+x+c).value;
				var b = document.getElementById("b"+c+y).value;
				matrixAnswerString += a + "*" + b + " + ";
				c++;
			}
			var strLength = matrixAnswerString.length;
			matrixAnswer.value = math.eval(matrixAnswerString.slice(0, strLength - 3));	
			c = 1;
		}
	}
}









// ||||| ----- ----- ----- ----- MAATRIKSITE HARJUTAMISE OSA ----- ----- ----- ----- |||||


// **** ÜLDINE FUNKTSIOON MAATRIKSITE GENEREERIMISEKS ****

function generateExerciseMatrix() {
	
	Em1x = document.getElementById("Em1x").value;
	Em1y = document.getElementById("Em1y").value;
	Em2x = document.getElementById("Em2x").value;
	Em2y = document.getElementById("Em2y").value;
	
	
	var Em1 = document.getElementById("exerciseMatrix1");
	var Em2 = document.getElementById("exerciseMatrix2");
	var EmFA = document.getElementById("exerciseMatrixAnswer");
	
	if(Em1y === Em2x) {
		
		console.log("Saab arvutada");
		console.log("Esimene maatriks on Em1x x Em1y (" + Em1x + " x " + Em1y + ")");
		console.log("Teine maatriks on Em2x x Em2y (" + Em2x + " x " + Em2y + ")");
		
		if(Em1 && Em2 && EmFA) {
			
			Em1.innerHTML = "";
			Em2.innerHTML = "";
			EmFA.innerHTML = "";
			
			createExerciseMatrix1();
			createExerciseMatrix2();
			createExerciseMatrixAnswer();
			generateValuesForMatrices();
			
		} else {
			
			createExerciseMatrix1();
			createExerciseMatrix2();
			createExerciseMatrixAnswer();
			generateValuesForMatrices();
		}
		
	} else {
		
		console.log("Ei saa arvutada");
		alert("Ei saa genereerida, muuda maatriksite suuruseid!");
		
	}
}



// **** FUNKTSIOON, MIS GENEREERIB ESIMESE HARJUTUSMAATRIKSI ****

function createExerciseMatrix1() {
	
	var exerciseMatrix1Container = document.getElementById("exerciseMatrix1Container");
	var Em1Width = 42 * Em1y;
	var Em1Height = 28 * Em1x;
	exerciseMatrix1Container.style.width = Em1Width + "px";
	exerciseMatrix1Container.style.height = Em1Height + "px";
	
	var exerciseMatrix1 = document.getElementById("exerciseMatrix1");
	var tableBody = document.createElement("tbody");
	
	for(var rowId = 1; rowId <= Em1x; rowId++) {
		var row = document.createElement("tr");
		
		for(var colId = 1; colId <= Em1y; colId++) {
			var cell = document.createElement("input");
			cell.setAttribute("id", "Ea" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
		}
		tableBody.appendChild(row);
	}
	exerciseMatrix1.appendChild(tableBody);
}



// **** FUNKTSIOON, MIS GENEREERIB TEISE HARJUTUSMAATRIKSI ****

function createExerciseMatrix2() {
	
	var exerciseMatrix2Container = document.getElementById("exerciseMatrix2Container");
	var Em2Width = 42 * Em2y;
	var Em2Height = 28 * Em2x;
	
	var Em1Width = 42 * Em1y;
	var Em2Position = Em1Width + 20;
	
	exerciseMatrix2Container.style.width = Em2Width + "px";
	exerciseMatrix2Container.style.height = Em2Height + "px";
	exerciseMatrix2Container.style.left = Em2Position + "px";
	
	var exerciseMatrix2 = document.getElementById("exerciseMatrix2");
	var tableBody = document.createElement("tbody");
	
	for(var rowId = 1; rowId <= Em2x; rowId++) {
		var row = document.createElement("tr");
		
		for(var colId = 1; colId <= Em2y; colId++) {
			var cell = document.createElement("input");
			cell.setAttribute("id", "Eb" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	exerciseMatrix2.appendChild(tableBody);
}



// **** FUNKTSIOON, MIS GENEREERIB VASTUSEMAATRIKSI ****

function createExerciseMatrixAnswer() {
	
	var exerciseMatrixAnswerContainer = document.getElementById("exerciseMatrixAnswerContainer");
	var EmAnswerWidth = 42 * Em2y;
	var EmAnswerHeight = 28 * Em1x;
	
	var Em1Width = 42 * Em1y;
	var Em2Width = 42 * Em2y;
	var EmAnswerPosition = Em1Width + Em2Width + 30;
	
	exerciseMatrixAnswerContainer.style.width = EmAnswerWidth + "px";
	exerciseMatrixAnswerContainer.style.height = EmAnswerHeight + "px";
	exerciseMatrixAnswerContainer.style.left = EmAnswerPosition + "px";
	
	var exerciseMatrixAnswer = document.getElementById("exerciseMatrixAnswer");
	var tableBody = document.createElement("tbody");
	
	for(var rowId = 1; rowId <= Em1x; rowId++) {
		var row = document.createElement("tr");
		
		for(var colId = 1; colId <= Em2y; colId++) {
			var cell = document.createElement("input");
			cell.setAttribute("id", "Ec" + rowId + colId);
			cell.setAttribute("type", "text");
			row.appendChild(cell);
			
		}
		tableBody.appendChild(row);
	}
	exerciseMatrixAnswer.appendChild(tableBody);
}



// **** KÄIVITAB ARVUDE GENEREERIMISE MAATRIKSISSE ****

function generateValuesForMatrices() {
	
	generateValuesForMatrix1();
	generateValuesForMatrix2();
	
}



// **** GENEREERIB VÄÄRTUSED ESIMESSE MAATRIKSISSE JA MASSIIVI ****

function generateValuesForMatrix1() {
	
	for(var rowId = 1; rowId <= Em1x; rowId++) {
		
		var matrixRow = [null];
		
		for(var colId = 1; colId <= Em1y; colId++) {
			
			var randomValue = Math.floor((Math.random() * 10) + 1);
			matrixRow.push(randomValue);
			var matrixCell = document.getElementById("Ea"+rowId+colId);
			matrixCell.value = randomValue;
		}
		a.push(matrixRow);
		matrixRow = [null];
	}
}



// **** GENEREERIB VÄÄRTUSED TEISE MAATRIKSISSE JA MASSIIVI ****

function generateValuesForMatrix2() {
	
	for(var rowId = 1; rowId <= Em2x; rowId++) {
		
		var matrixRow = [null];
		
		for(var colId = 1; colId <= Em2y; colId++) {
			
			var randomValue = Math.floor((Math.random() * 10) + 1);
			matrixRow.push(randomValue);
			var matrixCell = document.getElementById("Eb"+rowId+colId);
			matrixCell.value = randomValue;
		}
		b.push(matrixRow);
		matrixRow = [null];
	}
}



// **** KONTROLLIB MAATRIKSITE VASTUSEID ****

function checkMatrixAnswers() {
	
	c = 1;
	
	for(var rowId = 1; rowId <= Em1x; rowId++) {
		
		for(var colId = 1; colId <= Em2y; colId++) {
			
			var matrixAnswer = document.getElementById("Ec"+rowId+colId);
			var matrixAnswerString = "";
			
			for(var i = 0; i < Em1y; i++) {
				
				var Ea = document.getElementById("Ea"+rowId+c).value;
				var Eb = document.getElementById("Eb"+c+colId).value;
				matrixAnswerString += Ea + "*" + Eb + " + ";
				c++;
			}
			var strLength = matrixAnswerString.length;
			var matrixCellValue = math.eval(matrixAnswerString.slice(0, strLength - 3));
			var matrixInputCell = parseInt(matrixAnswer.value);
			c = 1;
			
			console.log(matrixInputCell);
			console.log(matrixCellValue);
			
			if(matrixInputCell == matrixCellValue) {
				matrixAnswer.style.color = "green";
			} else {
				matrixAnswer.style.color = "red";
			}
			
		}
	}
	
}




