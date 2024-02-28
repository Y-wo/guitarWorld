# Projekt Onlineshop "Guitar World"

## Installation

### Systemvoraussetzungen (Windows)

- [Apache, MySQL, PHP^8.0 (XAMPP)](https://www.apachefriends.org/download.html)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-windows)
- [Git for Windows](https://git-scm.com/download/win)
- [npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

### Anleitung

1. Dieses Repository in den Ordner ``C:\xampp\htdocs`` klonen. 
2. ``C:\xampp\htdocs\guitarWorld`` im Terminal öffnen.
3. Datenbank [hier](http://127.0.0.1/phpmyadmin) anlegen: 
   - Auf der linken Seite auf ``Neu`` klicken.
   - bei ``Datenbankname`` ``guitarworld`` eintragen und ``Anlegen`` klicken.
4. Datenbank ``guitarWorld`` auswählen und die Beispiel-Datenbank-Datei (``/example-database/guitarworld.sql``) importieren
5. Gegebenenfalls Daten (Portnummer, Serverversion, User, Passwort) von ``DATABASE_URL`` in ``.env`` an die eigenen lokalen Einstellungen anpassen

6. Composer Pakete installieren:
   ```shell
   composer install
   ```

7. CSS und JavaScript builden:
    ```shell
    npm run build
    ``` 

## Anwendung nutzen
1. Xampp-Module starten: 
    - ``Apache`` 
    - ``MySql`` 

2. Die Anwendung ist [hier](http://localhost/guitarWorld/public/) zu erreichen.