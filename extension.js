var i, website=0, Awebsite=0;
var childDataURL = [];
var childDataWORDS = [];
var word = [];
var AurlArray = [];
var urlArray = [];
var wordsArray = [];
var currentURL = window.location.href;

var bodyHTML = document.body.innerHTML.replace(/<[^>]*>/g, "").toLowerCase();
//console.log(bodyHTML);


document.body.style.opacity = "0.1";
firebase.initializeApp(config);

getAllowedURL();

function getAllowedURL(){
	var ALLOWEDURLRef = firebase.database().ref('ALLOWEDURL');
	ALLOWEDURLRef.on('value', function(snapshot){
		AurlArray = snapshot.val().AllowedURL;
		//console.log("TEST1");
		getBlockedURL();
	});
}

function getBlockedURL(){
	var BLOCKEDURLRef = firebase.database().ref('BLOCKEDURL');
	BLOCKEDURLRef.on('value', function(snapshot){
		//console.log(snapshot.val().BlockedURL);
		urlArray = snapshot.val().BlockedURL;
		getBlockedWORDS();
	});
}

function getBlockedWORDS(){
	var BLOCKEDWORDSRef = firebase.database().ref('BLOCKEDURLWORDS');
	BLOCKEDWORDSRef.on('value', function(snapshot){
		//console.log(snapshot.val());
		wordsArray = snapshot.val().BlockedWords;
		init();
	});
}

function init() {

	console.log(AurlArray);
	console.log(urlArray);
	console.log(wordsArray);

	for(i=0; i<AurlArray.length; i++){
		if(currentURL == AurlArray[i]){
			//console.log("Siin veebilehel ei pea kontrollima");
			Awebsite++;
		}
	}

	if(Awebsite === 0){
		for(i=0; i<urlArray.length; i++) {
			if(currentURL == urlArray[i]){
				console.log("Sobimatu veebileht");
				website++;
				var choiceURL = confirm("See veebileht võib sisaldada sobimatut sisu. Kas soovite lehele jääda?");
				if(choiceURL === false){
					window.history.back();
					console.log("Läheb tagasi");
				} else {
					console.log("Soovib jätkata");
				}
			}
		}

		if(website === 0){
			for(i=0; i<wordsArray.length; i++) {
			//indexOf() returns -1 if the string wasn't found at all
				if(bodyHTML.indexOf(wordsArray[i]) >= 0) {
					//console.log("Selline sõna on olemas");
					word.push(wordsArray[i]);
				} else {
					//console.log("Sellist sõna ei ole olemas");
				}
			}

			if(word.length !== 0){
				var choiceWord = confirm("See veebileht sisaldab märksõnu, mis võivad olla sobimatud. Kas soovite lehele jääda? Sobimatud sõnad: "+word);
				if(choiceWord === false){
					console.log("Kirjutas ei");
					var addToDatabase = confirm("Kas soovite lisada selle veebilehe andmebaasi, et järgmine kord hoiatada?");
					if(addToDatabase === true){
						var addToDatabaseCurrentURL = window.location.href;
						urlArray.push(addToDatabaseCurrentURL);
						firebase.database().ref('BLOCKEDURL/').set({ //Kausta nimi
							BlockedURL: urlArray
						});
					} else {
						window.history.back();
					}
					//window.history.back();
				} else {
					console.log("Oli nõus");
				}

			}
		}
	}
	document.body.style.opacity = "1";
}