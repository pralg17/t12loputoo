
var indeks;
var lisatudKohad;
var aadress;

var kysiId = new XMLHttpRequest();
kysiId.onreadystatechange = idSaabus;
var yhendus = new XMLHttpRequest();
yhendus.onreadystatechange = kysiTabel;
var yhendus1 = new XMLHttpRequest();
yhendus1.onreadystatechange = kysiTabel;
var yhendus2 = new XMLHttpRequest();
yhendus2.onreadystatechange = andmedSaabusid;

function lisaTeekond(){                                //1
	aadress = "/lisateekond"; 
	kysiId.open("GET", aadress, true);
	kysiId.send();
}

function kustuta(x){
	aadress = "/kustuta?id=" + x;
	yhendus.open("GET", aadress, true);
	yhendus.send();
	indeks = null;
	document.getElementById("sisestateekond").innerHTML = "Loo uus teekond";
	algv22rtustaTekstid();
	tyhistaSisestused();
}

function idSaabus(){                                //2
	lisatudKohad = 1;
	indeks = kysiId.responseText;
	console.log("teekonna indeks: " + indeks);
	document.getElementById("sisestateekond").innerHTML = "Teekond on loodud";
	//algv22rtustaTekstid();
	//tyhistaSisestused();
}

function muudaId(x){
	indeks = x;
	tyhistaSisestused();	
}

function lisaKiirus(){                          //3
	
	if(indeks == null){
		document.getElementById("sisestakiirus").innerHTML = "Loo kõigepealt teekond";
	} else {
		var kiirus = document.getElementById("kmh").value;
		if(kiirus == ""){
			document.getElementById("sisestakiirus").innerHTML = "Keskmist kiirust ei lisatud";
		}else{
			if (document.getElementById("ms").checked){
			kiirus = kiirus * 18 / 5;  //  m/s -> km/h
			}
			aadress = "/lisakiirus?kiirus=" + kiirus + "&id=" + indeks;
			console.log("kiiruse aadress: " + aadress);
			document.getElementById("sisestakiirus").innerHTML = "Keskmine kiirus lisatud";
			document.getElementById("kiirusenupp").innerHTML = "Muuda kiirust";
			yhendus.open("GET", aadress, true);
			yhendus.send();
		}
	}	
}

function lisaAeg(){                                 //4
	console.log("alustan aja lisamist");

	if(indeks == null){
		document.getElementById("sisestastart").innerHTML = "Loo kõigepealt teekond";
		console.log("olen nulli all");
	} else {
		console.log("ei ole null");
		var aeg = new Date();
		var aasta;
		var kuu;
		var kuupäev;
		var tund;
		var minut;
		if(document.getElementById("praegu").checked){
			aasta = aeg.getFullYear();
			kuu = aeg.getMonth() + 1;
			kuupäev = aeg.getDate();
			tund = aeg.getHours();
			minut = aeg.getMinutes();
		} else {
			aasta = (document.getElementById("aasta").value);
			kuu = document.getElementById("kuu").value;
			kuupäev = document.getElementById("kuupäev").value;
			tund = document.getElementById("tund").value;
			minut = document.getElementById("minut").value;
		}
		if(tund == "" || minut == ""){
			document.getElementById("sisestastart").innerHTML = "Teekonna algusaega ei määratud";
			console.log("tund minut määramata");
		} else {
			if(aasta == ""){
				aasta = aeg.getFullYear();
			}
			if(kuu == ""){
				kuu = aeg.getMonth() + 1;
			}
			if(kuupäev == ""){
				kuupäev = aeg.getDate();
			}
			var algus= "aasta=" +aasta + "&kuu=" + kuu + "&kuupäev=" + kuupäev + "&tund="+ tund + "&minut="+ minut;
			aadress = "/lisastart2?id=" + indeks + "&" + algus;
			console.log("aja aadress: " + aadress);	
			document.getElementById("sisestastart").innerHTML = "Teekonna algusaeg määratud";
			document.getElementById("ajanupp").innerHTML = "Muuda algusaega";
			yhendus.open("GET", aadress, true);
			yhendus.send();	
		}
	}

}


function lisaKoht(){
	if(indeks == null){
		document.getElementById("sisestakoht").innerHTML = "Loo kõigepealt teekond";
	} else {
		var lat = document.getElementById("lat").value;
		var lon = document.getElementById("lon").value;
		var kohanimi = document.getElementById("kohanimi").value;
			
		if(lat == "" || lon == ""){
			if(kohanimi == ""|| kohanimi.length < 3){
				document.getElementById("sisestakoht").innerHTML = "Sisesta kohanimi";
			} else {
				aadress = "/lisakoht?andmed=" + kohanimi + "&id=" + indeks;
				document.getElementById("sisestakoht").innerHTML = "Lisati: " + kohanimi;
				console.log("koha aadress: " + aadress);
			} 
		} else{
			if(kohanimi == ""){
				kohanimi = "Koht " + lisatudKohad;
			}
			aadress = "/lisakoht?andmed=" + kohanimi + "," + lat + "," + lon + "&id=" + indeks;
			document.getElementById("sisestakoht").innerHTML = "Lisati: " + kohanimi;
			console.log("koha aadress: " + aadress);
		}
		lisatudKohad = lisatudKohad + 1;
		yhendus1.open("GET", aadress, true);
		yhendus1.send();
	}
		
}
function kysiTabel(){
	aadress = "/andmed"; 
	yhendus2.open("GET", aadress, true);
	yhendus2.send();
}

function andmedSaabusid(){
	document.getElementById("andmed").innerHTML = yhendus2.responseText;
	document.getElementById("lat").value = "";
	document.getElementById("lon").value = "";
	document.getElementById("kohanimi").value = "";	
}

function tyhistaSisestused(){
	document.getElementById("kmh").value = "";
	document.getElementById("aasta").value = "";
	document.getElementById("kuu").value = "";
	document.getElementById("kuupäev").value = "";
	document.getElementById("tund").value = "";
	document.getElementById("minut").value = "";
	document.getElementById("ms").checked = false;
	document.getElementById("praegu").checked = false;
}

function algv22rtustaTekstid(){
	document.getElementById("sisestakiirus").innerHTML = "Sisesta keskmine kiirus";
	document.getElementById("sisestastart").innerHTML = "Vali teekonnale algusaeg";
	document.getElementById("sisestakoht").innerHTML = "Lisa läbitavad kohad";
	document.getElementById("ajanupp").innerHTML = "Lisa aeg";
	document.getElementById("kiirusenupp").innerHTML = "Lisa kiirus";
}



