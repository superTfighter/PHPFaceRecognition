# PHPFaceRecognition


## Projekt célja
Ezt a projektet azért készítettem,hogy bebizonyítsam,hogy van haszna olyan weboldalakat készíteni,amelyek képekesek arc alapú azonosításra.
Ebben a kis alkalmazásban lehetőség van új felhasználók létrehozására és a regisztrációs folyamat során megadhatjuk,hogy képesek legyünk későbbi arca alapú belépésre is.
Ha élünk ezzel a lehetőséggel a webkameránk segítségével készítenünk kell 3db fotót magunkról(követni az alkalmazás utasításait) és ezek után nem csak a hagyományos módon,hanem arcfelismeréssel is képesek leszünk beazonosítani.
A projekt egy JS scriptet használ az arc azonosítására(így validálva,hogy egyáltalán van-e arc az adott képen), majd ezt a képet a backend felé közvetítve egy API-val beszélget.
Apinak a Luxand megoldását választottam,mivel a projektem fő célja az volt,hogy bemutassam,hogy egyáltalán lehetséges-e ez a dolog és ,hogy képes egy elég gyors,kényelmes és megbízható működésre.

# Hasznos dokumentációk

* [Slim Framework](https://www.slimframework.com/)
* [Twig](https://twig.symfony.com/doc/2.x/)
* [Luxand](https://luxand.cloud/)
