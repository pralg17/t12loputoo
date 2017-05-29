            var connection = new XMLHttpRequest();
			connection.onreadystatechange=dataReceived;
			function salvestatoituaine(){
				document.getElementById("vastuslisalisa").innerHTML="";
				var toiduaine = document.getElementById("toiduaine").value;
				var kalorid = document.getElementById("kalorid").value;
				var valk = document.getElementById("valk").value;
				var rasv = document.getElementById("rasv").value;
				var sysivesikud = document.getElementById("sysivesikud").value;

				if(toiduaine != '' && kalorid != '' && valk != '' && rasv != '' && sysivesikud != ''){
					console.log("T6hjasi v2ljasi ei ole");
					
					if((isNaN(kalorid)==true) || (isNaN(valk)==true) || (isNaN(rasv)==true)|| (isNaN(sysivesikud)==true)){	
						console.log("Makrod peavad numbrites olema");
						document.getElementById("vastuslisalisa").innerHTML="Makrod peavad numbrites olema";
					}else{
						if(isNaN(toiduaine)==true){
							console.log("Kõik õige ja salvestub");
							connection.open("GET", "lisa?toiduaine="+toiduaine+"&kalorid="+kalorid+"&valk="+valk+"&rasv="+rasv+"&sysivesikud="+sysivesikud, true);
							connection.send();
							kustuta();
						}else{
							console.log("Nimi peab olema tekst");
							document.getElementById("vastuslisalisa").innerHTML="Nimi peab olema tekst";
						}
					}
				}else{
					console.log("mõni väli on tühi");
					document.getElementById("vastuslisalisa").innerHTML="K6ik v2ljad peavad olema t2idetud";
				}
				
			}
			function dataReceived(){
			
				document.getElementById("vastuslisalisa").innerHTML=connection.responseText;
				
			}

            function kustuta(){
                document.getElementById("toiduaine").value = "";
				document.getElementById("kalorid").value = "";
				document.getElementById("valk").value = "";
				document.getElementById("rasv").value = "";
				document.getElementById("sysivesikud").value= "";
            }

            var connection2 = new XMLHttpRequest();
			connection2.onreadystatechange=dataReceived2;
            function leiatoit(){
				document.getElementById("vastuslisalisa").innerHTML="";
				var toiduaine1 = document.getElementById("toiduaine1").value;
				var kogus = document.getElementById("kogus").value;

				if(toiduaine1 != '' && kogus != ''){
					if(isNaN(kogus) != true && isNaN(toiduaine1) == true){
						connection2.open("GET", "leia?toiduaine="+toiduaine1+"&kogus="+kogus, true);
						connection2.send();
					}else{
						if(isNaN(kogus) == true){
							document.getElementById("vastusleia").innerHTML="Kogus peab olema number";
						}else if(isNaN(toiduaine1) != true){
							document.getElementById("vastusleia").innerHTML="Toduaine peab olema tekst";
						}
					}
				}else{
					document.getElementById("vastusleia").innerHTML="Otsdingu v2ljad peavad olema t2idetud";
				}
			}
			function dataReceived2(){
			
				document.getElementById("vastusleia").innerHTML=connection2.responseText;
				
			}

            