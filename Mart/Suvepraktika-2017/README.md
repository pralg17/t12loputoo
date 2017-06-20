# SYNMORF
Loodud Tallinna Ülikooli digitehnoloogiate instituudi suvepraktika raames TLU eesti vahekeele korpuse palvel, et lihtsustada lingvistilise analüüsi hõlbsustamiseks, pakkudes graafilist tagasisidet tekstile tehtud morfoloogilisest analüüsist. Projekti raames kasutatakse eesti keelele konfigureeritud ning eestlaste poole väljaaretatud lingvistika teeki EstNLTK.

## Arenduses osalenud isikud:
* Marko Kollo
* Mart Ambur Jr
* Ingo Mägi
* Jaagup Kippar
* Kais Allkivi
* Pille Eslon 
* Joosep Hint
* Martin Kasak

## Kasutatav tarkvara
* Python v3.5
* Django v1.1.11
* EstNLTK v1.4.1
* pandas v0.20.0 (Pythoni teek)
* numpy  v1.13.0 (Pythoni teek)
* django-multiselectfield v0.1.7 (Pythoni teek)

## Installeerimisjuhend
1. Soovitatav on kasutada Anaconda andmeteaduse raamistiku mis lubab hallata tarkvara moodulisiseseid nõuded ka Pythoni väliste teekidega + virtuaalkeskkondade loomist, selleks minna [lehele](https://www.continuum.io/downloads) ning installige oma opsüsteemile vastav Anaconda versioon. Seda sammu saab ka alternatiivselt vahele jätta.
1. Looge uus conda keskkond Python 3.5-ga, selleks käsurealt käsk 
'''conda create --name estnltk_env python=3.5'''
1. Aktiveerige loodud keskkond: käsurealt käsk. 
    * Windowsis: '''python activate estnltk_env'''
    * Macis, Linuxis: '''python source activate estnltk_env'''
1. Installige estnltk käsuga 
'''conda install -c estnltk -c conda-forge estnltk''', võimalik, et kogu funktsionaalsuse töölesaamiseks on veel vajalik jooksutada käsk '''python -m nltk.downloader punkt'''.
1. Installige [django-multiselectfield](https://pypi.python.org/pypi/django-multiselectfield) eelnevalt loodud virtuaalkeskkonna endale sobival meetodil.
1. Git clone seda reprot, kasutades projekti interpretaatoriks loodud virtuaalkeskkonna sees olevat Pythonit.
1. Liikuge projektis kausta kus asub manage.py ning käivitage veebiserver käsuga '''manage.py runserver'''.
1. Veebileht peaks olema kättesaadav läbi localhost:8000. Käivitades läbi serveri teha tunnel serverisse ning kasutada käsku 
''' manage.py runserver 0.0.0.0:pordinumber''', peale mida on server kättesaadav läbi localhost:localport.


## Kasutusjuhend
* Pange sisse tekst tekstilahtrisse.
* Sisestage n-grammide kogus, praegusel hetkel ei ole soovituslik üle n-grammi üle kahe panna jõudluslike põhjuste tõttu.(nt sõna televiisor 2-gramm oleks te-el-le-ev-vi-ii-is-so-or)
* Sisestage tekstile mingi pealkiri ning valige selle zanr.
* Vajutage nuppu ja oodake.


## Litsents
Antud tarkvara kasutab MIT (Massachusetts Institute of Technology) litsentsi, ehk seda saab kasutda ärieesmärkidel, seda
saab muuta, jagada ning kasutada ilma piiranguta. Autorid ei vastuda kahjude eest ning tarkvara jagamisel
peab see hoidma sama litsensi ja autoriõigusi.


## Pildid
![Tabeli kujul informatsioon](https://www.tlu.ee/~mkollo/SYNMORF/6IfwYqR.png)
![Tähejäriendite külgnevusmaatriks](https://www.tlu.ee/~mkollo/SYNMORF/EWll6uA.png)



