# t12loputoo

## Config faili sisu

```JS
var config = {
    apiKey: "AIzaSyDGmQcgKaVbrM8-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
    authDomain: "XXXXXXXX.firebaseapp.com",
    databaseURL: "XXXXXXXXXfirebaseio.com",
    projectId: "XXXXXXXX-XXX",
    storageBucket: "XXXXXXXXX.appspot.com",
    messagingSenderId: "XXXXXXXXXXXXXX"
  };

  firebase.initializeApp(config);
```

## Kirjeldus

Tegu on lihtsa Chrome extensioniga.

1. Extension laseb kasutajal salvestada enda lemmiklehti koos tag-iga.
1. Andmebaasi salvestatakse lehekülg, selle tag ning salvestamise aeg(kuupäev ja kellaaeg).
1. Vajutades extensioni ikoonile, avab see eraldi lehe, kus saab kasutaja enda lemmiklehti külastada
või kustutada.