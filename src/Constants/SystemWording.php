<?php

namespace App\Constants;

abstract class SystemWording
{
    // Registration
    const ERROR_MESSAGE = "Etwas ist leider schiefgelaufen. Bitte wiederholen Sie den Vorgang";
    const SUCCESS_REGISTRATION = "User erfolgreich angelegt. Bitte bestätigen Sie den Link, den wir an Ihre Adresse geschickt haben.";
    const USER_ALREADY_EXISTS = "Diese E-Mail existiert bereits.";
    const ERROR_REGISTRATION = "E-Mail oder Passwort stimmen nicht überein.";
    
    // Login/Logout
    const ERROR_LOGIN = "User existiert nicht oder Passwort ist nicht korrekt.";
    const SUCCESS_LOGIN = "Anmeldung erfolgreich!";
    const SUCCESS_LOGOUT = "Abmeldung erfolgreich. Bis bald";

    // Guitartype
    const GUITAR_TYPE_ALREADY_EXISTS = "Der Gitarrentyp mit den folgenden Daten existiert bereits: <br><br>";
    const SUCCESS_GUITAR_TYPE_CREATION = "Neuer Gitarrentyp erfolgreich angelegt: <br><br>";
    const GUITAR_TYPE_CHANGED = "Gitarrentyp gändert.";
    const GUITAR_TYPE_DELETED = "Gitarrentyp gelöscht: ID - ";
    const GUITAR_TYPE_DELETE_CONFIRMATION = "Sind Sie sicher, dass Sie diesen Gitarrentyp löschen wollen? Alle zugeordneten Gitarren werden ebenfalls gelöscht.";


    // Guitar
    const SUCCESS_GUITAR_CREATION = "Neue Gitarre erfolgreich angelegt.";
    const SUCCESS_GUITAR_DELETED = "Gitarre erfolgreich gelöscht ";
    const GUITAR_ALREADY_EXISTS = "Die Gitarre exitiert bereits";
    const SUCCESS_GUITAR_CHANGE = "Gitarre erfolgreich angepasst.";
    const CHANGE_GUITAR = "change_guitar";
    const CREATE_GUITAR = "create_guitar";
    const NO_GUITAR_FOUND = "Es wurde leider keine Gitarre mit dieser ID gefunden.";
    const GUITAR_DELETE_CONFIRMATION = "Sind Sie sicher, dass Sie diese Gitarre löschen wollen?";

    // Roles
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    // Use Cases
    const HELLO = 'Herzlich Willkommen!';
    const FAILURE_MESSAGE = "Es ist ein unerwarteter Fehler aufgetreten:";

    // Image 
    const UPLOAD_WRONG_TYPE = 'Der Dateityp ist leider nicht erlaubt.';
    const UPLOAD_EXISTS = 'Die Datei existiert bereits.';
    const UPLOAD_TOO_BIG = 'Die Datei ist zu groß.';
    const UPLOAD_SUCCESS = 'Das Bild wurde erfolgreich angelegt: ';
    const IMAGE_GUITAR_REMOVED = "Das Bild wurde erfolgreich entfernt.";
    const IMAGE_DELETE_CONFIRMATION = "Sind Sie sicher, dass Sie dieses Bild löschen wollen?";
    

}
