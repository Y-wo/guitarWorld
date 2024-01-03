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

    // Roles
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    // Use Cases
    const HELLO = 'Herzlich Willkommen!';
    CONST FAILURE_MESSAGE = "Es ist ein unerwarteter Fehler aufgetreten:";
}
