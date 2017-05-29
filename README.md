# PHP rühmatöö projekt

1. **README.md sisaldab:**
    * suurelt projekti nime;
			* E-pood mis ostab ja müüb erinevaid veine
	
    * suurelt projekti veebirakenduse pilt;
			*
			
	* rühma liikmete nimed; 
			* Ingo Mägi
			* Johan Laas
		
    * eesmärki (3-4 lauset, mis probleemi üritate lahendada);
			* Luua keskkond kus on võimalik firmadel lihtsalt pakkuda oma tooteid
			* ja samas on mugav erinevate vajadustega klientidel osta pakutavat
	
	* kirjeldus (sihtrühm, eripära võrreldes teiste samalaadsete rakendustega – kirjeldada vähemalt 2-3 sarnast rakendust mida eeskujuks võtta);
			* sihtrühm: eraisikud, firmad, poed, pubid, baarid, restoraanid
			* eripära: võimalik nii osta kui müüa tooteid
	
	* funktsionaalsuse loetelu prioriteedi järjekorras:
			* LEHED:
				Leht1:  tutvustus
				leht2: sisselogimine(registreerimine) -> edasi suunamine vastavalt kasutajarollile
						ostja: ees-perenimi, kontakt nr, email, tarne aadress
						müüja: kontakt-isiku ees-perenimi, kontakt nr, email, firma nimi, firma reg.nr, juriidiline aadress, tarne aadress
				leht3: ostja: toodete nimekiri, erisoovide lahter.
							toote pilt, kirjeldus, saadavus-kogus, tarne aeg, hind
				leht4: ostja: ostukorv
				leht5: ostja: andmed, ostuajalugu(arved), etc
				leht6: müüja: lahtrid mis hetkel on müügis antud firma poolt, mis kogused/hinnad/etc
							  (informatiivne leht) lisaks mis hetkel enim müüdav kraam
				leht7: müüja: pakkumiste tegemise leht (uued/vanad tooted), hindade-koguste muutmine, 
				leht8: müüja: firma andmed ja ostuajalugu koos arvetega ja muu seonduvaga
				leht9: müüja: toodete nimekiri nagu ostjal
				leht10: admin: müüjate nimekiri (kliendi andmebaas) nimi, nr, email, aadress,
				leht11: admin: ostjate nimekiri (kliendi andmebaas)
				leht12: admin: müüjatelt tellimise ja ostjatele müümise leht
							lahter ostja sooviga kus saab määrata milliselt müüjalt tellida ja mis kogusega
				leht13: admin: ostu/müügi arved 2 erinevat tabelit, üks ostu arved teine müügi arved, 
								näitab ostjat, müüjat, hinda, tasumist, transpordi staatust, 
		
    * andmebaasi skeem loetava pildina + tabelite loomise SQL laused (kui keegi teine tahab seda tööle panna);
    * **kokkuvõte:** mida õppisid juurde? mis ebaõnnestus? mis oli keeruline? (kirjutab iga tiimi liige).


2. **Veebirakenduse nõuded:**
    * rakendus on terviklik (täidab mingit funktsiooni ja sellega saab midagi teha);
    * terve arenduse ajal on kasutatud _git_'i ja _commit_'ide sõnumid annavad edasi tehtud muudatuste sisu; 
    * kasutusel on vähemalt 6 tabelit;
    * kood on jaotatud klassidesse;
    * koodis kasutatud muutujad/tabelid on inglise keeles;
    * rakendus on piisava funktsionaalsusega ja turvaline;
    * kõik tiimi liikmed on panustanud rakenduse arendusprotsessi.