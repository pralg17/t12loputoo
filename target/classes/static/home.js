            var connection = new XMLHttpRequest();
			connection.onreadystatechange=dataReceived;
			function salvestatoituaine(){
				var toiduaine = document.getElementById("toiduaine").value;
				var kalorid = document.getElementById("kalorid").value;
				var valk = document.getElementById("valk").value;
				var rasv = document.getElementById("rasv").value;
				var sysivesikud = document.getElementById("sysivesikud").value;
				connection.open("GET", "lisa?toiduaine="+toiduaine+"&kalorid="+kalorid+"&valk="+valk+"&rasv="+rasv+"&sysivesikud="+sysivesikud, true);
				connection.send();
				kustuta();
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
				var toiduaine1 = document.getElementById("toiduaine1").value;
				var kogus = document.getElementById("kogus").value;

				connection2.open("GET", "leia?toiduaine="+toiduaine1+"&kogus="+kogus, true);
				connection2.send();
			}
			function dataReceived2(){
			
				document.getElementById("vastusleia").innerHTML=connection2.responseText;
				
			}

            