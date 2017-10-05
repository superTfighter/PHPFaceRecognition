# Általános tudnivalók

## Függőségek
* node.js
* composer

## További függőség
gulp-cli
```
sudo npm install gulp-cli -g
```
bower
```
sudo npm install bower -g
```

## Fejlesztői környezet kialakítása
A repóból való clone-ozás után töltsük le a php-s függőségeket
```
$ composer install
```
Projecthez tartozó többi függőség letöltése (opcionális)
```
$ bower install
$ npm install
```

## LESS fordító indítása
Az előző opcionális lépésből az npm install ebben az esetben kötelező.
```
$ screen -S screen_name
$ gulp
```
Az összes app\Resouces\less -ben található .less fájl lefordul a public\css könyvtárba.
Fegyelem: A gulp script úgy van megírva, hogy a .less fájlokat figyeli így ha valami változás van benna akkor rögtön fordítja is .css-re

## Külső JS és CSS csomagok frissítés saját projekten belűl
A project gyökerében adjuk ki az alábbi parancsokat
```
$ bower update
$ gulp build
```

# Project felépítés
```
 -+-- app
  |    |
  |    +-- Actions                                              // Actionök gyűjtőhelye
  |    |
  |    +-- Factories                                            // Factoryk gyűjtőhelye
  |    |
  |    +-- Globals                                              // Globálisan használt függvények és adatok helye
  |    |
  |    +-- Middlewares                                          // Middelwarek gyűjtőhelye
  |    |
  |    +-- Repositories                                         // Repositoryk gyűjtőhelye
  |    |
  |    +-- Resources                                            // Erőforrások gyűjőhelye (Pl.: nyelvi fájlok, tempate fájlok, adatfájlok)
  |    |    |
  |    |    +-- fonts                                           // Egyedi fontok ami nem csomagkezelőből jön
  |    |    |
  |    |    +-- less                                            // Projecthez tartozó less fájlok innen fordít a less fordító
  |    |    |
  |    |    +-- templates                                       // Twiges templetek könyvtára
  |    |         |
  |    |         +-- layouts                                    // A app.twigbe includolt rész layoutok könyvtára 
  |    |         |    |
  |    |         |    +-- _control_sidebar.twig                 // Jobb oldalt lévő skinvélasztó templateje
  |    |         |
  |    |         +-- home                                       // Az együvé tartozó templatek könyvtárba szedegetve
  |    |         |    |         
  |    |         |    +-- index.twig                            // Az adott modul alapértelmezett template fálja
  |    |         |
  |    |         +-- app.twig                                   // Alapértelmezett layout fájl minden "őse""
  |    |
  |    +-- Traits                                              
  |    |    |
  |    |    +-- CoreTrait.php                                   // Constructor és __GET methódus öröklés helyett use-olható
  |    |
  |    +-- app.php                                              // Bootstrap
  |    |
  |    +-- dependecies.php                                      // Használni kívánt külső könyvtárak illetve belső oszályok pédányosítása, konténerbe helyezése
  |    |
  |    +-- middleware.php                                       // Itt regisztrájuk Middlewareket
  |    |
  |    +-- routes.php                                           // Routeok
  |    |
  |    +-- settings.default.php                                 // Alapértelmezett beállítások, saját beállítokhoz másoljuk le ebbe a könyvtárba settings.php néven
  |
  +-- cache                                                     // Cachek  helye
  |    |
  |    +-- twig
  |
  +-- public                                                    // Publikus webroot
  |    | 
  |    +-- assets                                               // Külső könyvátak gyűjőhelye (JS,CSS)
  |    | 
  |    +-- css                                                  // Saját CSS fájok valamint ide furdulnak a less fájlok
  |    | 
  |    +-- images                                               // Képek, iconok helye
  |    | 
  |    +-- js                                                   // Saját JS fájlok helye
  |    | 
  |    +-- .htaccess                                            // Sokások htaccess a routok, rewrite és létező fájlok miatt
  |    | 
  |    +-- index.php                                            // A file. 
  | 
  +-- README.md                                                 // Ez a file amit éppen olvasol
  |
  +-- auth.json                                                 // Alfi\core miatti azonosítás
  |
  +-- bower.json                                                // Bower leíró
  |
  +-- composer.json                                             // Composer leíró
  |
  +-- gulpfile.js                                               // Gulp leíró
  |
  +-- package.json                                              // npm leíró
```

